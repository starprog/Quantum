<div class="min-h-screen bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 p-8 relative">
    <!-- Background patterns -->
    <div class="absolute inset-0 bg-repeat opacity-10" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48Y2lyY2xlIGN4PSIyMCIgY3k9IjIwIiByPSIxIiBmaWxsPSIjZmZmIi8+PC9zdmc+')"></div>

    <div class="max-w-2xl mx-auto bg-white/10 backdrop-blur-lg rounded-xl p-8 shadow-2xl border border-white/20 relative overflow-hidden">
        <!-- Loading overlay -->
        <div wire:loading class="absolute inset-0 bg-black/20 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-white/20 border-t-white"></div>
        </div>

        <!-- Decorative elements -->
        <div class="absolute top-0 left-0 w-32 h-32 bg-blue-500/20 rounded-full filter blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-32 h-32 bg-purple-500/20 rounded-full filter blur-3xl translate-x-1/2 translate-y-1/2"></div>

        <!-- Content container -->
        <div class="relative z-10 space-y-6">
            <!-- Category buttons -->
            <div class="flex flex-wrap gap-2 justify-center">
                <button wire:click="$set('selectedCategory', null)" 
                        class="px-4 py-2 rounded-full text-sm {{ is_null($selectedCategory) ? 'bg-white text-blue-900' : 'bg-white/10 text-white hover:bg-white/20' }} transition-colors">
                    All Categories
                </button>
                @foreach($categories as $category)
                    <button wire:click="$set('selectedCategory', '{{ $category->name }}')" 
                            class="px-4 py-2 rounded-full text-sm {{ $selectedCategory === $category->name ? 'bg-white text-blue-900' : 'bg-white/10 text-white hover:bg-white/20' }} transition-colors">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            <!-- Search bar -->
            <div class="flex gap-2">
                <div class="flex-1 relative">
                    <input 
                        type="text" 
                        wire:model.live.debounce.500ms="searchTerm"
                        placeholder="Search verses by text or reference..." 
                        class="w-full px-4 py-3 pl-12 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 backdrop-blur-sm"
                    >
                    <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                @if(!empty($searchTerm))
                    <button 
                        wire:click="clearSearch"
                        class="px-4 py-3 bg-white/10 hover:bg-white/20 text-white rounded-lg transition-colors"
                        title="Clear search"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                @endif
            </div>

            @if($isSearching && count($verses) > 0)
                <!-- Search results -->
                <div class="space-y-3 max-h-96 overflow-y-auto scrollbar-thin scrollbar-thumb-white/20 scrollbar-track-transparent">
                    <div class="text-white/70 text-sm mb-2">
                        Found {{ count($verses) }} verse{{ count($verses) !== 1 ? 's' : '' }}
                    </div>
                    @foreach($verses as $result)
                        <button 
                            wire:click="selectVerse({{ $result->id }})"
                            class="w-full text-left p-4 bg-white/5 hover:bg-white/10 rounded-lg border border-white/10 hover:border-white/20 transition-all group"
                        >
                            <div class="text-white/90 font-medium mb-1">{{ $result->reference }}</div>
                            <div class="text-white/60 text-sm line-clamp-2 group-hover:text-white/80 transition-colors">
                                {{ Str::limit($result->verse, 150) }}
                            </div>
                            <div class="text-xs text-white/40 mt-2">{{ $result->category->name }}</div>
                        </button>
                    @endforeach
                </div>
            @elseif($isSearching && count($verses) === 0)
                <!-- No results -->
                <div class="text-center py-8 text-white/60">
                    <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-lg">No verses found matching "{{ $searchTerm }}"</p>
                    <p class="text-sm mt-2">Try a different search term or clear the search to browse all verses.</p>
                </div>
            @endif

            @if(!$isSearching && $verse)
            <!-- Verse content -->
            <div class="relative text-white">
                <!-- Decorative quote marks -->
                <span class="absolute -top-6 -left-6 text-8xl text-white/10 font-serif leading-none">"</span>
                <span class="absolute -bottom-6 -right-6 text-8xl text-white/10 font-serif leading-none rotate-180">"</span>
                
                <!-- Verse text -->
                <blockquote class="relative z-10 text-2xl md:text-3xl font-serif leading-relaxed px-4">
                    {{ $verse->verse }}
                </blockquote>

                <!-- Verse reference -->
                <div class="text-right mt-6">
                    <span class="inline-block border-t border-white/20 pt-4 text-white/80 font-medium tracking-wide">
                        {{ $verse->reference }}
                    </span>
                </div>

                <!-- Category selection -->
                <div class="mt-6 flex flex-wrap justify-center gap-2">
                    <button 
                        wire:click="selectCategory(null)"
                        class="px-4 py-2 rounded-lg {{ !$selectedCategory ? 'bg-white/20 text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }} transition-all">
                        All Categories
                    </button>
                    @foreach($categories as $category)
                        <button 
                            wire:click="selectCategory('{{ $category->name }}')"
                            class="px-4 py-2 rounded-lg {{ $selectedCategory === $category->name ? 'bg-white/20 text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }} transition-all">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>

                <!-- Share buttons -->
                <div class="mt-6 flex justify-end">
                    <x-bible-verse::share-buttons 
                        :verse="$verse->verse"
                        :reference="$verse->reference"
                    />
                </div>
            </div>
            @endif

            @if(!$isSearching)
            <!-- New Verse Button -->
            <div class="mt-8 flex justify-center">
                <button wire:click="refreshVerse" 
                        wire:loading.attr="disabled"
                        class="group relative px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full text-white font-medium 
                               shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 
                               transform hover:-translate-y-0.5 transition-all duration-200
                               flex items-center space-x-2
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                               disabled:opacity-50 disabled:cursor-not-allowed">
                    <span>New Verse</span>
                    <svg wire:loading.remove wire:target="refreshVerse" class="w-5 h-5 transition-transform group-hover:rotate-180 duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <svg wire:loading wire:target="refreshVerse" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
            @endif
        </div>
    </div>
</div>