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
                    <ul>
                        <li class="flex justify-between items-center">
                            <a href="">Friend</a>
                            <button>Unfriend</button>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-2">
                    <div class="text-gray-900 font-semibold">
                        Requests
                    </div>
                    <ul>
                        <li class="flex justify-between items-center">
                            <a href="">Friend</a>
                            <div class="space-x-2">
                                <button>Accept</button>
                                <button>Reject</button>
                            </div>

                        </li>
                    </ul>
                </div>

            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-2">
                    <div class="text-gray-900 font-semibold">
                        Pending friend requests
                    </div>
                    <ul>
                        <li class="flex justify-between items-center">
                            <a href="">Friend</a>
                            <div class="space-x-2">
                                <button>Cancel</button>
                            </div>

                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
