<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Discover Users
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($users as $user)
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-16 h-16 rounded-full bg-indigo-600 flex items-center justify-center text-white text-2xl font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">
                                    <a href="{{ route('social.profile', $user) }}" class="hover:text-indigo-600">
                                        {{ $user->name }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-600">{{ $user->verse_collections_count }} collections</p>
                                <p class="text-sm text-gray-500">{{ $user->followers_count }} followers</p>
                            </div>
                        </div>

                        @if(auth()->user()->isFollowing($user))
                        <form action="{{ route('social.unfollow', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                Unfollow
                            </button>
                        </form>
                        @else
                        <form action="{{ route('social.follow', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Follow
                            </button>
                        </form>
                        @endif
                    </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
