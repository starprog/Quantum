<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 p-8 relative">
        <!-- Background patterns -->
        <div class="absolute inset-0 bg-repeat opacity-10" style="background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48Y2lyY2xlIGN4PSIyMCIgY3k9IjIwIiByPSIxIiBmaWxsPSIjZmZmIi8+PC9zdmc+')"></div>

        <div class="max-w-2xl mx-auto">
            <!-- Date display and Navigation -->
            <div class="text-center mb-6">
                <h2 class="text-white text-xl font-medium mb-2">Verse of the Day</h2>
                <p class="text-blue-200 text-sm mb-4">{{ now()->format('F j, Y') }}</p>
                <a href="{{ route('bible-verse') }}" class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-full transition-all duration-200 backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                    </svg>
                    Browse All Verses
                </a>
            </div>

            <!-- Verse card -->
            <div class="bg-white/90 backdrop-blur-lg rounded-xl p-8 shadow-2xl border border-white/20 relative overflow-hidden">
                @if($verse)
                    <!-- Decorative elements -->
                    <div class="absolute top-0 left-0 w-32 h-32 bg-blue-500/20 rounded-full filter blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute bottom-0 right-0 w-32 h-32 bg-purple-500/20 rounded-full filter blur-3xl translate-x-1/2 translate-y-1/2"></div>

                    <!-- Verse content -->
                    <div class="relative z-10">
                        <!-- Category tag -->
                        <div class="mb-4">
                            <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800">
                                {{ $verse->category->name }}
                            </span>
                        </div>

                        <!-- Verse text -->
                        <div class="relative">
                            <!-- Decorative quote marks -->
                            <div class="absolute -top-6 -left-6 text-8xl text-blue-200/50 font-serif">"</div>
                            <div class="absolute -bottom-6 -right-6 text-8xl text-blue-200/50 font-serif rotate-180">"</div>
                            
                            <blockquote class="relative z-10 text-2xl md:text-3xl font-serif leading-relaxed px-4 text-gray-900">
                                {{ $verse->verse }}
                            </blockquote>
                        </div>

                        <!-- Reference -->
                        <div class="mt-6 text-right">
                            <span class="inline-block border-t border-blue-200/30 pt-4 text-gray-700 font-semibold tracking-wide">
                                {{ $verse->reference }}
                            </span>
                        </div>

                        <!-- Share section -->
                        <div class="mt-6 relative">
                            <div class="text-center mb-4">
                                <h3 class="text-gray-600 text-sm font-medium uppercase tracking-wider">Share via links below</h3>
                            </div>

                            <div class="flex flex-wrap justify-center gap-3">
                                <!-- Share buttons -->
                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($verse->verse . ' - ' . $verse->reference) }}"
                                   target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-900 rounded-full hover:bg-gray-200 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                    </svg>
                                    <span>Share on X</span>
                                </a>

                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}&quote={{ urlencode($verse->verse . ' - ' . $verse->reference) }}"
                                   target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-900 rounded-full hover:bg-gray-200 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                    <span>Share on Facebook</span>
                                </a>

                                <a href="whatsapp://send?text={{ urlencode($verse->verse . ' - ' . $verse->reference) }}"
                                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-900 rounded-full hover:bg-gray-200 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    <span>Share on WhatsApp</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-600 text-center">No verse available for today.</p>
                @endif
            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-center space-x-4">
                <a href="{{ route('bible-verse') }}" 
                   class="inline-flex items-center px-6 py-3 bg-white/10 text-white rounded-full hover:bg-white/20 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Bible Verses
                </a>
            </div>
        </div>
    </div>
</x-app-layout>