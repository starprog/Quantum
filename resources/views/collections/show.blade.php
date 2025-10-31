<x-app-layout>
    <div class="min-h-screen" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8">
                    <a href="{{ route('collections.index') }}" class="inline-flex items-center text-purple-100 hover:text-white mb-4 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to All Collections
                    </a>
                    
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-6 h-6 rounded-full" style="background-color: {{ $collection->color }};"></div>
                                <h1 class="text-4xl font-bold text-white">{{ $collection->name }}</h1>
                            </div>
                            @if($collection->description)
                                <p class="text-purple-100 text-lg">{{ $collection->description }}</p>
                            @endif
                            <p class="text-purple-200 text-sm mt-2">
                                {{ $collection->versesCount() }} {{ $collection->versesCount() === 1 ? 'verse' : 'verses' }}
                            </p>
                        </div>
                        <a href="{{ route('collections.edit', $collection) }}" class="inline-flex items-center px-6 py-3 bg-white text-purple-600 font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Collection
                        </a>
                    </div>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Verses -->
                @if($collection->verses->count() > 0)
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        @foreach($collection->verses as $verse)
                            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition-all duration-300">
                                <!-- Category Badge -->
                                <div class="mb-4">
                                    <span class="inline-block px-3 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">
                                        {{ $verse->category->name ?? 'Uncategorized' }}
                                    </span>
                                </div>

                                <!-- Verse Text -->
                                <p class="text-gray-800 text-lg leading-relaxed mb-4">
                                    "{{ $verse->text }}"
                                </p>

                                <!-- Reference -->
                                <p class="text-purple-600 font-bold mb-4">
                                    — {{ $verse->book }} {{ $verse->chapter }}:{{ $verse->verse }}
                                </p>

                                <!-- Actions -->
                                <div class="flex gap-2">
                                    <a href="{{ route('bible-verse') }}?verse={{ $verse->id }}" class="flex-1 text-center px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition-colors duration-200 font-medium">
                                        View Details
                                    </a>
                                    <form action="{{ route('collections.remove-verse', [$collection, $verse]) }}" method="POST" onsubmit="return confirm('Remove this verse from the collection?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors duration-200" title="Remove from collection">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                        <svg class="w-24 h-24 mx-auto mb-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">No Verses Yet</h3>
                        <p class="text-gray-600 mb-6">Start adding verses to this collection</p>
                        <a href="{{ route('bible-verse') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Browse Bible Verses
                        </a>
                    </div>
                @endif

                <!-- Add Verse Section -->
                <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Add Verses to This Collection</h3>
                    <p class="text-gray-600 mb-4">Browse verses on the <a href="{{ route('bible-verse') }}" class="text-purple-600 hover:underline">Bible Verses page</a> or your <a href="{{ route('favorites.index') }}" class="text-purple-600 hover:underline">Favorites</a> to add them to this collection.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
