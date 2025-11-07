<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Verse Collections') }}
            </h2>
            <a href="{{ route('collections.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                + New Collection
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- My Collections Section -->
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">My Collections</h3>
                
                @if($myCollections->isEmpty())
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No collections yet</h3>
                        <p class="mt-2 text-sm text-gray-500 mb-4">
                            Create your first collection to organize your favorite verses
                        </p>
                        <a href="{{ route('collections.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition">
                            Create Collection
                        </a>
                    </div>
                @else
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($myCollections as $collection)
                            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-6">
                                <div class="flex justify-between items-start mb-3">
                                    <h4 class="text-lg font-semibold text-gray-900">
                                        {{ $collection->name }}
                                    </h4>
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $collection->is_public ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $collection->is_public ? 'Public' : 'Private' }}
                                    </span>
                                </div>
                                
                                @if($collection->description)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        {{ $collection->description }}
                                    </p>
                                @endif

                                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                    <span>{{ $collection->verses_count }} {{ Str::plural('verse', $collection->verses_count) }}</span>
                                    <span>{{ $collection->created_at->diffForHumans() }}</span>
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ route('collections.show', $collection->slug) }}" class="flex-1 text-center px-3 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-md text-sm font-medium transition">
                                        View
                                    </a>
                                    <a href="{{ route('collections.edit', $collection->slug) }}" class="flex-1 text-center px-3 py-2 bg-gray-50 text-gray-700 hover:bg-gray-100 rounded-md text-sm font-medium transition">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Public Collections Section -->
            <div>
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Public Collections</h3>
                
                @if($publicCollections->isEmpty())
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 text-center">
                        <p class="text-gray-500">No public collections available yet.</p>
                    </div>
                @else
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($publicCollections as $collection)
                            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-6">
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">
                                    {{ $collection->name }}
                                </h4>
                                
                                <p class="text-sm text-gray-600 mb-2">
                                    by <span class="font-medium">{{ $collection->user->name }}</span>
                                </p>

                                @if($collection->description)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        {{ $collection->description }}
                                    </p>
                                @endif

                                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                    <span>{{ $collection->verses_count }} {{ Str::plural('verse', $collection->verses_count) }}</span>
                                    <span>{{ $collection->created_at->diffForHumans() }}</span>
                                </div>

                                <a href="{{ route('collections.show', $collection->slug) }}" class="block text-center px-4 py-2 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-md text-sm font-medium transition">
                                    View Collection
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $publicCollections->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
