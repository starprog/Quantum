<x-app-layout>
    <div style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div style="max-width: 1280px; margin: 0 auto; padding: 3rem 1.5rem;">
            
            <!-- Hero Section -->
            <div style="text-align: center; margin-bottom: 3rem;">
                <h1 style="font-size: 3.5rem; font-weight: 800; color: white; margin-bottom: 1rem; text-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    ❤️ My Favorite Verses
                </h1>
                <p style="font-size: 1.25rem; color: rgba(255,255,255,0.9); max-width: 600px; margin: 0 auto;">
                    Your personally saved collection of inspirational scriptures
                </p>
            </div>

            @if($favoriteVerses->count() > 0)
                <!-- Verses Grid -->
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem;">
                    @foreach($favoriteVerses as $verse)
                        <div style="background: white; border-radius: 1rem; padding: 2rem; 
                                    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); transition: all 0.3s;
                                    position: relative; overflow: hidden;"
                             onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1)';"
                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)';">
                            
                            <!-- Decorative corner -->
                            <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; 
                                        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, transparent 100%); 
                                        border-radius: 0 1rem 0 100%;"></div>
                            
                            <!-- Category Badge -->
                            <div style="margin-bottom: 1rem;">
                                <span style="display: inline-block; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 700; 
                                             color: white; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                             border-radius: 9999px; box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);">
                                    {{ $verse->category->name }}
                                </span>
                            </div>

                            <!-- Verse Text -->
                            <div style="margin-bottom: 1.5rem; position: relative;">
                                <svg style="position: absolute; left: -0.5rem; top: -0.5rem; width: 1.5rem; height: 1.5rem; 
                                            color: rgba(102, 126, 234, 0.2);" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                </svg>
                                <p style="color: #374151; font-size: 1.125rem; line-height: 1.75; font-style: italic; 
                                          padding-left: 1.5rem; position: relative; z-index: 1;">
                                    {{ $verse->verse }}
                                </p>
                            </div>

                            <!-- Reference and Actions -->
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 1rem; 
                                        border-top: 2px solid #f3f4f6;">
                                <p style="font-size: 0.875rem; font-weight: 700; color: #667eea;">
                                    📖 {{ $verse->reference }}
                                </p>

                                <!-- Remove from Favorites Button -->
                                <button 
                                    onclick="toggleFavorite({{ $verse->id }}, this)"
                                    style="padding: 0.5rem; background: rgba(239, 68, 68, 0.1); color: #ef4444; 
                                           border: none; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;
                                           display: flex; align-items: center; justify-content: center;"
                                    onmouseover="this.style.background='#ef4444'; this.style.color='white'; this.style.transform='scale(1.1)'"
                                    onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'; this.style.color='#ef4444'; this.style.transform='scale(1)'"
                                    title="Remove from favorites">
                                    <svg style="width: 1.5rem; height: 1.5rem;" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div style="text-align: center; padding: 4rem 2rem;">
                    <div style="background: white; border-radius: 1.5rem; padding: 4rem 2rem; 
                                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); max-width: 600px; margin: 0 auto;">
                        <div style="width: 120px; height: 120px; margin: 0 auto 2rem; 
                                    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); 
                                    border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 4rem; height: 4rem; color: #667eea;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        
                        <h3 style="font-size: 2rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">
                            No Favorite Verses Yet
                        </h3>
                        
                        <p style="font-size: 1.125rem; color: #6b7280; margin-bottom: 2rem; line-height: 1.6;">
                            Start building your personal collection of inspirational Bible verses by clicking the heart icon ❤️ on any verse
                        </p>
                        
                        <a href="{{ route('bible-verse') }}" 
                           style="display: inline-block; padding: 1rem 2.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                  color: white; border-radius: 0.75rem; font-weight: 700; font-size: 1.125rem; 
                                  text-decoration: none; transition: all 0.2s; box-shadow: 0 4px 6px rgba(102, 126, 234, 0.3);"
                           onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px rgba(102, 126, 234, 0.4)'"
                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(102, 126, 234, 0.3)'">
                            📖 Browse Verses
                        </a>
                    </div>
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
                    // Find the verse card
                    const card = button.closest('[style*="background: white"]');
                    
                    // Add exit animation
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.9) translateY(-20px)';
                    
                    setTimeout(() => {
                        card.remove();
                        
                        // Check if there are no more favorites
                        const container = document.querySelector('[style*="display: grid"]');
                        if (container && container.children.length === 0) {
                            location.reload();
                        }
                    }, 300);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</x-app-layout>
