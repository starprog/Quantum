<div class="widget-card fade-in">
    @if($verse)
        <!-- Category Filter Dropdown -->
        <div class="category-filter-container">
            <label for="categoryFilter" class="category-label">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 1rem; height: 1rem; fill: none;" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                Category:
            </label>
            <select 
                id="categoryFilter" 
                class="category-select"
                wire:model="selectedCategory"
                wire:change="filterByCategory($event.target.value)">
                <option value="">All Categories</option>
                <option value="2">Faith & Trust</option>
                <option value="1">Gospel & Salvation</option>
                <option value="10">Grace & Forgiveness</option>
                <option value="8">Hope & Encouragement</option>
                <option value="5">Love & Compassion</option>
                <option value="6">Love & Relationships</option>
                <option value="4">Peace & Comfort</option>
                <option value="9">Prayer & Worship</option>
                <option value="3">Strength & Courage</option>
                <option value="7">Wisdom & Guidance</option>
            </select>
            @if(!empty($selectedCategory))
                <button 
                    wire:click="clearCategoryFilter"
                    class="btn-clear-filter"
                    title="Clear filter">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width: 0.875rem; height: 0.875rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            @endif
        </div>
    
        <!-- Verse of the Day Badge -->
        @if($isVerseOfTheDay)
        <div class="votd-container">
            <span class="votd-badge">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 1rem; height: 1rem; fill: currentColor;" viewBox="0 0 20 20">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
                ✨ Verse of the Day
            </span>
        </div>
        @endif
        
        <!-- Verse Text -->
        <div wire:key="verse-{{ $verse->id }}" class="verse-content">
            <p id="verseText" class="verse-text">
                "{{ $verse->verse }}"
            </p>
            
            <p id="verseReference" class="verse-reference">
                — {{ $verse->reference }}
            </p>
        </div>
        
        <!-- Action Buttons -->
        <div class="action-buttons">
            <!-- Copy Button -->
            <button 
                onclick="copyVerseFromDOM()"
                id="copyBtn"
                class="btn-base btn-outline">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem; fill: none;" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                <span>Copy Verse</span>
            </button>
            
            <!-- New Verse Button -->
            <button 
                wire:click="refreshVerse"
                wire:loading.attr="disabled"
                id="newVerseBtn"
                class="btn-base btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem; fill: none;" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span wire:loading.remove>New Verse</span>
                <span wire:loading>Loading...</span>
            </button>
            
            <!-- History Button -->
            <button 
                onclick="toggleHistory()"
                id="historyBtn"
                class="btn-base btn-outline"
                title="View History (Shortcut: H)">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem; fill: none;" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>History</span>
            </button>
        </div>
        
        <!-- Font Size Controls -->
        <div class="font-size-controls">
            <span class="font-size-label">Font Size:</span>
            <div class="font-size-buttons">
                <button onclick="setFontSize('small')" id="fontSmall" class="btn-font" title="Small (Shortcut: Shift+S)">S</button>
                <button onclick="setFontSize('medium')" id="fontMedium" class="btn-font btn-font-active" title="Medium (Default)">M</button>
                <button onclick="setFontSize('large')" id="fontLarge" class="btn-font" title="Large (Shortcut: Shift+L)">L</button>
            </div>
        </div>
        
        <!-- Social Share Buttons -->
        <div class="social-share">
            <p class="social-label">Share this verse:</p>
            <div class="action-buttons">
                <!-- Twitter -->
                <button 
                    onclick="shareFromDOM('twitter')"
                    class="btn-base btn-social"
                    style="background: #1DA1F2; color: white;">
                    <svg style="width: 1rem; height: 1rem; fill: currentColor;" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                    Twitter
                </button>
                
                <!-- Facebook -->
                <button 
                    onclick="shareFromDOM('facebook')"
                    class="btn-base btn-social"
                    style="background: #4267B2; color: white;">
                    <svg style="width: 1rem; height: 1rem; fill: currentColor;" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </button>
                
                <!-- WhatsApp -->
                <button 
                    onclick="shareFromDOM('whatsapp')"
                    class="btn-base btn-social"
                    style="background: #25D366; color: white;">
                    <svg style="width: 1rem; height: 1rem; fill: currentColor;" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    WhatsApp
                </button>
                
                <!-- Email -->
                <button 
                    onclick="shareFromDOM('email')"
                    class="btn-base btn-social"
                    style="background: #6366f1; color: white;">
                    <svg style="width: 1rem; height: 1rem; fill: currentColor;" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                    </svg>
                    Email
                </button>
            </div>
        </div>
        
        <!-- Copy notification -->
        <div id="copyNotification" class="copy-notification">
            ✓ Verse copied to clipboard!
        </div>
        
        <!-- History Modal -->
        <div id="historyModal" class="history-modal" style="display: none;">
            <div class="history-modal-content">
                <div class="history-modal-header">
                    <h3>Verse History</h3>
                    <button onclick="toggleHistory()" class="history-close">&times;</button>
                </div>
                <div id="historyList" class="history-list">
                    <!-- History items will be inserted here -->
                </div>
                <div class="history-modal-footer">
                    <button onclick="clearHistory()" class="btn-base btn-outline" style="font-size: 0.75rem; padding: 0.5rem 1rem;">Clear History</button>
                </div>
            </div>
        </div>
    @else
        <p style="text-align: center; color: var(--text-secondary);">No verses available</p>
    @endif
</div>
