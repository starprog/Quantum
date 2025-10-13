<div class="min-h-screen bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 p-8 relative">
    <!-- Background patterns -->
    <div class="absolute inset-0 bg-repeat opacity-10" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48Y2lyY2xlIGN4PSIyMCIgY3k9IjIwIiByPSIxIiBmaWxsPSIjZmZmIi8+PC9zdmc+')"></div>

    <div class="max-w-2xl mx-auto bg-white/90 backdrop-blur-lg rounded-xl p-8 shadow-2xl border border-white/20 relative overflow-hidden">
        <!-- Loading overlay -->
        <div wire:loading class="absolute inset-0 bg-black/20 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-white/20 border-t-white"></div>
        </div>

        <!-- Decorative elements -->
        <div class="absolute top-0 left-0 w-32 h-32 bg-blue-500/20 rounded-full filter blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-32 h-32 bg-purple-500/20 rounded-full filter blur-3xl translate-x-1/2 translate-y-1/2"></div>

        <!-- Categories -->
        <div class="relative z-10 mb-8">
            <div class="flex flex-wrap gap-2 justify-center bg-white/95 backdrop-blur-sm p-4 rounded-2xl shadow-xl">
                <button wire:click="refreshVerse(null)" 
                        wire:loading.class="opacity-50"
                        class="px-4 py-2 rounded-full text-sm font-bold {{ is_null($selectedCategory) ? 'bg-blue-100 text-gray-900 border-2 border-blue-500 shadow-lg ring-2 ring-blue-400 ring-offset-2 ring-offset-white/90' : 'bg-gray-100 text-gray-900 hover:bg-gray-200 border-2 border-gray-300 hover:shadow-md' }} transition-all duration-200">
                    All Categories
                </button>
                @foreach($categories as $category)
                    <button wire:click="refreshVerse('{{ $category->name }}')" 
                            wire:loading.class="opacity-50"
                            class="px-4 py-2 rounded-full text-sm font-bold {{ $selectedCategory === $category->name ? 'bg-blue-100 text-gray-900 border-2 border-blue-500 shadow-lg ring-2 ring-blue-400 ring-offset-2 ring-offset-white/90' : 'bg-gray-100 text-gray-900 hover:bg-gray-200 border-2 border-gray-300 hover:shadow-md' }} transition-all duration-200">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Content container -->
        <div class="relative z-10 space-y-6">
            <!-- Verse content -->
            <div class="relative">
                <!-- Decorative quote marks -->
                <div class="absolute -top-6 -left-6 text-8xl text-blue-200/50 font-serif">"</div>
                <div class="absolute -bottom-6 -right-6 text-8xl text-blue-200/50 font-serif rotate-180">"</div>
                
                <blockquote class="relative z-10 text-2xl md:text-3xl font-serif leading-relaxed px-4 text-gray-900">
                    {{ $verse->verse }}
                </blockquote>
                
                <div class="mt-6 text-right">
                    <span class="inline-block border-t border-blue-200/30 pt-4 text-gray-700 font-semibold tracking-wide">
                        {{ $verse->reference }}
                    </span>
                </div>
            </div>

            <!-- Share buttons -->
            <div class="mt-6 relative">
                <!-- Share buttons label -->
                <div class="text-center mb-4">
                    <h3 class="text-gray-600 text-sm font-medium uppercase tracking-wider">Share via links below</h3>
                </div>

                <div class="flex flex-wrap justify-center gap-3 bg-white/95 backdrop-blur-sm p-6 rounded-2xl shadow-2xl relative z-20 border-2 border-gray-200">
                    <!-- X (Twitter) Share -->
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($verse->verse . ' - ' . $verse->reference) }}&via=QuantumBible"
                       target="_blank"
                       class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-900 rounded-full hover:bg-gray-200 transition-all duration-200 
                              transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl font-bold text-base tracking-wide
                              border-2 border-gray-300">
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                        <span>Share on X</span>
                    </a>

                    <!-- Facebook Share -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}&quote={{ urlencode($verse->verse . ' - ' . $verse->reference) }}"
                       target="_blank"
                       class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-900 rounded-full hover:bg-gray-200 transition-all duration-200 
                              transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl font-bold text-base tracking-wide
                              border-2 border-gray-300">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span>Share on Facebook</span>
                    </a>

                    <!-- LinkedIn Share -->
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                       target="_blank"
                       class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-900 rounded-full hover:bg-gray-200 transition-all duration-200 
                              transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl font-bold text-base tracking-wide
                              border-2 border-gray-300">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                        <span>Share on LinkedIn</span>
                    </a>

                    <!-- WhatsApp Share -->
                    <a href="https://wa.me/?text={{ urlencode($verse->verse . ' - ' . $verse->reference) }}"
                       target="_blank"
                       class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-900 rounded-full hover:bg-gray-200 transition-all duration-200 
                              transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl font-bold text-base tracking-wide
                              border-2 border-gray-300">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        <span>Share on WhatsApp</span>
                    </a>

                    <!-- Email Share -->
                    <a href="mailto:?subject=Bible%20Verse&body={{ urlencode($verse->verse . ' - ' . $verse->reference) }}"
                       class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-900 rounded-full hover:bg-gray-200 transition-all duration-200 
                              transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl font-bold text-base tracking-wide
                              border-2 border-gray-300">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>Share via Email</span>
                    </a>
                </div>
            </div>

            <!-- Button container -->
            

            <!-- Button container -->
            <div class="mt-8 flex justify-center">
                <button wire:click="refreshVerse('{{ $selectedCategory }}')"
                        wire:loading.attr="disabled"
                        class="group relative inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-100 to-indigo-100 text-gray-800 font-medium 
                               rounded-full shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30 
                               transform hover:-translate-y-0.5 transition-all duration-200 border border-blue-200
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400
                               disabled:opacity-50 disabled:cursor-not-allowed hover:from-blue-50 hover:to-indigo-50">
                    <span class="flex items-center space-x-2">
                        <span>New Verse</span>
                        <svg wire:loading.remove class="w-5 h-5 text-blue-600 transition-transform group-hover:rotate-180 duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <svg wire:loading class="animate-spin w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>