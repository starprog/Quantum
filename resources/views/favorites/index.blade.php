<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                    My Favorite Verses
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Your personally saved Bible verses
                </p>
            </div>

            @if($favoriteVerses->count() > 0)
                <!-- Verses Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($favoriteVerses as $verse)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-200">
                            <!-- Category Badge -->
                            <div class="mb-4">
                                <span class="inline-block px-3 py-1 text-sm font-semibold text-blue-700 dark:text-blue-300 bg-blue-100 dark:bg-blue-900 rounded-full">
                                    {{ $verse->category->name }}
                                </span>
                            </div>

                            <!-- Verse Text -->
                            <div class="mb-4">
                                <p class="text-gray-800 dark:text-gray-200 text-lg leading-relaxed italic">
                                    "{{ $verse->verse }}"
                                </p>
                            </div>

                            <!-- Reference -->
                            <div class="flex justify-between items-center">
                                <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">
                                    {{ $verse->reference }}
                                </p>

                                <!-- Remove from Favorites Button -->
                                <button 
                                    onclick="toggleFavorite({{ $verse->id }}, this)"
                                    class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-200"
                                    title="Remove from favorites">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <h3 class="text-2xl font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        No Favorite Verses Yet
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">
                        Start adding verses to your favorites by clicking the heart icon on the Bible Verse page.
                    </p>
                    <a href="{{ route('bible-verse') }}" 
                       class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200">
                        Browse Verses
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function toggleFavorite(verseId, button) {
            fetch(`/favorites/toggle/${verseId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the card from the DOM with animation
                    const card = button.closest('.bg-white, .dark\\:bg-gray-800');
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        card.remove();
                        
                        // Check if there are no more favorites
                        const grid = document.querySelector('.grid');
                        if (grid && grid.children.length === 0) {
                            location.reload();
                        }
                    }, 300);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</x-app-layout>
