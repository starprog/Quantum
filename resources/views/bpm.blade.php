<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-400 leading-tight">
            {{ __('BPM Finder') }}
        </h2>
    </x-slot>

    <div class="min-h-screen flex items-center justify-center bg-transparent text-white relative overflow-hidden">

    <!-- Full-viewport fixed canvas background -->
    <canvas id="spectrum-canvas" aria-hidden="true" style="position:fixed;inset:0;width:100vw;height:100vh;z-index:0;pointer-events:none;"></canvas>

    <!-- Centered content (z-index above canvas) -->
    <div class="z-10 flex flex-col items-center gap-6 p-6 w-full max-w-3xl mx-auto">
        <h1 class="text-4xl font-semibold text-slate-400 drop-shadow">BPM Finder</h1>

        <div id="player-card" class="flex flex-col items-center gap-4 w-full max-w-xl mx-auto bg-slate-900/70 backdrop-blur-md rounded-xl p-6 shadow-lg border border-slate-800/40">
            <div id="cover-wrapper" class="relative w-56 h-56 bg-slate-800/60 rounded-xl shadow-inner flex items-center justify-center overflow-hidden">
                <div id="cover-spinner" class="hidden absolute inset-0 flex flex-col items-center justify-center bg-black/40">
                    <svg class="animate-spin h-12 w-12 text-sky-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <div id="cover-spinner-text" class="text-xs text-slate-100 mt-2">Estimating BPM...</div>
                </div>
                <img id="cover-image" src="" alt="cover" class="object-cover w-full h-full hidden">
            </div>

            <div class="w-full text-center">
                <div id="bpm-display" class="text-4xl font-extrabold text-sky-200 mt-2 drop-shadow">— BPM</div>
                <div id="track-title" class="text-sm text-slate-300 mt-1">No track loaded</div>
            </div>

            <div class="w-full flex gap-3 mt-3 items-center">
                <input id="file-input" type="file" accept="audio/*" class="flex-1 p-3 rounded bg-slate-800/40 text-slate-100" />
                <button id="play-toggle" class="w-28 flex-shrink-0 px-3 py-3 rounded bg-sky-600 hover:bg-sky-700 text-white font-semibold">Play</button>
            </div>

            <div class="w-full mt-3">
                <div id="status-note" class="text-xs text-slate-400 mt-2">Upload an audio file or drag & drop to estimate BPM. Direct audio URLs may work when CORS permits.</div>
            </div>

            <!-- cover area (no persistent-logo hint) -->

            <audio id="audio" controls class="w-full hidden mt-3"></audio>
        </div>

        <!-- Feature highlights centered below the player for polish -->
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4 w-full text-center">
            <div class="p-4 bg-slate-800/40 rounded-lg border border-slate-700/40">
                <div class="font-semibold text-slate-100">Fast Detection</div>
                <div class="text-sm text-slate-300">Client-side BPM estimate in seconds.</div>
            </div>
            <div class="p-4 bg-slate-800/40 rounded-lg border border-slate-700/40">
                <div class="font-semibold text-slate-100">Live Visualizer</div>
                <div class="text-sm text-slate-300">Real-time spectrum synced to playback.</div>
            </div>
        </div>
    </div>
    </div>

    </div>

</x-app-layout>
