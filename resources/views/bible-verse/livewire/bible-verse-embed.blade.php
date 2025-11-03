<style>
    /* Mobile-specific improvements */
    @media (max-width: 640px) {
        .widget-card {
            padding: 1.5rem !important;
            border-radius: 0.75rem !important;
        }
        
        .verse-content p:first-child {
            font-size: 1.25rem !important;
        }
        
        .verse-content p:last-child {
            font-size: 1rem !important;
        }
        
        button {
            padding: 0.65rem 1.25rem !important;
            font-size: 0.8rem !important;
        }
        
        button svg {
            width: 1rem !important;
            height: 1rem !important;
        }
        
        .votd-badge {
            font-size: 0.75rem !important;
            padding: 0.4rem 0.8rem !important;
        }
    }
    
    @media (max-width: 480px) {
        .widget-card {
            padding: 1.25rem !important;
        }
        
        .verse-content p:first-child {
            font-size: 1.125rem !important;
        }
        
        button span:not([wire\\:loading]) {
            display: none !important;
        }
        
        button {
            padding: 0.6rem !important;
            min-width: 44px;
            min-height: 44px;
        }
    }
</style>

<div class="widget-card fade-in" style="background: var(--widget-bg); border-radius: 1rem; padding: 2rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); transition: background 0.3s;">
    @if($verse)
        <!-- Verse of the Day Badge -->
        @if($isVerseOfTheDay)
        <div style="margin-bottom: 1.5rem; text-align: center;">
            <span class="votd-badge" style="display: inline-flex; align-items: center; gap: 0.5rem; 
                       background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%); 
                       color: white; padding: 0.5rem 1rem; border-radius: 9999px; 
                       font-size: 0.875rem; font-weight: 700; text-transform: uppercase; 
                       letter-spacing: 0.05em; box-shadow: 0 4px 6px rgba(245, 158, 11, 0.3);
                       animation: fadeIn 0.5s ease-in;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 1rem; height: 1rem; fill: currentColor;" viewBox="0 0 20 20">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
                ✨ Verse of the Day
            </span>
        </div>
        @endif
        
        <!-- Font Size Controls -->
        <div style="text-align: right; margin-bottom: 1rem;">
            <div style="display: inline-flex; gap: 0.25rem; background: var(--widget-bg); border: 2px solid var(--text-secondary); opacity: 0.3; border-radius: 0.5rem; padding: 0.25rem;">
                <button onclick="setFontSize('small')" id="fontSmall" style="padding: 0.4rem 0.75rem; border: none; background: transparent; color: var(--text-secondary); cursor: pointer; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; transition: all 0.2s;">
                    A
                </button>
                <button onclick="setFontSize('medium')" id="fontMedium" style="padding: 0.4rem 0.75rem; border: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; cursor: pointer; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 600; transition: all 0.2s;">
                    A
                </button>
                <button onclick="setFontSize('large')" id="fontLarge" style="padding: 0.4rem 0.75rem; border: none; background: transparent; color: var(--text-secondary); cursor: pointer; border-radius: 0.375rem; font-size: 1rem; font-weight: 600; transition: all 0.2s;">
                    A
                </button>
            </div>
        </div>
        
        <!-- Verse Text -->
        <div wire:key="verse-{{ $verse->id }}" class="verse-content" id="verseContent" style="margin-bottom: 2rem; transition: all 0.3s ease;">
            <p id="verseText" style="font-size: 1.5rem; line-height: 1.6; color: var(--text-primary); margin-bottom: 1rem; font-weight: 500; transition: font-size 0.3s ease;">
                "{{ $verse->verse }}"
            </p>
            
            <p id="verseReference" style="font-size: 1.125rem; color: var(--text-secondary); text-align: right; font-style: italic; font-weight: 600; transition: font-size 0.3s ease;">
                — {{ $verse->reference }}
            </p>
        </div>
        
        <!-- Action Buttons -->
        <div style="text-align: center; display: flex; gap: 0.75rem; justify-content: center; flex-wrap: wrap;">
            <!-- History Button -->
            <div style="position: relative; display: inline-block;">
                <button 
                    onclick="toggleHistory()"
                    id="historyBtn"
                    style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; 
                           font-size: 0.875rem; font-weight: 600; border-radius: 0.5rem; border: none; 
                           cursor: pointer; transition: all 0.3s; 
                           background: var(--widget-bg); color: var(--text-primary);
                           border: 2px solid var(--text-secondary);
                           box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.15)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)';">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem; fill: none;" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>History</span>
                    <span id="historyCount" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 0.125rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700;">0</span>
                </button>
                
                <!-- History Dropdown -->
                <div id="historyDropdown" style="display: none; position: absolute; top: 100%; left: 0; margin-top: 0.5rem; 
                                                  background: var(--widget-bg); border-radius: 0.75rem; 
                                                  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15); 
                                                  min-width: 320px; max-width: 400px; z-index: 1000;
                                                  border: 2px solid var(--text-secondary); opacity: 0.3;
                                                  max-height: 400px; overflow-y: auto;">
                    <div style="padding: 1rem; border-bottom: 2px solid var(--text-secondary); opacity: 0.2; display: flex; justify-content: space-between; align-items: center;">
                        <h4 style="margin: 0; color: var(--text-primary); font-size: 1rem; font-weight: 700;">Recent Verses</h4>
                        <button onclick="clearHistory()" style="background: #ef4444; color: white; border: none; padding: 0.25rem 0.75rem; border-radius: 0.5rem; font-size: 0.75rem; cursor: pointer; font-weight: 600;">Clear All</button>
                    </div>
                    <div id="historyList" style="padding: 0.5rem;">
                        <!-- History items will be inserted here -->
                    </div>
                </div>
            </div>
            
            <!-- Copy Button -->
            <button 
                onclick="copyVerse('{{ addslashes($verse->verse) }}', '{{ $verse->reference }}')"
                id="copyBtn"
                style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; 
                       font-size: 0.875rem; font-weight: 600; border-radius: 0.5rem; border: none; 
                       cursor: pointer; transition: all 0.3s; 
                       background: var(--widget-bg); color: var(--text-primary);
                       border: 2px solid var(--text-secondary);
                       box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);"
                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.15)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)';">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem; fill: none;" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                <span>Copy Verse</span>
            </button>
            
            <!-- New Verse Button -->
            <button 
                wire:click="refreshVerse(null)"
                wire:loading.attr="disabled"
                id="newVerseBtn"
                style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; 
                       font-size: 0.875rem; font-weight: 600; border-radius: 0.5rem; border: none; 
                       cursor: pointer; transition: all 0.3s; 
                       background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;
                       box-shadow: 0 4px 6px rgba(102, 126, 234, 0.3);"
                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(102, 126, 234, 0.4)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(102, 126, 234, 0.3)';">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem; fill: none;" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span wire:loading.remove>New Verse</span>
                <span wire:loading>Loading...</span>
            </button>
        </div>
        
        <!-- Social Share Buttons -->
        <div style="margin-top: 1.5rem; text-align: center;">
            <p style="font-size: 0.75rem; color: var(--text-secondary); margin-bottom: 0.75rem; font-weight: 600;">Share this verse:</p>
            <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;">
                <!-- Twitter -->
                <button 
                    onclick="shareOnTwitter('{{ addslashes($verse->verse) }}', '{{ $verse->reference }}')"
                    style="padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; 
                           background: #1DA1F2; color: white; font-size: 0.75rem; font-weight: 600;
                           display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s;"
                    onmouseover="this.style.transform='scale(1.05)';"
                    onmouseout="this.style.transform='scale(1)';">
                    <svg style="width: 1rem; height: 1rem; fill: currentColor;" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                    Twitter
                </button>
                
                <!-- Facebook -->
                <button 
                    onclick="shareOnFacebook('{{ addslashes($verse->verse) }}', '{{ $verse->reference }}')"
                    style="padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; 
                           background: #4267B2; color: white; font-size: 0.75rem; font-weight: 600;
                           display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s;"
                    onmouseover="this.style.transform='scale(1.05)';"
                    onmouseout="this.style.transform='scale(1)';">
                    <svg style="width: 1rem; height: 1rem; fill: currentColor;" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </button>
                
                <!-- WhatsApp -->
                <button 
                    onclick="shareOnWhatsApp('{{ addslashes($verse->verse) }}', '{{ $verse->reference }}')"
                    style="padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; 
                           background: #25D366; color: white; font-size: 0.75rem; font-weight: 600;
                           display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s;"
                    onmouseover="this.style.transform='scale(1.05)';"
                    onmouseout="this.style.transform='scale(1)';">
                    <svg style="width: 1rem; height: 1rem; fill: currentColor;" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    WhatsApp
                </button>
            </div>
        </div>
        
        <!-- Copy notification -->
        <div id="copyNotification" style="display: none; margin-top: 1rem; padding: 0.75rem; background: #10b981; color: white; 
                                           border-radius: 0.5rem; text-align: center; font-size: 0.875rem; font-weight: 600;">
            ✓ Verse copied to clipboard!
        </div>
        
        <script>
            // Livewire hooks - save verse when component updates
            document.addEventListener('livewire:initialized', () => {
                Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
                    succeed(({ snapshot, effect }) => {
                        // Save current verse to history after any update
                        const verse = "{{ addslashes($verse->verse) }}";
                        const reference = "{{ $verse->reference }}";
                        const verseId = "{{ $verse->id }}";
                        
                        if (verse && reference) {
                            setTimeout(() => saveToHistory(verse, reference, verseId), 100);
                        }
                    });
                });
            });
            
            // Copy verse function
            function copyVerse(verse, reference) {
                const text = `"${verse}" — ${reference}`;
                navigator.clipboard.writeText(text).then(() => {
                    const notification = document.getElementById('copyNotification');
                    notification.style.display = 'block';
                    setTimeout(() => {
                        notification.style.display = 'none';
                    }, 2000);
                }).catch(err => {
                    console.error('Failed to copy:', err);
                });
            }
            
            // Font Size Control
            const fontSizes = {
                small: { text: '1.25rem', reference: '1rem' },
                medium: { text: '1.5rem', reference: '1.125rem' },
                large: { text: '1.875rem', reference: '1.375rem' }
            };
            
            function setFontSize(size) {
                const verseText = document.getElementById('verseText');
                const verseReference = document.getElementById('verseReference');
                
                if (verseText && verseReference && fontSizes[size]) {
                    verseText.style.fontSize = fontSizes[size].text;
                    verseReference.style.fontSize = fontSizes[size].reference;
                    
                    // Save preference
                    localStorage.setItem('fontSize', size);
                    
                    // Update button styles
                    updateFontSizeButtons(size);
                }
            }
            
            function updateFontSizeButtons(activeSize) {
                const buttons = {
                    small: document.getElementById('fontSmall'),
                    medium: document.getElementById('fontMedium'),
                    large: document.getElementById('fontLarge')
                };
                
                Object.keys(buttons).forEach(size => {
                    if (buttons[size]) {
                        if (size === activeSize) {
                            buttons[size].style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                            buttons[size].style.color = 'white';
                        } else {
                            buttons[size].style.background = 'transparent';
                            buttons[size].style.color = 'var(--text-secondary)';
                        }
                    }
                });
            }
            
            // Load saved font size on page load
            document.addEventListener('DOMContentLoaded', function() {
                const savedSize = localStorage.getItem('fontSize') || 'medium';
                setFontSize(savedSize);
            });
            
            // Social share functions
            function shareOnTwitter(verse, reference) {
                const text = encodeURIComponent(`"${verse}" — ${reference}`);
                const url = `https://twitter.com/intent/tweet?text=${text}`;
                window.open(url, '_blank', 'width=550,height=420');
            }
            
            function shareOnFacebook(verse, reference) {
                const text = encodeURIComponent(`"${verse}" — ${reference}`);
                const url = `https://www.facebook.com/sharer/sharer.php?quote=${text}`;
                window.open(url, '_blank', 'width=550,height=420');
            }
            
            function shareOnWhatsApp(verse, reference) {
                const text = encodeURIComponent(`"${verse}" — ${reference}`);
                const url = `https://wa.me/?text=${text}`;
                window.open(url, '_blank');
            }
            
            // Verse History Management
            const MAX_HISTORY = 10;
            
            function saveToHistory(verse, reference, verseId) {
                let history = JSON.parse(localStorage.getItem('verseHistory') || '[]');
                
                // Create history item
                const item = {
                    id: verseId,
                    verse: verse,
                    reference: reference,
                    timestamp: Date.now(),
                    date: new Date().toLocaleString()
                };
                
                // Remove if already exists (to avoid duplicates)
                history = history.filter(h => h.id !== verseId);
                
                // Add to beginning of array
                history.unshift(item);
                
                // Keep only last MAX_HISTORY items
                history = history.slice(0, MAX_HISTORY);
                
                // Save to localStorage
                localStorage.setItem('verseHistory', JSON.stringify(history));
                
                // Update UI
                updateHistoryUI();
            }
            
            function loadFromHistory(index) {
                const history = JSON.parse(localStorage.getItem('verseHistory') || '[]');
                const item = history[index];
                
                if (item) {
                    // Close dropdown
                    document.getElementById('historyDropdown').style.display = 'none';
                    
                    // You would typically trigger Livewire to load this verse
                    // For now, we'll just show a notification
                    alert(`Loading: "${item.verse.substring(0, 50)}..." — ${item.reference}`);
                    
                    // In a real implementation, you'd call Livewire to load this specific verse
                    // @this.loadSpecificVerse(item.id);
                }
            }
            
            function toggleHistory() {
                const dropdown = document.getElementById('historyDropdown');
                dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
                
                if (dropdown.style.display === 'block') {
                    updateHistoryUI();
                }
            }
            
            function clearHistory() {
                if (confirm('Are you sure you want to clear all verse history?')) {
                    localStorage.removeItem('verseHistory');
                    updateHistoryUI();
                    document.getElementById('historyDropdown').style.display = 'none';
                }
            }
            
            function updateHistoryUI() {
                const history = JSON.parse(localStorage.getItem('verseHistory') || '[]');
                const historyList = document.getElementById('historyList');
                const historyCount = document.getElementById('historyCount');
                
                // Update count badge
                historyCount.textContent = history.length;
                
                // Update list
                if (history.length === 0) {
                    historyList.innerHTML = '<p style="padding: 1rem; text-align: center; color: var(--text-secondary); font-size: 0.875rem;">No verses viewed yet</p>';
                } else {
                    historyList.innerHTML = history.map((item, index) => `
                        <div onclick="loadFromHistory(${index})" style="padding: 0.75rem; margin: 0.5rem; background: var(--widget-bg); 
                                                                          border: 1px solid var(--text-secondary); opacity: 0.3; border-radius: 0.5rem; 
                                                                          cursor: pointer; transition: all 0.2s;"
                             onmouseover="this.style.background='rgba(102, 126, 234, 0.1)'; this.style.borderColor='#667eea';"
                             onmouseout="this.style.background='var(--widget-bg)'; this.style.borderColor='var(--text-secondary)'; this.style.opacity='0.3';">
                            <p style="color: var(--text-primary); font-size: 0.875rem; margin-bottom: 0.25rem; font-weight: 600;">${item.reference}</p>
                            <p style="color: var(--text-secondary); font-size: 0.75rem; margin-bottom: 0.25rem; line-height: 1.4;">
                                "${item.verse.substring(0, 80)}${item.verse.length > 80 ? '...' : ''}"
                            </p>
                            <p style="color: var(--text-secondary); font-size: 0.65rem; opacity: 0.7;">${new Date(item.timestamp).toLocaleString()}</p>
                        </div>
                    `).join('');
                }
            }
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                const dropdown = document.getElementById('historyDropdown');
                const historyBtn = document.getElementById('historyBtn');
                
                if (dropdown && historyBtn && !historyBtn.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });
            
            // Save current verse to history on page load
            document.addEventListener('DOMContentLoaded', function() {
                const verse = "{{ addslashes($verse->verse) }}";
                const reference = "{{ $verse->reference }}";
                const verseId = "{{ $verse->id }}";
                
                if (verse && reference) {
                    saveToHistory(verse, reference, verseId);
                }
            });
            
            // Keyboard shortcuts (simplified)
            document.addEventListener('keydown', function(e) {
                // Ignore if typing in input field
                if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
                
                const key = e.key.toLowerCase();
                
                // N - New Verse
                if (key === 'n') {
                    e.preventDefault();
                    const newVerseBtn = document.getElementById('newVerseBtn');
                    if (newVerseBtn) newVerseBtn.click();
                }
                
                // C - Copy
                if (key === 'c') {
                    e.preventDefault();
                    const copyBtn = document.getElementById('copyBtn');
                    if (copyBtn) copyBtn.click();
                }
                
                // H - History
                if (key === 'h') {
                    e.preventDefault();
                    toggleHistory();
                }
            });
        </script>
    @else
        <p style="text-align: center; color: var(--text-secondary);">No verses available</p>
    @endif
</div>
