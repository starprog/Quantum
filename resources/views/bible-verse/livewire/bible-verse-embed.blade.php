<div style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
    @if($verse)
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
        
        <!-- New Verse Button -->
        <div style="text-align: center;">
            <button 
                wire:click="refreshVerse"
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
    @else
        <p style="text-align: center; color: #6b7280;">No verses available</p>
    @endif
</div>
