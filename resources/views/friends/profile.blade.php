<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$user->name}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @auth
                    @if(auth()->user()->id !== $user->id)
                        <div class="p-6 space-y-2">
                            @php
                                $friend = auth()->user()->getRequestToFriendUser($user->id);
                            @endphp

                            @if(auth()->user()->isFriend($user))
                                    <form action="{{route('friends.destroy', $user)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <x-primary-button>{{(!$friend || $friend->pivot->accepted == 1) ? 'Unfriend' :  'Cancel pending friend request'}}</x-primary-button>
                                    </form>
                            @else
                                <form action="{{route('friends.store', $user->id)}}" method="post">
                                    @csrf
                                    <input type="hidden" name="receiver_id" value="{{$user->id}}">
                                    <x-primary-button>{{!$friend ? 'Add friend' : 'Cancel pending friend request'}}</x-primary-button>
                                </form>
                            @endif
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>
