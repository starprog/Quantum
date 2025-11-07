@props(['audioFiles', 'verseReference' => ''])

@if($audioFiles->isNotEmpty())
<div class="bg-white rounded-lg shadow-md p-6 mt-4">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">
        <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
        </svg>
        Listen to {{ $verseReference }}
    </h3>

    <!-- Audio Version Selector -->
    @if($audioFiles->count() > 1)
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">Select Version:</label>
        <select id="audio-version-select" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            @foreach($audioFiles as $index => $audio)
            <option value="{{ $index }}" data-url="{{ Storage::url($audio->audio_url) }}" data-duration="{{ $audio->duration }}">
                {{ $audio->version }} - {{ $audio->language }} 
                @if($audio->narrator) ({{ $audio->narrator }}) @endif
                @if($audio->formatted_duration) - {{ $audio->formatted_duration }} @endif
            </option>
            @endforeach
        </select>
    </div>
    @endif

    <!-- Audio Player -->
    <div class="audio-player" data-initial-url="{{ Storage::url($audioFiles->first()->audio_url) }}" data-initial-duration="{{ $audioFiles->first()->duration }}">
        <!-- Hidden Audio Element -->
        <audio id="audio-element" preload="metadata">
            <source src="{{ Storage::url($audioFiles->first()->audio_url) }}" type="audio/{{ $audioFiles->first()->file_format }}">
            Your browser does not support the audio element.
        </audio>

        <!-- Custom Controls -->
        <div class="flex items-center space-x-4">
            <!-- Play/Pause Button -->
            <button id="play-pause-btn" class="flex-shrink-0 w-12 h-12 bg-indigo-600 text-white rounded-full flex items-center justify-center hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <svg id="play-icon" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                </svg>
                <svg id="pause-icon" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M5.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75A.75.75 0 007.25 3h-1.5zM12.75 3a.75.75 0 00-.75.75v12.5c0 .414.336.75.75.75h1.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75h-1.5z"/>
                </svg>
            </button>

            <!-- Progress Bar -->
            <div class="flex-grow">
                <div class="flex items-center justify-between text-xs text-gray-600 mb-1">
                    <span id="current-time">0:00</span>
                    <span id="total-time">{{ $audioFiles->first()->formatted_duration ?? '0:00' }}</span>
                </div>
                <div class="relative h-2 bg-gray-200 rounded-full cursor-pointer" id="progress-bar">
                    <div id="progress-fill" class="absolute h-full bg-indigo-600 rounded-full" style="width: 0%"></div>
                    <div id="progress-handle" class="absolute w-4 h-4 bg-indigo-600 rounded-full shadow-md" style="left: 0%; top: -4px; transform: translateX(-50%)"></div>
                </div>
            </div>

            <!-- Speed Control -->
            <div class="flex-shrink-0">
                <button id="speed-btn" class="px-3 py-1 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    1x
                </button>
            </div>

            <!-- Download Button -->
            <a href="{{ Storage::url($audioFiles->first()->audio_url) }}" download id="download-link" class="flex-shrink-0 p-2 text-gray-600 hover:text-indigo-600 focus:outline-none" title="Download">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const audio = document.getElementById('audio-element');
    const playPauseBtn = document.getElementById('play-pause-btn');
    const playIcon = document.getElementById('play-icon');
    const pauseIcon = document.getElementById('pause-icon');
    const progressBar = document.getElementById('progress-bar');
    const progressFill = document.getElementById('progress-fill');
    const progressHandle = document.getElementById('progress-handle');
    const currentTimeSpan = document.getElementById('current-time');
    const totalTimeSpan = document.getElementById('total-time');
    const speedBtn = document.getElementById('speed-btn');
    const versionSelect = document.getElementById('audio-version-select');
    const downloadLink = document.getElementById('download-link');

    let speeds = [0.5, 0.75, 1, 1.25, 1.5, 2];
    let currentSpeedIndex = 2; // Start at 1x

    // Play/Pause
    playPauseBtn.addEventListener('click', function() {
        if (audio.paused) {
            audio.play();
            playIcon.classList.add('hidden');
            pauseIcon.classList.remove('hidden');
        } else {
            audio.pause();
            playIcon.classList.remove('hidden');
            pauseIcon.classList.add('hidden');
        }
    });

    // Update progress
    audio.addEventListener('timeupdate', function() {
        const progress = (audio.currentTime / audio.duration) * 100;
        progressFill.style.width = progress + '%';
        progressHandle.style.left = progress + '%';
        currentTimeSpan.textContent = formatTime(audio.currentTime);
    });

    // Load metadata
    audio.addEventListener('loadedmetadata', function() {
        totalTimeSpan.textContent = formatTime(audio.duration);
    });

    // Progress bar click
    progressBar.addEventListener('click', function(e) {
        const rect = progressBar.getBoundingClientRect();
        const pos = (e.clientX - rect.left) / rect.width;
        audio.currentTime = pos * audio.duration;
    });

    // Speed control
    speedBtn.addEventListener('click', function() {
        currentSpeedIndex = (currentSpeedIndex + 1) % speeds.length;
        const newSpeed = speeds[currentSpeedIndex];
        audio.playbackRate = newSpeed;
        speedBtn.textContent = newSpeed + 'x';
    });

    // Version selector
    if (versionSelect) {
        versionSelect.addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            const newUrl = option.dataset.url;
            const wasPlaying = !audio.paused;
            
            audio.src = newUrl;
            downloadLink.href = newUrl;
            
            if (wasPlaying) {
                audio.play();
            }
            
            // Reset progress
            progressFill.style.width = '0%';
            progressHandle.style.left = '0%';
            currentTimeSpan.textContent = '0:00';
        });
    }

    // Format time helper
    function formatTime(seconds) {
        if (isNaN(seconds)) return '0:00';
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return mins + ':' + (secs < 10 ? '0' : '') + secs;
    }

    // Reset when ended
    audio.addEventListener('ended', function() {
        playIcon.classList.remove('hidden');
        pauseIcon.classList.add('hidden');
        audio.currentTime = 0;
    });
});
</script>
@endif
