<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 p-8">
    <div class="max-w-4xl mx-auto">
        <!-- Loading overlay -->
        <div wire:loading class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-white/95 dark:bg-gray-800/95 rounded-2xl p-8 shadow-2xl">
                <div class="animate-spin rounded-full h-12 w-12 border-4 border-blue-200 border-t-blue-600 dark:border-gray-600 dark:border-t-blue-400 mx-auto"></div>
                <p class="mt-4 text-gray-700 dark:text-gray-300 font-medium text-center">Loading verse...</p>
            </div>
        </div>

        <!-- Categories -->
                <!-- Categories -->
        <div style="margin-bottom: 2rem;">
            <h2 style="text-align: center; color: #374151; font-weight: 600; margin-bottom: 1rem;">CHOOSE A CATEGORY</h2>
            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; justify-content: center;">
                <button wire:click="refreshVerse(null)" 
                        wire:loading.class="opacity-50"
                        style="padding: 0.75rem 1rem; font-size: 0.875rem; font-weight: 600; color: white; background-color: #0066FF; border-radius: 0.375rem; 
                               border: none; cursor: pointer; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);
                               {{ is_null($selectedCategory) ? 'outline: 2px solid #0066FF; outline-offset: 2px;' : '' }}"
                        onmouseover="this.style.backgroundColor='#0052CC'"
                        onmouseout="this.style.backgroundColor='#0066FF'">
                    All Categories
                </button>
                @foreach($categories as $category)
                    <button wire:click="refreshVerse('{{ $category->name }}')" 
                            wire:loading.class="opacity-50"
                            style="padding: 0.75rem 1rem; font-size: 0.875rem; font-weight: 600; color: white; background-color: #0066FF; border-radius: 0.375rem; 
                                   border: none; cursor: pointer; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);
                                   {{ $selectedCategory === $category->name ? 'outline: 2px solid #0066FF; outline-offset: 2px;' : '' }}"
                            onmouseover="this.style.backgroundColor='#0052CC'"
                            onmouseout="this.style.backgroundColor='#0066FF'">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Verse Card -->
        <div class="mb-8">
            <!-- Verse Text -->
            <div style="max-width: 800px; margin: 0 auto; padding: 2rem; background: white; border-radius: 1rem; 
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); border: 1px solid #e5e7eb;
                        position: relative; overflow: hidden;">
                <!-- Quote decoration -->
                <div style="position: absolute; top: 1rem; left: 1rem; font-size: 4rem; color: #f3f4f6; font-family: serif; line-height: 1;">"</div>
                
                <div style="position: relative;">
                    <p style="font-size: 1.5rem; line-height: 1.75; color: #1f2937; text-align: center; margin-bottom: 1.5rem;">
                        {{ $verse->verse }}
                    </p>
                    
                    <p style="font-size: 1.125rem; color: #6b7280; text-align: right; font-style: italic;">
                        {{ $verse->reference }}
                    </p>
                </div>
            </div>

            <!-- Reference and Favorite -->
            <div class="flex justify-center items-center">
                <div class="text-center">
                
                @auth
                <!-- Favorite Button -->
                <button 
                    onclick="toggleFavorite({{ $verse->id }}, this)"
                    data-verse-id="{{ $verse->id }}"
                    data-is-favorited="{{ auth()->user()->favoriteVerses()->where('verse_id', $verse->id)->exists() ? 'true' : 'false' }}"
                    class="group flex items-center gap-2 px-5 py-2.5 rounded-full transition-all duration-200 transform hover:scale-105
                           {{ auth()->user()->favoriteVerses()->where('verse_id', $verse->id)->exists() 
                              ? 'bg-gradient-to-r from-red-500 to-pink-500 text-white' 
                              : 'bg-white/95 dark:bg-gray-800/95 text-gray-700 dark:text-gray-300 hover:bg-gradient-to-r hover:from-red-500 hover:to-pink-500 hover:text-white' }}
                           shadow-lg hover:shadow-xl backdrop-blur-sm border border-white/20"
                    title="{{ auth()->user()->favoriteVerses()->where('verse_id', $verse->id)->exists() ? 'Remove from favorites' : 'Add to favorites' }}">
                    <div class="bg-white/10 rounded-full p-1 transition-transform group-hover:scale-110 group-hover:bg-white/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ auth()->user()->favoriteVerses()->where('verse_id', $verse->id)->exists() ? 'fill-current' : 'fill-none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium">
                        {{ auth()->user()->favoriteVerses()->where('verse_id', $verse->id)->exists() ? 'Saved' : 'Save' }}
                    </span>
                </button>
                @endauth
            </div>
        </div>

        <!-- Share Section -->
        <div style="margin: 2rem auto; max-width: 800px; text-align: center;">
            <h3 style="color: #374151; font-weight: 600; margin-bottom: 1rem; font-size: 0.875rem; letter-spacing: 0.05em;">SHARE THIS VERSE</h3>
            <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: center; gap: 1rem;">
                <!-- Facebook -->
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}&quote={{ urlencode($verse->verse . ' - ' . $verse->reference) }}"
                   target="_blank"
                   style="display: inline-flex; align-items: center; justify-content: center; width: 2.5rem; height: 2.5rem; 
                          background-color: #1877f2; color: white; border-radius: 9999px; transition: transform 0.2s;"
                   onmouseover="this.style.transform='scale(1.1)'"
                   onmouseout="this.style.transform='scale(1)'">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                    </svg>
                </a>

                <!-- Twitter -->
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($verse->verse . ' - ' . $verse->reference) }}"
                   target="_blank"
                   style="display: inline-flex; align-items: center; justify-content: center; width: 2.5rem; height: 2.5rem; 
                          background-color: #1da1f2; color: white; border-radius: 9999px; transition: transform 0.2s;"
                   onmouseover="this.style.transform='scale(1.1)'"
                   onmouseout="this.style.transform='scale(1)'">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                    </svg>
                </a>

                <!-- LinkedIn -->
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                   target="_blank"
                   style="display: inline-flex; align-items: center; justify-content: center; width: 2.5rem; height: 2.5rem; 
                          background-color: #0a66c2; color: white; border-radius: 9999px; transition: transform 0.2s;"
                   onmouseover="this.style.transform='scale(1.1)'"
                   onmouseout="this.style.transform='scale(1)'">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/>
                    </svg>
                </a>

                <!-- WhatsApp -->
                <a href="https://wa.me/?text={{ urlencode($verse->verse . ' - ' . $verse->reference) }}"
                   target="_blank"
                   style="display: inline-flex; align-items: center; justify-content: center; width: 2.5rem; height: 2.5rem; 
                          background-color: #25d366; color: white; border-radius: 9999px; transition: transform 0.2s;"
                   onmouseover="this.style.transform='scale(1.1)'"
                   onmouseout="this.style.transform='scale(1)'">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                </a>

                <!-- Telegram -->
                <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($verse->verse . ' - ' . $verse->reference) }}"
                   target="_blank"
                   style="display: inline-flex; align-items: center; justify-content: center; width: 2.5rem; height: 2.5rem; 
                          background-color: #0088cc; color: white; border-radius: 9999px; transition: transform 0.2s;"
                   onmouseover="this.style.transform='scale(1.1)'"
                   onmouseout="this.style.transform='scale(1)'">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9.78 18.65l.28-4.23 7.68-6.92c.34-.31-.07-.46-.52-.19l-9.5 5.83-4.11-1.25c-.89-.27-.85-.86.2-1.3l15.97-6.16c.73-.33 1.43.18 1.15 1.3l-2.72 12.81c-.19.91-.74 1.13-1.5.71L12.6 16.3l-1.99 1.93c-.23.23-.42.42-.83.42z"/>
                    </svg>
                </a>

                <!-- Pinterest -->
                <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&description={{ urlencode($verse->verse . ' - ' . $verse->reference) }}"
                   target="_blank"
                   style="display: inline-flex; align-items: center; justify-content: center; width: 2.5rem; height: 2.5rem; 
                          background-color: #e60023; color: white; border-radius: 9999px; transition: transform 0.2s;"
                   onmouseover="this.style.transform='scale(1.1)'"
                   onmouseout="this.style.transform='scale(1)'">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/>
                    </svg>
                </a>
            </div>
        </div>
        </div>

            <!-- Button container -->
            

        <!-- New Verse Button -->
                <!-- New Verse Button -->
        <div style="margin-top: 2rem; text-align: center;">
            <button wire:click="refreshVerse('{{ $selectedCategory }}')"
                    wire:loading.attr="disabled"
                    style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.875rem 1.5rem; font-size: 1rem; font-weight: 600; 
                           color: white; background-color: #0066FF; border-radius: 0.375rem; border: none; cursor: pointer; 
                           transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"
                    onmouseover="this.style.backgroundColor='#0052CC'"
                    onmouseout="this.style.backgroundColor='#0066FF'">
                <svg wire:loading.remove style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <svg wire:loading style="width: 1.25rem; height: 1.25rem; animation: spin 1s linear infinite;" fill="none" viewBox="0 0 24 24">
                    <circle style="opacity: 0.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path style="opacity: 0.75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Get New Verse</span>
            </button>
        </div>

        <style>
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
        </style>
    </div>
</div>

@auth
<script>
    function toggleFavorite(verseId, button) {
        const icon = button.querySelector('svg');
        const isFavorited = button.dataset.isFavorited === 'true';
        
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
                // Toggle the visual state
                button.dataset.isFavorited = data.isFavorited ? 'true' : 'false';
                
                if (data.isFavorited) {
                    // Add to favorites - fill the heart
                    icon.classList.remove('fill-none', 'text-gray-400', 'dark:text-gray-500', 'hover:text-red-400');
                    icon.classList.add('fill-red-500', 'text-red-500');
                    button.title = 'Remove from favorites';
                    
                    // Show success message
                    showNotification('Added to favorites!', 'success');
                } else {
                    // Remove from favorites - unfill the heart
                    icon.classList.remove('fill-red-500', 'text-red-500');
                    icon.classList.add('fill-none', 'text-gray-400', 'dark:text-gray-500', 'hover:text-red-400');
                    button.title = 'Add to favorites';
                    
                    // Show success message
                    showNotification('Removed from favorites!', 'info');
                }
                
                // Animate button
                button.classList.add('animate-ping');
                setTimeout(() => button.classList.remove('animate-ping'), 300);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Something went wrong!', 'error');
        });
    }

    function showNotification(message, type) {
        const notification = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
        
        notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300 ease-in-out`;
        notification.textContent = message;
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-20px)';
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
        }, 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(-20px)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
</script>
@endauth