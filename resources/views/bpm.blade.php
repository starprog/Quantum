<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('BPM Finder') }}
        </h2>
    </x-slot>

    <div class="min-h-screen flex items-center justify-center bg-gray-900 text-white relative overflow-hidden">
    <canvas id="spectrum-canvas" class="absolute inset-0 w-full h-full" aria-hidden="true"></canvas>

    <div class="z-10 flex flex-col items-center gap-6 p-6">
        <h1 class="text-2xl font-semibold">BPM Finder</h1>

        <div id="player-card" class="flex flex-col items-center gap-4 w-80">
            <div id="cover-wrapper" class="w-64 h-64 bg-gray-800 rounded shadow flex items-center justify-center overflow-hidden">
                <img id="cover-image" src="" alt="cover" class="object-cover w-full h-full hidden">
                <div id="no-cover" class="text-sm text-gray-400">No cover available</div>
            </div>

            <div class="w-full text-center">
                <div id="bpm-display" class="text-3xl font-bold">— BPM</div>
                <div id="track-title" class="text-sm text-gray-300 mt-1">No track loaded</div>
            </div>

            <div class="w-full flex gap-2">
                <input id="file-input" type="file" accept="audio/*" class="flex-1 p-2 rounded bg-gray-800" />
                <button id="play-toggle" class="px-3 py-2 rounded bg-indigo-600">Play</button>
            </div>

            <audio id="audio" controls class="w-full hidden"></audio>
        </div>
    </div>
</div>

    </div>

</x-app-layout>
