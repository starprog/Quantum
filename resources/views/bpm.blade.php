<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-400 leading-tight">
            {{ __('BPM Finder') }}
        </h2>
    </x-slot>

    <!-- Load jsmediatags from CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsmediatags/3.9.5/jsmediatags.min.js"></script>

    <style>
        @keyframes pulse-ring {
            0% { transform: scale(0.95); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.5; }
            100% { transform: scale(0.95); opacity: 1; }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .pulse-ring {
            animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        .float {
            animation: float 3s ease-in-out infinite;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        #spectrum-canvas {
            filter: blur(80px) opacity(0.3);
        }
    </style>

    <div class="min-h-screen flex items-center justify-center relative overflow-hidden" style="background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);">

    <!-- Session History Button (Bottom-right, floating) -->
    <div class="fixed bottom-6 right-6 z-30">
        <button id="history-toggle" class="p-4 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 shadow-lg text-white hover:shadow-2xl hover:scale-110 transition-all" title="Session History">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </button>
    </div>

    <!-- Session History Panel (Bottom) -->
    <div id="history-panel" class="hidden fixed bottom-0 left-0 right-0 h-64 bg-slate-900/95 backdrop-blur-md border-t border-white/10 overflow-y-auto z-20 p-6">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-white">Session History</h2>
                <div class="flex gap-2">
                    <button id="clear-history" class="px-3 py-1 text-sm bg-red-500/20 text-red-300 rounded-lg hover:bg-red-500/30 transition-colors">
                        Clear All
                    </button>
                    <button id="export-history" class="px-3 py-1 text-sm bg-purple-500/20 text-purple-300 rounded-lg hover:bg-purple-500/30 transition-colors">
                        Export JSON
                    </button>
                    <button id="close-history" class="text-slate-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div id="history-content" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                <div class="text-center py-8 text-slate-400 col-span-full">No tracks analyzed yet. Upload a track to get started!</div>
            </div>
        </div>
    </div>

    <!-- Blurred canvas background -->
    <canvas id="spectrum-canvas" aria-hidden="true" style="position:fixed;inset:0;width:100vw;height:100vh;z-index:0;pointer-events:none;"></canvas>

    <!-- Left Panel: Track Statistics -->
    <div id="track-stats-panel" class="hidden fixed left-0 top-0 h-screen w-80 bg-slate-900/95 backdrop-blur-md border-r border-white/10 overflow-y-auto z-20 p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-white">Track Statistics</h2>
            <button id="close-stats" class="text-slate-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div id="stats-loading" class="flex items-center justify-center py-12">
            <svg class="animate-spin h-8 w-8 text-purple-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
        </div>
        
        <div id="stats-content" class="hidden space-y-6">
            <!-- Album art -->
            <div class="flex justify-center">
                <img id="stats-album-art" src="" alt="Album art" class="w-48 h-48 rounded-lg shadow-lg hidden">
            </div>
            
            <!-- Track info -->
            <div>
                <h3 id="stats-track-name" class="text-lg font-semibold text-white mb-1"></h3>
                <p id="stats-artist-name" class="text-sm text-slate-400"></p>
            </div>
            
            <!-- Stats grid -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-slate-800/50 rounded-lg p-3">
                    <div class="text-xs text-slate-400 mb-1">Listeners</div>
                    <div id="stats-listeners" class="text-lg font-bold text-purple-400">—</div>
                </div>
                <div class="bg-slate-800/50 rounded-lg p-3">
                    <div class="text-xs text-slate-400 mb-1">Play Count</div>
                    <div id="stats-playcount" class="text-lg font-bold text-purple-400">—</div>
                </div>
            </div>
            
            <!-- Tags -->
            <div>
                <div class="text-xs text-slate-400 mb-2">Tags</div>
                <div id="stats-tags" class="flex flex-wrap gap-2"></div>
            </div>
            
            <!-- Wiki summary -->
            <div>
                <div class="text-xs text-slate-400 mb-2">About</div>
                <p id="stats-wiki" class="text-sm text-slate-300 leading-relaxed"></p>
            </div>
        </div>
        
        <div id="stats-error" class="hidden text-center py-12">
            <div class="text-slate-400 text-sm">
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p id="stats-error-message">Track info not found</p>
            </div>
        </div>
    </div>

    <!-- Right Panel: Recommendations -->
    <div id="recommendations-panel" class="hidden fixed right-0 top-0 h-screen w-80 bg-slate-900/95 backdrop-blur-md border-l border-white/10 overflow-y-auto z-20 p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-white">Similar Tracks</h2>
            <button id="close-recommendations" class="text-slate-400 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div id="recs-loading" class="flex items-center justify-center py-12">
            <svg class="animate-spin h-8 w-8 text-purple-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
        </div>
        
        <div id="recs-content" class="hidden space-y-3"></div>
        
        <div id="recs-error" class="hidden text-center py-12">
            <div class="text-slate-400 text-sm">
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p id="recs-error-message">No recommendations found</p>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="z-10 flex flex-col items-center gap-8 p-6 w-full max-w-2xl mx-auto">
        
        <!-- Logo and title -->
        <div class="text-center float">
            <h1 class="text-5xl font-bold mb-2" style="background: linear-gradient(135deg, #667eea 0%, #f093fb 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">BPM Finder</h1>
            <p class="text-slate-400 text-sm">Find the beats per minute of your favorite tracks!</p>
        </div>

        <!-- Circular player card -->
        <div id="player-card" class="relative flex flex-col items-center gap-6 w-full">
            
            <!-- Circular cover with pulsing ring -->
            <div class="relative">
                <!-- Pulsing outer ring -->
                <div class="absolute inset-0 rounded-full bg-gradient-to-br from-purple-500/30 to-blue-500/30 pulse-ring" style="width: 280px; height: 280px; margin: -10px;"></div>
                
                <!-- Cover wrapper -->
                <div id="cover-wrapper" class="relative w-64 h-64 rounded-full shadow-2xl flex items-center justify-center overflow-hidden bg-gradient-to-br from-slate-800 to-slate-900 border-4 border-white/10">
                    <!-- Spinner overlay -->
                    <div id="cover-spinner" class="hidden absolute inset-0 flex flex-col items-center justify-center bg-black/60 backdrop-blur-sm rounded-full">
                        <svg class="animate-spin h-16 w-16 text-purple-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <div id="cover-spinner-text" class="text-xs text-white mt-3 font-medium">Analyzing...</div>
                    </div>
                    <img id="cover-image" src="" alt="cover" class="object-cover w-full h-full hidden rounded-full">
                </div>
            </div>

            <!-- BPM Display -->
            <div class="text-center -mt-2">
                <div id="bpm-display" class="text-7xl font-black tracking-tight" style="background: linear-gradient(135deg, #667eea 0%, #f093fb 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-shadow: 0 0 30px rgba(102, 126, 234, 0.3);">—</div>
                <div class="text-sm text-slate-400 font-medium mt-1 tracking-widest uppercase">Beats Per Minute</div>
            </div>

            <!-- Track title -->
            <div id="track-title" class="text-center text-white text-lg font-medium px-6 max-w-sm truncate">Tap to upload a track</div>

            <!-- Metadata info buttons -->
            <div id="metadata-buttons" class="hidden flex gap-3 w-full max-w-sm">
                <button id="show-stats" class="flex-1 py-2 px-4 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white text-sm font-semibold hover:bg-white/20 transition-all duration-300">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Stats
                    </span>
                </button>
                <button id="show-recommendations" class="flex-1 py-2 px-4 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white text-sm font-semibold hover:bg-white/20 transition-all duration-300">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                        </svg>
                        Similar
                    </span>
                </button>
            </div>

            <!-- File input styled as button -->
            <div class="relative w-full max-w-sm">
                <input id="file-input" type="file" accept="audio/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />
                <button class="w-full py-4 rounded-full font-bold text-lg text-white shadow-lg transition-all duration-300 hover:shadow-2xl hover:scale-105" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Choose Audio File
                    </span>
                </button>
            </div>

            <!-- Play button -->
            <button id="play-toggle" class="w-full max-w-sm py-3 px-6 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold hover:bg-white/20 transition-all duration-300">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"></path>
                    </svg>
                    Play
                </span>
            </button>

            <!-- Status note -->
            <div id="status-note" class="text-center text-slate-400 text-xs max-w-md px-4">Drag & drop audio files or tap to browse. BPM analysis happens instantly.</div>

            <!-- Hidden audio element -->
            <audio id="audio" class="hidden"></audio>
        </div>

        <!-- Minimalist features -->
        <div class="mt-8 flex gap-6 text-center text-sm">
            <div class="flex flex-col items-center gap-1">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500/20 to-blue-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="text-slate-300 font-medium text-xs">Instant</div>
            </div>
            <div class="flex flex-col items-center gap-1">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500/20 to-blue-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                    </svg>
                </div>
                <div class="text-slate-300 font-medium text-xs">Accurate</div>
            </div>
            <div class="flex flex-col items-center gap-1">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500/20 to-blue-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path>
                    </svg>
                </div>
                <div class="text-slate-300 font-medium text-xs">Visual</div>
            </div>
        </div>

    </div>
    </div>

</x-app-layout>