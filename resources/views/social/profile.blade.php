<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}'s Profile
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Profile Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-start justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-20 h-20 rounded-full bg-indigo-600 flex items-center justify-center text-white text-3xl font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-gray-600">{{ $user->email }}</p>
                            <div class="flex space-x-4 mt-2 text-sm">
                                <a href="{{ route('social.followers', $user) }}" class="text-gray-700 hover:text-indigo-600">
                                    <span class="font-semibold">{{ $followersCount }}</span> Followers
                                </a>
                                <a href="{{ route('social.following', $user) }}" class="text-gray-700 hover:text-indigo-600">
                                    <span class="font-semibold">{{ $followingCount }}</span> Following
                                </a>
                            </div>
                        </div>
                    </div>

                    @if(auth()->id() !== $user->id)
                    <div>
                        @if($isFollowing)
                        <form action="{{ route('social.unfollow', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                Unfollow
                            </button>
                        </form>
                        @else
                        <form action="{{ route('social.follow', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Follow
                            </button>
                        </form>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Public Collections -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Public Collections</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($collections as $collection)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                        <h4 class="font-semibold text-gray-900 mb-2">
                            <a href="{{ route('collections.show', $collection) }}" class="hover:text-indigo-600">
                                {{ $collection->name }}
                            </a>
                        </h4>
                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($collection->description, 100) }}</p>
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span>{{ $collection->verses_count ?? 0 }} verses</span>
                            <div class="flex space-x-3">
                                <span>❤️ {{ $collection->likes_count }}</span>
                                <span>💬 {{ $collection->comments_count }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3 text-center text-gray-500 py-8">
                        No public collections yet.
                    </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $collections->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
