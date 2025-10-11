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
            <!-- Verse content -->
            <div class="relative text-white">
                <!-- Decorative quote marks -->
                <span class="absolute -top-6 -left-6 text-8xl text-white/10 font-serif leading-none">"</span>
                <span class="absolute -bottom-6 -right-6 text-8xl text-white/10 font-serif leading-none rotate-180">"</span>
                
                <!-- Verse text -->
                <blockquote class="relative z-10 text-2xl md:text-3xl font-serif leading-relaxed px-4">
                    {{ $verse['verse'] }}
                </blockquote>

                <!-- Verse reference -->
                <div class="text-right mt-6">
                    <span class="inline-block border-t border-white/20 pt-4 text-white/80 font-medium tracking-wide">
                        {{ $verse['reference'] }}
                    </span>
                </div>
            </div>

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
        </div>
    </div>
</div>