<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Collection
            </h2>
            <a href="{{ route('collections.show', $collection->slug) }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Back to Collection
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-6">
                
                <!-- Left Column: Collection Details Form -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Collection Details</h3>
                        
                        <form method="POST" action="{{ route('collections.update', $collection->slug) }}" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Name *
                                </label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name" 
                                    value="{{ old('name', $collection->name) }}"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                >
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                    Description
                                </label>
                                <textarea 
                                    name="description" 
                                    id="description" 
                                    rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                >{{ old('description', $collection->description) }}</textarea>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        name="is_public" 
                                        value="1"
                                        {{ old('is_public', $collection->is_public) ? 'checked' : '' }}
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                    >
                                    <span class="ml-2 text-sm text-gray-700">
                                        Public collection
                                    </span>
                                </label>
                            </div>

                            <button 
                                type="submit" 
                                class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition text-sm"
                            >
                                Update Details
                            </button>
                        </form>

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <button 
                                onclick="togglePublic()"
                                class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition text-sm mb-3"
                            >
                                {{ $collection->is_public ? '🔒 Make Private' : '🌍 Make Public' }}
                            </button>

                            <form method="POST" action="{{ route('collections.destroy', $collection->slug) }}" onsubmit="return confirm('Are you sure you want to delete this collection? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button 
                                    type="submit" 
                                    class="w-full px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 rounded-lg font-medium transition text-sm"
                                >
                                    Delete Collection
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Manage Verses -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            Verses in Collection ({{ $collection->verses->count() }})
                        </h3>

                        @if($collection->verses->isEmpty())
                            <div class="text-center py-8 text-gray-500">
                                <p>No verses in this collection yet. Add some below!</p>
                            </div>
                        @else
                            <div class="space-y-3 mb-6">
                                @foreach($collection->verses as $verse)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="text-xs font-medium px-2 py-0.5 bg-blue-100 text-blue-800 rounded">
                                                        {{ $verse->category->name ?? 'Uncategorized' }}
                                                    </span>
                                                    <span class="text-sm font-semibold text-gray-700">
                                                        {{ $verse->reference }}
                                                    </span>
                                                </div>
                                                <p class="text-gray-800 text-sm">
                                                    {{ Str::limit($verse->verse, 150) }}
                                                </p>
                                            </div>
                                            <button 
                                                onclick="removeVerse({{ $verse->id }}, this)"
                                                class="ml-4 text-red-500 hover:text-red-700 transition flex-shrink-0"
                                                title="Remove from collection"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="border-t border-gray-200 pt-6">
                            <h4 class="text-md font-semibold text-gray-900 mb-3">Add Verses</h4>
                            <div class="relative mb-4">
                                <input 
                                    type="text" 
                                    id="verseSearch" 
                                    placeholder="Search verses by reference or content..."
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    onkeyup="filterVerses()"
                                >
                            </div>
                            <div id="versesList" class="max-h-96 overflow-y-auto space-y-2">
                                @foreach($availableVerses as $verse)
                                    <div class="verse-item border border-gray-200 rounded p-3 hover:bg-blue-50 transition cursor-pointer" 
                                         onclick="addVerse({{ $verse->id }}, this)"
                                         data-reference="{{ strtolower($verse->reference) }}"
                                         data-content="{{ strtolower($verse->verse) }}">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <span class="text-sm font-semibold text-gray-900">{{ $verse->reference }}</span>
                                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($verse->verse, 100) }}</p>
                                            </div>
                                            <span class="text-blue-600 text-sm">+ Add</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const collectionSlug = '{{ $collection->slug }}';
        const csrfToken = '{{ csrf_token() }}';

        function filterVerses() {
            const searchTerm = document.getElementById('verseSearch').value.toLowerCase();
            const verses = document.querySelectorAll('.verse-item');
            
            verses.forEach(verse => {
                const reference = verse.dataset.reference;
                const content = verse.dataset.content;
                
                if (reference.includes(searchTerm) || content.includes(searchTerm)) {
                    verse.style.display = '';
                } else {
                    verse.style.display = 'none';
                }
            });
        }

        function addVerse(verseId, element) {
            fetch(`/collections/${collectionSlug}/verses`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ verse_id: verseId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function removeVerse(verseId, button) {
            if (!confirm('Remove this verse from the collection?')) return;

            fetch(`/collections/${collectionSlug}/verses`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ verse_id: verseId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const card = button.closest('.border');
                    card.style.opacity = '0';
                    setTimeout(() => location.reload(), 300);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function togglePublic() {
            fetch(`/collections/${collectionSlug}/toggle-public`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
    @endpush
</x-app-layout>
