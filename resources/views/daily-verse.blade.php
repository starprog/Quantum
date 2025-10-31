<x-app-layout>
    <div style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <!-- Hero Section -->
        <div style="text-align: center; padding: 3rem 1rem 2rem; color: white;">
            <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem;">📅 Daily Verse</h1>
            <p style="font-size: 1.125rem; opacity: 0.95;">A fresh word from God each day</p>
        </div>

        <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem 3rem;">
            <!-- Today's Verse Card -->
            @if($verseOfTheDay)
                <div style="background: white; border-radius: 1.5rem; padding: 3rem; margin-bottom: 3rem; 
                            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); position: relative; overflow: hidden;">
                    
                    <!-- Decorative Background -->
                    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; 
                                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); opacity: 0.05; 
                                border-radius: 50%;"></div>
                    
                    <!-- Badge -->
                    <div style="margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                        <span style="display: inline-flex; align-items: center; gap: 0.5rem; 
                                   background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                   color: white; padding: 0.625rem 1.25rem; border-radius: 9999px; 
                                   font-size: 0.875rem; font-weight: 600; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);">
                            <span style="font-size: 1.125rem;">✨</span>
                            <span>Today's Verse - {{ date('F j, Y') }}</span>
                        </span>
                        <span style="display: inline-block; background: #f3f4f6; color: #374151; 
                                   padding: 0.625rem 1.25rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">
                            {{ $verseOfTheDay->category->name }}
                        </span>
                    </div>
                    
                    <!-- Verse Text -->
                    <div style="position: relative; padding-left: 2rem;">
                        <div style="position: absolute; left: 0; top: -1rem; font-size: 5rem; color: #e5e7eb; 
                                    font-family: Georgia, serif; line-height: 1;">"</div>
                        
                        <p style="font-size: 1.75rem; line-height: 1.8; color: #1f2937; margin-bottom: 1.5rem; 
                                  font-weight: 500; position: relative;">
                            {{ $verseOfTheDay->verse }}
                        </p>
                        
                        <p style="font-size: 1.25rem; color: #6b7280; text-align: right; font-style: italic; 
                                  font-weight: 600; margin-bottom: 2rem;">
                            — {{ $verseOfTheDay->reference }}
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; 
                                padding-top: 2rem; border-top: 2px solid #f3f4f6;">
                        @auth
                            <button 
                                onclick="toggleFavorite({{ $verseOfTheDay->id }}, this)"
                                data-verse-id="{{ $verseOfTheDay->id }}"
                                data-is-favorited="{{ auth()->user()->favoriteVerses()->where('verse_id', $verseOfTheDay->id)->exists() ? 'true' : 'false' }}"
                                style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.875rem 1.75rem; 
                                       {{ auth()->user()->favoriteVerses()->where('verse_id', $verseOfTheDay->id)->exists() 
                                          ? 'background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white;' 
                                          : 'background: #f3f4f6; color: #374151;' }}
                                       border-radius: 0.75rem; border: none; font-size: 0.875rem; font-weight: 600; 
                                       cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(0,0,0,0.15)'"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)'">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem;" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                </svg>
                                <span>{{ auth()->user()->favoriteVerses()->where('verse_id', $verseOfTheDay->id)->exists() ? 'Saved' : 'Save to Favorites' }}</span>
                            </button>
                        @endauth

                        <button 
                            id="audioBtnDaily"
                            onclick="toggleAudioDaily()"
                            style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.875rem 1.75rem; 
                                   background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; 
                                   border-radius: 0.75rem; border: none; font-size: 0.875rem; font-weight: 600; 
                                   cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(16, 185, 129, 0.5)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(16, 185, 129, 0.4)'">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem; fill: currentColor;" viewBox="0 0 20 20">
                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                            </svg>
                            <span id="audioTextDaily">Listen</span>
                        </button>

                        <button 
                            onclick="shareVerse()"
                            style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.875rem 1.75rem; 
                                   background: #f3f4f6; color: #374151; border-radius: 0.75rem; border: none; 
                                   font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.3s; 
                                   box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(0,0,0,0.15)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)'">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                            <span>Share</span>
                        </button>

                        <a href="{{ route('bible-verse') }}"
                           style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.875rem 1.75rem; 
                                  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; 
                                  border-radius: 0.75rem; font-size: 0.875rem; font-weight: 600; 
                                  text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);"
                           onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(102, 126, 234, 0.5)'"
                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.4)'">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>Explore More Verses</span>
                        </a>
                    </div>
                </div>
            @endif

            <!-- History Section -->
            @if(count($history) > 0)
                <div style="margin-bottom: 2rem;">
                    <h2 style="color: white; font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; text-align: center;">
                        📜 Previous Daily Verses
                    </h2>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem;">
                    @foreach($history as $dailyVerse)
                        <div style="background: white; border-radius: 1rem; padding: 1.5rem; 
                                    box-shadow: 0 4px 16px rgba(0,0,0,0.1); transition: all 0.3s;"
                             onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.15)'"
                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.1)'">
                            
                            <!-- Date Badge -->
                            <div style="margin-bottom: 1rem;">
                                <span style="background: #f3f4f6; color: #6b7280; padding: 0.375rem 0.75rem; 
                                           border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                    📅 {{ date('M j, Y', strtotime($dailyVerse->date)) }}
                                </span>
                                <span style="margin-left: 0.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                           color: white; padding: 0.375rem 0.75rem; border-radius: 9999px; 
                                           font-size: 0.75rem; font-weight: 600;">
                                    {{ $dailyVerse->category_name }}
                                </span>
                            </div>
                            
                            <!-- Verse Text -->
                            <p style="color: #374151; line-height: 1.6; margin-bottom: 1rem; font-size: 0.9375rem;">
                                {{ Str::limit($dailyVerse->verse, 120) }}
                            </p>
                            
                            <!-- Reference -->
                            <p style="color: #9ca3af; font-size: 0.875rem; font-weight: 600; font-style: italic;">
                                — {{ $dailyVerse->reference }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @auth
    <script>
        function toggleFavorite(verseId, button) {
            fetch(`/favorites/toggle/${verseId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.favorited) {
                    button.style.background = 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)';
                    button.style.color = 'white';
                    button.querySelector('span').textContent = 'Saved';
                } else {
                    button.style.background = '#f3f4f6';
                    button.style.color = '#374151';
                    button.querySelector('span').textContent = 'Save to Favorites';
                }
            });
        }
    </script>
    @endauth

    <script>
        // Audio Bible Feature for Daily Verse
        let currentUtteranceDaily = null;
        let isPlayingDaily = false;
        
        function toggleAudioDaily() {
            if (!('speechSynthesis' in window)) {
                alert('Text-to-speech is not supported in your browser. Please try Chrome, Safari, or Edge.');
                return;
            }
            
            if (isPlayingDaily) {
                stopAudioDaily();
            } else {
                playAudioDaily();
            }
        }
        
        function playAudioDaily() {
            window.speechSynthesis.cancel();
            
            const verseText = `{{ addslashes($verseOfTheDay->verse) }}`;
            const reference = "{{ $verseOfTheDay->reference }}";
            const fullText = `${verseText}. ${reference}`;
            
            currentUtteranceDaily = new SpeechSynthesisUtterance(fullText);
            
            const savedRate = localStorage.getItem('audioRate') || 1.0;
            const savedVolume = localStorage.getItem('audioVolume') || 1.0;
            
            currentUtteranceDaily.rate = parseFloat(savedRate);
            currentUtteranceDaily.volume = parseFloat(savedVolume);
            currentUtteranceDaily.pitch = 1.0;
            
            currentUtteranceDaily.onstart = () => {
                isPlayingDaily = true;
                updateAudioButtonDaily(true);
            };
            
            currentUtteranceDaily.onend = () => {
                isPlayingDaily = false;
                updateAudioButtonDaily(false);
            };
            
            currentUtteranceDaily.onerror = (event) => {
                console.error('Speech synthesis error:', event);
                isPlayingDaily = false;
                updateAudioButtonDaily(false);
                alert('An error occurred while playing audio. Please try again.');
            };
            
            window.speechSynthesis.speak(currentUtteranceDaily);
        }
        
        function stopAudioDaily() {
            window.speechSynthesis.cancel();
            isPlayingDaily = false;
            updateAudioButtonDaily(false);
        }
        
        function updateAudioButtonDaily(playing) {
            const btn = document.getElementById('audioBtnDaily');
            const text = document.getElementById('audioTextDaily');
            const icon = btn.querySelector('svg');
            
            if (playing) {
                text.textContent = 'Stop';
                btn.style.background = 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)';
                btn.style.boxShadow = '0 4px 12px rgba(239, 68, 68, 0.4)';
                icon.innerHTML = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" clip-rule="evenodd"/>';
            } else {
                text.textContent = 'Listen';
                btn.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
                btn.style.boxShadow = '0 4px 12px rgba(16, 185, 129, 0.4)';
                icon.innerHTML = '<path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>';
            }
        }
        
        function shareVerse() {
            const verseText = `{{ $verseOfTheDay->verse }} - {{ $verseOfTheDay->reference }}`;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Daily Verse - {{ date("F j, Y") }}',
                    text: verseText,
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(verseText);
                alert('Verse copied to clipboard!');
            }
        }
    </script>
</x-app-layout>
