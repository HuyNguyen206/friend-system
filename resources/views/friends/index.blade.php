<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Friends
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-3 gap-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-2">
                    <div class="text-gray-900 font-semibold">
                        Friends
                    </div>
                    <ul class="space-y-2">
                        @foreach($friends as $friend)
                            <li class="flex justify-between items-center">
                                <a class="text-blue-700 font-semibold" href="{{route('friends.profile', $friend->id)}}">{{$friend->name}}</a>
                                <form action="{{route('friends.destroy', $friend->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="bg-red-500 text-white px-4 py-2 rounded-sm hover:bg-red-400 transition">Unfriend</button>
                                </form>
                            </li>
                        @endforeach

                    </ul>
                </div>

            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-2">
                    <div class="text-gray-900 font-semibold">
                        Requests
                    </div>
                    <ul>
                        @foreach($requestedFromFriends as $friendRequest)
                            <li class="flex justify-between items-center">
                                <a class="text-blue-700 font-semibold" href="{{route('friends.profile', $friendRequest)}}">{{$friendRequest->name}}</a>
                                <div class="space-x-2 flex justify-between items-center">
                                    <form action="{{route('friends.accept', $friendRequest)}}" method="post">
                                        @csrf
                                        @method('patch')
                                        <button class="bg-green-500 text-white px-4 py-2 rounded-sm hover:bg-green-400 transition">Accept</button>
                                    </form>

                                    <form action="{{route('friends.destroy', $friendRequest)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="bg-red-500 text-white px-4 py-2 rounded-sm hover:bg-red-400 transition">Reject</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-2">
                    <div class="text-gray-900 font-semibold">
                        Pending friend requests
                    </div>
                    <ul class="space-y-2">
                        @foreach($requestedToFriends as $friendTo)
                            <li class="flex justify-between items-center">
                                <a  class="text-blue-700 font-semibold" href="{{route('friends.profile', $friendTo)}}">{{$friendTo->name}}</a>
                                <form action="{{route('friends.destroy', $friendTo)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="bg-red-500 text-white px-4 py-2 rounded-sm hover:bg-red-400 transition">Cancel</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
