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
                                $friendTo = auth()->user()->getRequestToFriendUser($user->id);
                                $friendFrom = auth()->user()->getRequestFromFriendUser($user->id);
                            @endphp

                            @if(auth()->user()->isFriend($user))
                                <form action="{{route('friends.destroy', $user)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <x-primary-button>Unfriend</x-primary-button>
                                </form>
                            @else
                                @if($friendFrom)
                                    <span class="my-2">
                                            {{$friendFrom->name}} is already send you friend request. Do you want to accept it?
                                        </span>
                                    <form action="{{route('friends.accept', $friendFrom)}}" method="post">
                                        @csrf
                                        @method('patch')
                                        <button
                                            class="bg-green-500 text-white px-4 py-2 rounded-sm hover:bg-green-400 transition">
                                            Accept
                                        </button>
                                    </form>

                                    <form action="{{route('friends.destroy', $friendFrom)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button
                                            class="bg-red-500 text-white px-4 py-2 rounded-sm hover:bg-red-400 transition">
                                            Reject
                                        </button>
                                    </form>
                                @elseif($friendTo)
                                    <form action="{{route('friends.destroy', $friendTo->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <x-primary-button>Cancel pending friend request</x-primary-button>
                                    </form>
                                @else
                                    <form action="{{route('friends.store', $user->id)}}" method="post">
                                        @csrf
                                        <x-primary-button>Add friend</x-primary-button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>
