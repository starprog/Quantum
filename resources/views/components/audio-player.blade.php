<div x-data="audioPlayer({{ json_encode($verse) }})" x-init="init()" class="audio-player">
    <!-- Audio Control Button -->
    <button 
        @click="toggleAudio()" 
        :disabled="!isSupported"
        class="inline-flex items-center px-4 py-2 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg"
        :class="isPlaying ? 'bg-red-500 hover:bg-red-600 text-white' : 'bg-purple-600 hover:bg-purple-700 text-white'"
        :title="!isSupported ? 'Text-to-speech not supported in this browser' : (isPlaying ? 'Stop' : 'Listen to Verse')">
        
        <!-- Play Icon -->
        <svg x-show="!isPlaying" class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
        </svg>
        
        <!-- Stop Icon -->
        <svg x-show="isPlaying" class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" style="display: none;">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" clip-rule="evenodd"/>
        </svg>
        
        <span x-text="isPlaying ? 'Stop' : 'Listen'"></span>
    </button>

    <!-- Audio Controls (shown when playing) -->
    <div x-show="isPlaying" x-transition class="mt-3 p-4 bg-white rounded-lg shadow-inner border border-purple-100" style="display: none;">
        <!-- Speed Control -->
        <div class="mb-3">
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Speed: <span x-text="rate + 'x'"></span>
            </label>
            <input 
                type="range" 
                x-model.number="rate" 
                @input="updateRate()"
                min="0.5" 
                max="2" 
                step="0.1"
                class="w-full h-2 bg-purple-200 rounded-lg appearance-none cursor-pointer slider">
        </div>

        <!-- Pitch Control -->
        <div class="mb-3">
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Pitch: <span x-text="pitch"></span>
            </label>
            <input 
                type="range" 
                x-model.number="pitch" 
                @input="updatePitch()"
                min="0" 
                max="2" 
                step="0.1"
                class="w-full h-2 bg-purple-200 rounded-lg appearance-none cursor-pointer slider">
        </div>

        <!-- Volume Control -->
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Volume: <span x-text="Math.round(volume * 100) + '%'"></span>
            </label>
            <input 
                type="range" 
                x-model.number="volume" 
                @input="updateVolume()"
                min="0" 
                max="1" 
                step="0.1"
                class="w-full h-2 bg-purple-200 rounded-lg appearance-none cursor-pointer slider">
        </div>
    </div>
</div>

<script>
function audioPlayer(verse) {
    return {
        verse: verse,
        isPlaying: false,
        isSupported: false,
        utterance: null,
        rate: 1.0,
        pitch: 1.0,
        volume: 1.0,
        
        init() {
            // Check if speech synthesis is supported
            this.isSupported = 'speechSynthesis' in window;
            
            if (this.isSupported) {
                // Load user preferences from localStorage
                const savedRate = localStorage.getItem('audioRate');
                const savedPitch = localStorage.getItem('audioPitch');
                const savedVolume = localStorage.getItem('audioVolume');
                
                if (savedRate) this.rate = parseFloat(savedRate);
                if (savedPitch) this.pitch = parseFloat(savedPitch);
                if (savedVolume) this.volume = parseFloat(savedVolume);
            }
        },
        
        toggleAudio() {
            if (!this.isSupported) {
                alert('Text-to-speech is not supported in your browser. Please try Chrome, Safari, or Edge.');
                return;
            }
            
            if (this.isPlaying) {
                this.stopAudio();
            } else {
                this.playAudio();
            }
        },
        
        playAudio() {
            // Cancel any ongoing speech
            window.speechSynthesis.cancel();
            
            // Create speech text from verse
            const text = `${this.verse.text}. ${this.verse.book} ${this.verse.chapter}:${this.verse.verse}`;
            
            // Create utterance
            this.utterance = new SpeechSynthesisUtterance(text);
            this.utterance.rate = this.rate;
            this.utterance.pitch = this.pitch;
            this.utterance.volume = this.volume;
            
            // Set up event listeners
            this.utterance.onstart = () => {
                this.isPlaying = true;
            };
            
            this.utterance.onend = () => {
                this.isPlaying = false;
            };
            
            this.utterance.onerror = (event) => {
                console.error('Speech synthesis error:', event);
                this.isPlaying = false;
                alert('An error occurred while playing audio. Please try again.');
            };
            
            // Start speaking
            window.speechSynthesis.speak(this.utterance);
        },
        
        stopAudio() {
            window.speechSynthesis.cancel();
            this.isPlaying = false;
        },
        
        updateRate() {
            localStorage.setItem('audioRate', this.rate);
            if (this.isPlaying && this.utterance) {
                // Restart with new rate
                const currentText = this.utterance.text;
                this.stopAudio();
                setTimeout(() => this.playAudio(), 100);
            }
        },
        
        updatePitch() {
            localStorage.setItem('audioPitch', this.pitch);
            if (this.isPlaying && this.utterance) {
                // Restart with new pitch
                this.stopAudio();
                setTimeout(() => this.playAudio(), 100);
            }
        },
        
        updateVolume() {
            localStorage.setItem('audioVolume', this.volume);
            if (this.isPlaying && this.utterance) {
                this.utterance.volume = this.volume;
            }
        }
    }
}
</script>

<style>
.slider::-webkit-slider-thumb {
    appearance: none;
    width: 20px;
    height: 20px;
    background: #667eea;
    cursor: pointer;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.slider::-webkit-slider-thumb:hover {
    background: #764ba2;
    transform: scale(1.1);
}

.slider::-moz-range-thumb {
    width: 20px;
    height: 20px;
    background: #667eea;
    cursor: pointer;
    border-radius: 50%;
    border: none;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.slider::-moz-range-thumb:hover {
    background: #764ba2;
    transform: scale(1.1);
}
</style>
