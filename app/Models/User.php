<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function requestedToFriends()
    {
        return $this->belongsToMany(User::class, 'friends', 'sender_id', 'receiver_id')
            ->withTimestamps()
            ->withPivot('accepted');
    }

    public function requestedFromFriends()
    {
        return $this->belongsToMany(User::class, 'friends', 'receiver_id', 'sender_id')
            ->withTimestamps()
            ->withPivot('accepted');
    }

    public function pendingRequestedToFriends()
    {
        return $this->requestedToFriends()->wherePivot('accepted', false);
    }

    public function pendingRequestedFromFriends()
    {
        return $this->requestedFromFriends()->wherePivot('accepted', false);
    }

    public function acceptedRequestedToFriends()
    {
        return $this->requestedToFriends()->wherePivot('accepted', true);
    }

    public function acceptedRequestedFromFriends()
    {
        return $this->requestedFromFriends()->wherePivot('accepted', true);
    }

    public function getRequestToFriendUser(int|User $value)
    {
        if (!is_int($value)) {
            $value = $value->id;
        }

        return $this->requestedToFriends()->where('users.id', $value)->first();
    }

    public function getRequestFromFriendUser(int|User $value)
    {
        if (!is_int($value)) {
            $value = $value->id;
        }

        return $this->requestedFromFriends()->where('users.id', $value)->first();
    }

    public function isFriend(User $user): bool
    {
       return $this->acceptedRequestedToFriends()->where('users.id', $user->id)->exists()
           || $this->acceptedRequestedFromFriends()->where('users.id', $user->id)->exists();
    }

    public function friends($withStatus = [])
    {
        return Friend::query()
            ->when(count($withStatus), function ($builder) use ($withStatus) {
                $builder->with($withStatus);
            }, function ($builder){
                $builder->latest('friends.created_at');
            })
            ->join('users as userSender', 'friends.sender_id', '=', 'userSender.id')
            ->join('users as userReceiver', 'friends.receiver_id', '=', 'userReceiver.id')
            ->where(function ($query){
                $query->where('sender_id', $this->id)
                      ->orWhere('receiver_id', $this->id);
            })
            ->where('accepted', true)
            ->get([
                'userSender.id as sender_id',
                'userSender.name as sender_name',
                'userReceiver.id as receiver_id',
                'userReceiver.name as receiver_name',
            ])
            ->map(function ($friend){
                if ($friend->sender_id !== $this->id) {
                    $data['id'] = $friend->sender_id;
                    $data['name'] = $friend->sender_name;
                    if ($friend->relationLoaded('sender')) {
                        $data['statuses'] = $friend->sender?->statuses;
                    }

                    return (object) $data;
                }

                if ($friend->receiver_id !== $this->id) {
                    $data['id'] = $friend->receiver_id;
                    $data['name'] = $friend->receiver_name;
                    if ($friend->relationLoaded('receiver')) {
                        $data['statuses'] = $friend->receiver?->statuses;
                    }

                    return (object) $data;
                }
            })->sortByDesc(function ($f){
                if (property_exists($f, 'statuses')) {
                    return $f->statuses->max('created_at');
                }
                return  0;
            });
    }

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }
}
