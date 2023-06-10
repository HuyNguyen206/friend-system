<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FriendController extends Controller
{
    public function index(Request $request)
    {
        $requestedToFriends = $request->user()->pendingRequestedToFriends;
        $requestedFromFriends = $request->user()->pendingRequestedFromFriends;
        $friends = $request->user()->friends();

        return view('friends.index', compact('requestedToFriends', 'requestedFromFriends', 'friends'));
    }

    public function profile(User $user)
    {
        return view('friends.profile', compact('user'));
    }

    public function store(Request $request, User $user)
    {
        if ($friend = $request->user()->getRequestToFriendUser($user->id)) {
            if ($friend->pivot->accepted) {
                $message = 'You already are friend with this person';
            } else {
                $message = 'You already send friend request to this person';
            }

            abort(400, $message);
        }

        $request->user()->requestedToFriends()->attach($user);

        return back();
    }

    public function destroy(Request $request, User $user)
    {
        if ($request->user()->requestedToFriends()->detach($user)) {
            return back();
        }

        $request->user()->requestedFromFriends()->detach($user);

        return back();
    }

    public function accept(Request $request, User $user)
    {
        $request->user()->pendingRequestedFromFriends()->updateExistingPivot($user->id, [
            'accepted' => 1
        ]);

        return back();
    }
}
