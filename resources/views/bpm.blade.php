<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('BPM Finder') }}
        </h2>
    </x-slot>

    <div class="min-h-screen flex items-center justify-center bg-transparent text-white relative overflow-hidden">

    <!-- Full-viewport fixed canvas background -->
    <canvas id="spectrum-canvas" aria-hidden="true" style="position:fixed;inset:0;width:100vw;height:100vh;z-index:0;pointer-events:none;"></canvas>

    <!-- Centered content (z-index above canvas) -->
    <div class="z-10 flex flex-col items-center gap-6 p-6 w-full max-w-3xl mx-auto">
        <h1 class="text-3xl font-semibold text-white drop-shadow">BPM Finder</h1>

        <div id="player-card" class="flex flex-col items-center gap-4 w-full sm:w-96 bg-white/6 backdrop-blur-md rounded-xl p-6 shadow-lg border border-white/6">
            <div id="cover-wrapper" class="w-56 h-56 bg-white/5 rounded-xl shadow-inner flex items-center justify-center overflow-hidden">
                <img id="cover-image" src="" alt="cover" class="object-cover w-full h-full hidden">
                <div id="no-cover" class="text-sm text-slate-300">No cover available</div>
            </div>

            <div class="w-full text-center">
                <div id="bpm-display" class="text-4xl font-extrabold text-white mt-2 drop-shadow">— BPM</div>
                <div id="track-title" class="text-sm text-slate-200 mt-1">No track loaded</div>
            </div>

            <div class="w-full flex gap-2 mt-3">
                <input id="file-input" type="file" accept="audio/*" class="flex-1 p-2 rounded bg-white/10 text-white" />
                <button id="play-toggle" class="px-3 py-2 rounded bg-sky-500 hover:bg-sky-600 text-white">Play</button>
            </div>

            <audio id="audio" controls class="w-full hidden mt-3"></audio>
        </div>

        <!-- Feature highlights centered below the player for polish -->
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4 w-full text-center">
            <div class="p-4 bg-white/4 rounded-lg">
                <div class="font-semibold text-white">Fast Detection</div>
                <div class="text-sm text-slate-200">Client-side BPM estimate in seconds.</div>
            </div>
            <div class="p-4 bg-white/4 rounded-lg">
                <div class="font-semibold text-white">Cover Art</div>
                <div class="text-sm text-slate-200">Displays embedded artwork when available.</div>
            </div>
            <div class="p-4 bg-white/4 rounded-lg">
                <div class="font-semibold text-white">Live Visualizer</div>
                <div class="text-sm text-slate-200">Real-time spectrum synced to playback.</div>
            </div>
        </div>
    </div>
    </div>

    </div>

</x-app-layout>
