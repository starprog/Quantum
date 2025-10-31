<x-app-layout>
    <div class="min-h-screen" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-2">My Verse Collections</h1>
                        <p class="text-purple-100">Organize your favorite verses into themed collections</p>
                    </div>
                    <a href="{{ route('collections.create') }}" class="inline-flex items-center px-6 py-3 bg-white text-purple-600 font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        New Collection
                    </a>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Collections Grid -->
                @if($collections->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($collections as $collection)
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                                <!-- Color Bar -->
                                <div class="h-2" style="background-color: {{ $collection->color }};"></div>
                                
                                <div class="p-6">
                                    <!-- Collection Header -->
                                    <div class="mb-4">
                                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $collection->name }}</h3>
                                        @if($collection->description)
                                            <p class="text-gray-600 text-sm line-clamp-2">{{ $collection->description }}</p>
                                        @endif
                                    </div>

                                    <!-- Stats -->
                                    <div class="mb-4 flex items-center text-gray-500">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        <span class="font-semibold">{{ $collection->verses_count }}</span>
                                        <span class="ml-1">{{ $collection->verses_count === 1 ? 'verse' : 'verses' }}</span>
                                    </div>

                                    <!-- Date -->
                                    <div class="text-xs text-gray-400 mb-4">
                                        Created {{ $collection->created_at->diffForHumans() }}
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex gap-2">
                                        <a href="{{ route('collections.show', $collection) }}" class="flex-1 text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200 font-medium">
                                            View
                                        </a>
                                        <a href="{{ route('collections.edit', $collection) }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                        <svg class="w-24 h-24 mx-auto mb-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">No Collections Yet</h3>
                        <p class="text-gray-600 mb-6">Create your first collection to organize your favorite Bible verses</p>
                        <a href="{{ route('collections.create') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create Your First Collection
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
