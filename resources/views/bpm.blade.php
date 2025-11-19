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
            <div id="cover-wrapper" class="w-56 h-56 bg-slate-800/60 rounded-xl shadow-inner flex items-center justify-center overflow-hidden">
                <img id="cover-image" src="" alt="cover" class="object-cover w-full h-full hidden">
                <div id="no-cover" class="text-sm text-slate-300">No cover available</div>
            </div>

            <div class="w-full text-center">
                <div id="bpm-display" class="text-4xl font-extrabold text-sky-200 mt-2 drop-shadow">— BPM</div>
                <div id="track-title" class="text-sm text-slate-300 mt-1">No track loaded</div>
            </div>

            <div class="w-full flex gap-3 mt-3 items-center">
                <input id="file-input" type="file" accept="audio/*" class="flex-1 p-3 rounded bg-slate-800/40 text-slate-100" />
                <button id="play-toggle" class="w-28 flex-shrink-0 px-3 py-3 rounded bg-sky-600 hover:bg-sky-700 text-white font-semibold">Play</button>
            </div>

            <audio id="audio" controls class="w-full hidden mt-3"></audio>
        </div>

        <!-- Feature highlights centered below the player for polish -->
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4 w-full text-center">
            <div class="p-4 bg-slate-800/40 rounded-lg border border-slate-700/40">
                <div class="font-semibold text-slate-100">Fast Detection</div>
                <div class="text-sm text-slate-300">Client-side BPM estimate in seconds.</div>
            </div>
            <div class="p-4 bg-slate-800/40 rounded-lg border border-slate-700/40">
                <div class="font-semibold text-slate-100">Cover Art</div>
                <div class="text-sm text-slate-300">Displays embedded artwork when available.</div>
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
