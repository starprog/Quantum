<div style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
    @if($verse)
        <!-- Category Filter Buttons -->
        <div style="margin-bottom: 1.5rem; text-align: center;">
            <button 
                wire:click="refreshVerse(null)"
                wire:loading.attr="disabled"
                style="display: inline-block; padding: 0.5rem 1rem; margin: 0.25rem; font-size: 0.75rem; font-weight: 600; 
                       border-radius: 0.5rem; border: none; cursor: pointer; transition: all 0.3s;
                       {{ is_null($selectedCategory) 
                          ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;' 
                          : 'background: #f3f4f6; color: #6b7280;' }}"
                onmouseover="this.style.transform='translateY(-2px)';"
                onmouseout="this.style.transform='translateY(0)';">
                All
            </button>
            @foreach($categories as $category)
                <button 
                    wire:click="refreshVerse('{{ $category->name }}')"
                    wire:loading.attr="disabled"
                    style="display: inline-block; padding: 0.5rem 1rem; margin: 0.25rem; font-size: 0.75rem; font-weight: 600; 
                           border-radius: 0.5rem; border: none; cursor: pointer; transition: all 0.3s;
                           {{ $selectedCategory === $category->name 
                              ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;' 
                              : 'background: #f3f4f6; color: #6b7280;' }}"
                    onmouseover="this.style.transform='translateY(-2px)';"
                    onmouseout="this.style.transform='translateY(0)';">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
        
        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 1.5rem 0;">
        
        <!-- Category Badge -->
        <div style="margin-bottom: 1.5rem;">
            <span style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                       color: white; padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">
                {{ $verse->category->name }}
            </span>
        </div>
        
        <!-- Verse Text -->
        <div wire:key="verse-{{ $verse->id }}" style="margin-bottom: 1.5rem;">
            <p style="font-size: 1.5rem; line-height: 1.6; color: #1f2937; margin-bottom: 1rem; font-weight: 500;">
                "{{ $verse->verse }}"
            </p>
            
            <p style="font-size: 1.125rem; color: #6b7280; text-align: right; font-style: italic; font-weight: 600;">
                — {{ $verse->reference }}
            </p>
        </div>
        
        <!-- Action Buttons -->
        <div style="text-align: center; display: flex; gap: 0.75rem; justify-content: center; flex-wrap: wrap;">
            <!-- Copy Button -->
            <button 
                onclick="copyVerse('{{ addslashes($verse->verse) }}', '{{ $verse->reference }}')"
                id="copyBtn"
                style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; 
                       font-size: 0.875rem; font-weight: 600; border-radius: 0.5rem; border: none; 
                       cursor: pointer; transition: all 0.3s; 
                       background: #f3f4f6; color: #374151;
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
                wire:click="refreshVerse({{ $selectedCategory ? "'".$selectedCategory."'" : 'null' }})"
                wire:loading.attr="disabled"
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
        
        <!-- Copy notification -->
        <div id="copyNotification" style="display: none; margin-top: 1rem; padding: 0.75rem; background: #10b981; color: white; 
                                           border-radius: 0.5rem; text-align: center; font-size: 0.875rem; font-weight: 600;">
            ✓ Verse copied to clipboard!
        </div>
        
        <script>
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
        </script>
    @else
        <p style="text-align: center; color: #6b7280;">No verses available</p>
    @endif
</div>
