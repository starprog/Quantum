// BPM player and spectrum visualizer (restored, DPR-aware)

document.addEventListener('DOMContentLoaded', () => {
  const $ = sel => document.querySelector(sel);
  const fileInput = $('#file-input');
  const coverImage = $('#cover-image');
  const bpmDisplay = $('#bpm-display');
  const trackTitle = $('#track-title');
  const playToggle = $('#play-toggle');
  let audioEl = $('#audio'); // Changed to let so we can replace it
  const statusNote = $('#status-note');
  const canvas = $('#spectrum-canvas');
  const coverSpinner = $('#cover-spinner');
  const coverSpinnerText = $('#cover-spinner-text');
  
  // Metadata and panels
  const metadataButtons = $('#metadata-buttons');
  const showStatsBtn = $('#show-stats');
  const showRecsBtn = $('#show-recommendations');
  const showLyricsBtn = $('#show-lyrics');
  const statsPanel = $('#track-stats-panel');
  const recsPanel = $('#recommendations-panel');
  const lyricsPanel = $('#lyrics-panel');
  const closeStats = $('#close-stats');
  const closeRecs = $('#close-recommendations');
  const closeLyrics = $('#close-lyrics');
  const lrcFileUpload = $('#lrc-file-upload');

  let audioCtx = null;
  let analyser = null;
  let sourceNode = null;
  let rafId = null;
  let currentMetadata = null; // Store extracted metadata
  let audioElementAttached = false; // Track if MediaElementSource has been created
  let sessionHistory = []; // Store analyzed tracks
  let lyricsData = []; // Store parsed LRC lyrics with timestamps
  let lyricsUpdateInterval = null; // Interval for syncing lyrics
  

  // === SESSION HISTORY MANAGEMENT ===
  function initHistory() {
    const historyToggle = $('#history-toggle');
    const historyPanel = $('#history-panel');
    const closeHistory = $('#close-history');
    const clearHistory = $('#clear-history');
    const exportHistory = $('#export-history');
    
    // Load history from localStorage
    const saved = localStorage.getItem('bpm-session-history');
    if (saved) {
      try {
        sessionHistory = JSON.parse(saved);
        updateHistoryDisplay();
      } catch (e) {
        console.warn('[bpm-player] failed to load history', e);
      }
    }
    
    if (historyToggle) {
      historyToggle.addEventListener('click', () => {
        historyPanel.classList.toggle('hidden');
      });
    }
    
    if (closeHistory) {
      closeHistory.addEventListener('click', () => {
        historyPanel.classList.add('hidden');
      });
    }
    
    if (clearHistory) {
      clearHistory.addEventListener('click', () => {
        if (confirm('Clear all session history?')) {
          sessionHistory = [];
          localStorage.removeItem('bpm-session-history');
          updateHistoryDisplay();
        }
      });
    }
    
    if (exportHistory) {
      exportHistory.addEventListener('click', () => {
        const dataStr = JSON.stringify(sessionHistory, null, 2);
        const blob = new Blob([dataStr], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `bpm-history-${Date.now()}.json`;
        a.click();
        URL.revokeObjectURL(url);
      });
    }
  }
  
  function addToHistory(trackData) {
    const entry = {
      ...trackData,
      timestamp: Date.now(),
      id: Date.now() + Math.random()
    };
    
    sessionHistory.unshift(entry); // Add to beginning
    if (sessionHistory.length > 50) sessionHistory = sessionHistory.slice(0, 50); // Keep only last 50
    
    localStorage.setItem('bpm-session-history', JSON.stringify(sessionHistory));
    updateHistoryDisplay();
  }
  
  function updateHistoryDisplay() {
    const container = $('#history-content');
    if (!container) return;
    
    if (sessionHistory.length === 0) {
      container.innerHTML = '<div class="text-center py-8 text-slate-400 col-span-full">No tracks analyzed yet. Upload a track to get started!</div>';
      return;
    }
    
    container.innerHTML = sessionHistory.map(track => `
      <div class="bg-slate-800/50 rounded-lg p-3 hover:bg-slate-800 transition-colors">
        <div class="flex items-center gap-3 mb-2">
          ${track.albumArt ? `<img src="${track.albumArt}" alt="${track.title}" class="w-12 h-12 rounded object-cover">` : '<div class="w-12 h-12 rounded bg-slate-700 flex items-center justify-center"><svg class="w-6 h-6 text-slate-500" fill="currentColor" viewBox="0 0 20 20"><path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"></path></svg></div>'}
          <div class="flex-1 min-w-0">
            <div class="text-sm font-medium text-white truncate">${track.title || 'Unknown'}</div>
            <div class="text-xs text-slate-400 truncate">${track.artist || 'Unknown Artist'}</div>
          </div>
          <div class="text-right">
            <div class="text-lg font-bold text-purple-400">${track.bpm || '—'}</div>
            <div class="text-xs text-slate-500">BPM</div>
          </div>
        </div>
        <div class="text-xs text-slate-500">${new Date(track.timestamp).toLocaleString()}</div>
      </div>
    `).join('');
  }

  // === LYRICS & CREDITS MANAGEMENT ===
  function parseLRC(lrcText) {
    const lines = lrcText.split('\n');
    const lyrics = [];
    const timeRegex = /\[(\d{2}):(\d{2})\.(\d{2,3})\](.*)/;
    
    lines.forEach(line => {
      const match = line.match(timeRegex);
      if (match) {
        const minutes = parseInt(match[1]);
        const seconds = parseInt(match[2]);
        const centiseconds = parseInt(match[3].padEnd(3, '0'));
        const text = match[4].trim();
        const time = (minutes * 60) + seconds + (centiseconds / 1000);
        
        lyrics.push({ time, text });
      }
    });
    
    return lyrics.sort((a, b) => a.time - b.time);
  }
  
  // Fetch lyrics from Lyrics.ovh API
  async function fetchLyrics(artist, title) {
    try {
      const response = await fetch(`https://api.lyrics.ovh/v1/${encodeURIComponent(artist)}/${encodeURIComponent(title)}`);
      if (!response.ok) throw new Error('Lyrics not found');
      const data = await response.json();
      return data.lyrics;
    } catch (error) {
      console.error('[bpm-player] Lyrics fetch error', error);
      throw error;
    }
  }
  
  async function displayLyrics(trackInfo = null) {
    if (!lyricsPanel) return;
    
    lyricsPanel.classList.remove('hidden');
    $('#lyrics-loading').classList.remove('hidden');
    $('#lyrics-content').classList.add('hidden');
    $('#lyrics-error').classList.add('hidden');
    
    // Display credits from Last.fm track info
    if (trackInfo && trackInfo.track) {
      const track = trackInfo.track;
      
      // Artist
      if (track.artist?.name) {
        const creditArtist = $('#credit-artist');
        if (creditArtist) {
          creditArtist.classList.remove('hidden');
          creditArtist.querySelector('.text-white').textContent = track.artist.name;
        }
      }
      
      // Album
      if (track.album?.title) {
        const creditAlbum = $('#credit-album');
        if (creditAlbum) {
          creditAlbum.classList.remove('hidden');
          creditAlbum.querySelector('.text-white').textContent = track.album.title;
        }
      }
      
      // Year (from wiki or album)
      if (track.wiki?.published) {
        const year = new Date(track.wiki.published).getFullYear();
        const creditYear = $('#credit-year');
        if (creditYear) {
          creditYear.classList.remove('hidden');
          creditYear.querySelector('.text-white').textContent = year;
        }
      }
    } else if (currentMetadata) {
      // Fallback to current metadata
      const creditArtist = $('#credit-artist');
      if (creditArtist && currentMetadata.artist) {
        creditArtist.classList.remove('hidden');
        creditArtist.querySelector('.text-white').textContent = currentMetadata.artist;
      }
      
      const creditAlbum = $('#credit-album');
      if (creditAlbum && currentMetadata.album) {
        creditAlbum.classList.remove('hidden');
        creditAlbum.querySelector('.text-white').textContent = currentMetadata.album;
      }
    }
    
    // Check if we have uploaded LRC lyrics first
    if (lyricsData.length > 0) {
      displaySyncedLyrics();
    } else if (currentMetadata && currentMetadata.artist !== 'Unknown Artist') {
      // Try to fetch lyrics automatically from API
      try {
        const lyrics = await fetchLyrics(currentMetadata.artist, currentMetadata.title);
        if (lyrics) {
          displayPlainLyrics(lyrics);
        } else {
          throw new Error('No lyrics found');
        }
      } catch (error) {
        $('#lyrics-loading').classList.add('hidden');
        $('#lyrics-error').classList.remove('hidden');
        const errorMsg = $('#lyrics-error-message');
        if (errorMsg) {
          errorMsg.textContent = 'Lyrics not available for this track. Upload an LRC file for synced lyrics.';
        }
      }
    } else {
      // Show error message prompting to upload LRC
      $('#lyrics-loading').classList.add('hidden');
      $('#lyrics-error').classList.remove('hidden');
    }
  }
  
  function displayPlainLyrics(lyricsText) {
    const container = $('#lyrics-content');
    if (!container) return;
    
    container.innerHTML = '';
    
    // Split lyrics into lines
    const lines = lyricsText.split('\n').filter(line => line.trim());
    
    lines.forEach((line, index) => {
      const div = document.createElement('div');
      div.className = 'lyrics-line text-slate-300 text-sm py-1 leading-relaxed';
      div.textContent = line.trim();
      container.appendChild(div);
    });
    
    // Add scroll hint
    const scrollHint = document.createElement('div');
    scrollHint.className = 'text-center text-slate-500 text-xs mt-4 sticky bottom-0 bg-slate-900/80 py-2';
    scrollHint.innerHTML = '↕ Scroll to view all lyrics';
    container.appendChild(scrollHint);
    
    $('#lyrics-loading').classList.add('hidden');
    $('#lyrics-content').classList.remove('hidden');
  }
  
  function displaySyncedLyrics() {
    const container = $('#lyrics-content');
    if (!container) return;
    
    container.innerHTML = '';
    lyricsData.forEach((line, index) => {
      const div = document.createElement('div');
      div.className = 'lyrics-line text-slate-400 transition-all duration-300 py-1';
      div.dataset.time = line.time;
      div.dataset.index = index;
      div.textContent = line.text || '♪';
      container.appendChild(div);
    });
    
    $('#lyrics-loading').classList.add('hidden');
    $('#lyrics-content').classList.remove('hidden');
    
    // Start syncing lyrics with audio playback
    startLyricsSync();
  }
  
  function startLyricsSync() {
    // Clear any existing interval
    if (lyricsUpdateInterval) {
      clearInterval(lyricsUpdateInterval);
    }
    
    lyricsUpdateInterval = setInterval(() => {
      if (!audioEl || audioEl.paused) return;
      
      const currentTime = audioEl.currentTime;
      const lyricsLines = document.querySelectorAll('.lyrics-line');
      
      let activeIndex = -1;
      for (let i = lyricsData.length - 1; i >= 0; i--) {
        if (currentTime >= lyricsData[i].time) {
          activeIndex = i;
          break;
        }
      }
      
      lyricsLines.forEach((line, index) => {
        if (index === activeIndex) {
          line.classList.remove('text-slate-400', 'text-sm');
          line.classList.add('text-white', 'font-bold', 'text-lg', 'scale-110');
          // Scroll into view
          line.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else if (index < activeIndex) {
          line.classList.remove('text-white', 'font-bold', 'text-lg', 'scale-110');
          line.classList.add('text-slate-600', 'text-sm');
        } else {
          line.classList.remove('text-white', 'font-bold', 'text-lg', 'scale-110', 'text-slate-600');
          line.classList.add('text-slate-400', 'text-sm');
        }
      });
    }, 100); // Update every 100ms
  }
  
  function stopLyricsSync() {
    if (lyricsUpdateInterval) {
      clearInterval(lyricsUpdateInterval);
      lyricsUpdateInterval = null;
    }
  }

  function fitCanvasToScreen() {
    if (!canvas) return;
    const w = Math.max(window.innerWidth, document.documentElement.clientWidth || 0);
    const h = Math.max(window.innerHeight, document.documentElement.clientHeight || 0);
    canvas.width = Math.floor(w * devicePixelRatio);
    canvas.height = Math.floor(h * devicePixelRatio);
    canvas.style.width = w + 'px';
    canvas.style.height = h + 'px';
  }

  function drawSpectrum() {
    if (!analyser || !canvas) return;
    const ctx = canvas.getContext('2d');
    fitCanvasToScreen();
    const w = canvas.width; // physical
    const h = canvas.height;
    const wCss = Math.floor(w / devicePixelRatio);
    const hCss = Math.floor(h / devicePixelRatio);

    ctx.setTransform(devicePixelRatio, 0, 0, devicePixelRatio, 0, 0);
    ctx.fillStyle = 'rgba(6,10,20,0.36)';
    ctx.fillRect(0, 0, wCss, hCss);

    const freq = new Uint8Array(analyser.frequencyBinCount);
    analyser.getByteFrequencyData(freq);

    const barWidth = Math.max(1, Math.floor(wCss / freq.length));
    const grad = ctx.createLinearGradient(0, 0, wCss, 0);
    grad.addColorStop(0, '#60a5fa'); grad.addColorStop(0.5, '#3b82f6'); grad.addColorStop(1, '#7c3aed');

    for (let i = 0; i < freq.length; i++) {
      const value = freq[i];
      const percent = value / 255;
      const x = i * barWidth;
      const barH = Math.floor(percent * hCss);
      ctx.fillStyle = 'rgba(59,130,246,0.08)';
      ctx.fillRect(x - 1, hCss - barH - 6, barWidth + 2, barH + 6);
      ctx.fillStyle = grad;
      ctx.fillRect(x, hCss - barH, barWidth, barH);
    }

    rafId = requestAnimationFrame(drawSpectrum);
  }

  async function attachAudioElementToContext() {
    if (!audioEl) return;
    if (audioElementAttached && sourceNode && analyser) {
      console.log('[bpm-player] audio already attached, skipping');
      return; // Already attached, don't recreate
    }
    
    if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    
    try {
      // Clean up old connections if they exist
      if (sourceNode) {
        try { sourceNode.disconnect(); } catch (e) {}
      }
      if (analyser) {
        try { analyser.disconnect(); } catch (e) {}
      }
      
      try {
        sourceNode = audioCtx.createMediaElementSource(audioEl);
        analyser = audioCtx.createAnalyser(); 
        analyser.fftSize = 2048;
        sourceNode.connect(analyser); 
        analyser.connect(audioCtx.destination);
        audioElementAttached = true;
        console.log('[bpm-player] attached MediaElementSource');
      } catch (err) {
        console.warn('[bpm-player] createMediaElementSource failed, trying captureStream', err);
        const stream = audioEl.captureStream ? audioEl.captureStream() : (audioEl.mozCaptureStream ? audioEl.mozCaptureStream() : null);
        if (stream) {
          const ms = audioCtx.createMediaStreamSource(stream);
          analyser = audioCtx.createAnalyser(); 
          analyser.fftSize = 2048;
          ms.connect(analyser); 
          analyser.connect(audioCtx.destination);
          sourceNode = ms;
          audioElementAttached = true;
          console.log('[bpm-player] attached MediaStreamSource via captureStream');
        } else {
          console.warn('[bpm-player] no captureStream available; analyser not attached');
        }
      }
      if (!rafId && analyser) drawSpectrum();
    } catch (e) {
      console.error('[bpm-player] attach error', e);
    }
  }

  function setupAudioElementListeners() {
    if (!audioEl) return;
    audioEl.controls = true;
    audioEl.preload = 'auto';
    audioEl.addEventListener('error', (e) => console.error('[bpm-player] audio error', e));
    audioEl.addEventListener('loadedmetadata', () => console.log('[bpm-player] loadedmetadata duration=', audioEl.duration));
  }

  async function handleFile(file) {
    if (!file) return;
    if (bpmDisplay) bpmDisplay.textContent = '— BPM';
    if (trackTitle) trackTitle.textContent = file.name;
    
    // Reset play button state
    if (playToggle) playToggle.textContent = 'Play';
    
    // Pause current audio if playing
    if (audioEl && !audioEl.paused) {
      audioEl.pause();
    }
    
    // Stop drawing spectrum temporarily
    if (rafId) {
      cancelAnimationFrame(rafId);
      rafId = null;
    }
    
    // Disconnect and clean up audio nodes
    if (sourceNode) {
      try { 
        sourceNode.disconnect(); 
      } catch (e) {
        console.warn('[bpm-player] disconnect source failed', e);
      }
      sourceNode = null;
    }
    
    if (analyser) {
      try {
        analyser.disconnect();
      } catch (e) {
        console.warn('[bpm-player] disconnect analyser failed', e);
      }
      analyser = null;
    }
    
    // Close and recreate audio context for new song
    if (audioCtx) {
      try {
        await audioCtx.close();
      } catch (e) {
        console.warn('[bpm-player] close context failed', e);
      }
      audioCtx = null;
    }
    
    // Reset attachment flag
    audioElementAttached = false;
    
    // CRITICAL FIX: Replace the audio element completely to allow new MediaElementSource
    if (audioEl) {
      // Revoke old object URL to prevent memory leaks
      if (audioEl.src && audioEl.src.startsWith('blob:')) {
        URL.revokeObjectURL(audioEl.src);
      }
      
      // Remove the old audio element
      const oldAudio = audioEl;
      const parent = oldAudio.parentElement;
      
      // Create a fresh audio element
      audioEl = document.createElement('audio');
      audioEl.id = 'audio';
      audioEl.className = 'hidden';
      audioEl.preload = 'auto';
      
      // Replace in DOM
      parent.replaceChild(audioEl, oldAudio);
      
      // Set up the new audio
      audioEl.src = URL.createObjectURL(file);
      audioEl.muted = false;
      audioEl.volume = 1;
      
      // Setup listeners on the new element
      setupAudioElementListeners();
    }
    
    // hide cover image only if there is no logo/cover already set; persistent logo stays visible
    try {
      if (coverImage && (!coverImage.src || String(coverImage.src).trim() === '')) {
        coverImage.classList.add('hidden');
      }
    } catch (err) {
      // defensive: if any error, do not hide the cover to avoid disappearing logo
      console.warn('[bpm-player] cover visibility check failed', err);
    }

    // Attempt to estimate BPM from the uploaded file (client-side)
    if (statusNote) statusNote.textContent = 'Estimating BPM from uploaded file...';
    if (coverSpinner) coverSpinner.classList.remove('hidden');
    let estimatedBpm = null;
    try {
      const bpm = await estimateBPMFromFile(file);
      if (bpm && bpm > 0) {
        estimatedBpm = Math.round(bpm);
        if (bpmDisplay) bpmDisplay.textContent = estimatedBpm + ' BPM';
        if (statusNote) statusNote.textContent = 'Estimated BPM from uploaded file.';
      } else {
        if (statusNote) statusNote.textContent = 'Could not estimate BPM from uploaded file.';
      }
    } catch (e) {
      console.warn('[bpm-player] bpm estimate from file failed', e);
      if (statusNote) statusNote.textContent = 'BPM estimation failed: ' + (e && e.message ? e.message : 'unknown');
    } finally {
      if (coverSpinner) coverSpinner.classList.add('hidden');
    }

    // Extract metadata from audio file
    await extractMetadata(file);
    
    // Add to session history
    if (estimatedBpm && currentMetadata) {
      addToHistory({
        title: currentMetadata.title,
        artist: currentMetadata.artist,
        album: currentMetadata.album,
        bpm: estimatedBpm,
        albumArt: coverImage && coverImage.src && !coverImage.src.includes('bpm-logo') ? coverImage.src : null,
        filename: file.name
      });
    }

    // (no per-track cover persistence anymore)
  }

  // Extract metadata (artist, title, album art) from audio file
  async function extractMetadata(file) {
    return new Promise((resolve) => {
      window.jsmediatags.read(file, {
        onSuccess: (tag) => {
          console.log('[bpm-player] metadata extracted', tag);
          const { title, artist, album, picture } = tag.tags;
          
          currentMetadata = {
            title: title || file.name.replace(/\.[^/.]+$/, ''),
            artist: artist || 'Unknown Artist',
            album: album || 'Unknown Album',
          };

          // Update UI with metadata
          if (trackTitle && (title || artist)) {
            trackTitle.textContent = `${currentMetadata.artist} - ${currentMetadata.title}`;
          }

          // Show metadata buttons if we have artist and title
          if (currentMetadata.artist !== 'Unknown Artist' && metadataButtons) {
            metadataButtons.classList.remove('hidden');
          }

          // Extract and display embedded album art
          if (picture && coverImage) {
            const { data, type } = picture;
            let base64String = '';
            for (let i = 0; i < data.length; i++) {
              base64String += String.fromCharCode(data[i]);
            }
            const dataUrl = `data:${type};base64,${window.btoa(base64String)}`;
            coverImage.src = dataUrl;
            coverImage.classList.remove('hidden');
          }

          resolve(currentMetadata);
        },
        onError: (error) => {
          console.warn('[bpm-player] metadata extraction failed', error);
          currentMetadata = {
            title: file.name.replace(/\.[^/.]+$/, ''),
            artist: 'Unknown Artist',
            album: 'Unknown Album',
          };
          resolve(currentMetadata);
        }
      });
    });
  }

  // Fetch track info from Last.fm
  async function fetchTrackInfo(artist, track) {
    try {
      const response = await fetch(`/api/lastfm/track-info?artist=${encodeURIComponent(artist)}&track=${encodeURIComponent(track)}`);
      if (!response.ok) throw new Error('Failed to fetch track info');
      return await response.json();
    } catch (error) {
      console.error('[bpm-player] Last.fm track info error', error);
      throw error;
    }
  }

  // Fetch similar tracks from Last.fm
  async function fetchSimilarTracks(artist, track) {
    try {
      const response = await fetch(`/api/lastfm/similar-tracks?artist=${encodeURIComponent(artist)}&track=${encodeURIComponent(track)}`);
      if (!response.ok) throw new Error('Failed to fetch similar tracks');
      return await response.json();
    } catch (error) {
      console.error('[bpm-player] Last.fm similar tracks error', error);
      throw error;
    }
  }

  // Display track statistics in left panel
  async function displayTrackStats() {
    if (!currentMetadata || currentMetadata.artist === 'Unknown Artist') return;
    
    statsPanel.classList.remove('hidden');
    $('#stats-loading').classList.remove('hidden');
    $('#stats-content').classList.add('hidden');
    $('#stats-error').classList.add('hidden');

    try {
      const data = await fetchTrackInfo(currentMetadata.artist, currentMetadata.title);
      
      if (data.track) {
        const track = data.track;
        
        // Update UI
        $('#stats-track-name').textContent = track.name || currentMetadata.title;
        $('#stats-artist-name').textContent = track.artist?.name || currentMetadata.artist;
        $('#stats-listeners').textContent = track.listeners ? Number(track.listeners).toLocaleString() : '—';
        $('#stats-playcount').textContent = track.playcount ? Number(track.playcount).toLocaleString() : '—';
        
        // Album art
        const albumArt = $('#stats-album-art');
        if (track.album?.image && track.album.image.length > 0) {
          const largeImage = track.album.image.find(img => img.size === 'extralarge' || img.size === 'large');
          if (largeImage && largeImage['#text']) {
            albumArt.src = largeImage['#text'];
            albumArt.classList.remove('hidden');
          }
        }
        
        // Tags
        const tagsContainer = $('#stats-tags');
        tagsContainer.innerHTML = '';
        if (track.toptags?.tag && Array.isArray(track.toptags.tag)) {
          track.toptags.tag.slice(0, 5).forEach(tag => {
            const span = document.createElement('span');
            span.className = 'px-2 py-1 bg-purple-500/20 text-purple-300 text-xs rounded-full';
            span.textContent = tag.name;
            tagsContainer.appendChild(span);
          });
        }
        
        // Wiki summary
        const wiki = $('#stats-wiki');
        if (track.wiki?.summary) {
          // Remove HTML tags and truncate
          const summary = track.wiki.summary.replace(/<[^>]*>/g, '').split('\n')[0];
          wiki.textContent = summary.length > 300 ? summary.substring(0, 300) + '...' : summary;
        } else {
          wiki.textContent = 'No description available.';
        }
        
        $('#stats-loading').classList.add('hidden');
        $('#stats-content').classList.remove('hidden');
      } else {
        throw new Error('Track not found');
      }
    } catch (error) {
      $('#stats-loading').classList.add('hidden');
      $('#stats-error').classList.remove('hidden');
      $('#stats-error-message').textContent = error.message || 'Track info not found';
    }
  }

  // Display similar tracks in right panel with Spotify/YouTube links
  async function displaySimilarTracks() {
    if (!currentMetadata || currentMetadata.artist === 'Unknown Artist') return;
    
    recsPanel.classList.remove('hidden');
    $('#recs-loading').classList.remove('hidden');
    $('#recs-content').classList.add('hidden');
    $('#recs-error').classList.add('hidden');

    try {
      const data = await fetchSimilarTracks(currentMetadata.artist, currentMetadata.title);
      
      if (data.similartracks?.track && Array.isArray(data.similartracks.track)) {
        const tracks = data.similartracks.track;
        const container = $('#recs-content');
        container.innerHTML = '';
        
        tracks.forEach(track => {
          const trackName = track.name;
          const artistName = track.artist?.name || '';
          
          // Main container
          const div = document.createElement('div');
          div.className = 'bg-slate-800/50 rounded-lg p-3 hover:bg-slate-800 transition-colors';
          
          // Top section with track info
          const topSection = document.createElement('div');
          topSection.className = 'flex items-center gap-3 mb-2';
          
          // Album art
          const img = document.createElement('img');
          const smallImage = track.image?.find(img => img.size === 'medium' || img.size === 'small');
          img.src = smallImage?.['#text'] || '';
          img.alt = trackName;
          img.className = 'w-12 h-12 rounded object-cover';
          img.onerror = () => { img.style.display = 'none'; };
          
          // Track info
          const info = document.createElement('div');
          info.className = 'flex-1 min-w-0';
          
          const name = document.createElement('div');
          name.className = 'text-sm font-medium text-white truncate';
          name.textContent = trackName;
          
          const artist = document.createElement('div');
          artist.className = 'text-xs text-slate-400 truncate';
          artist.textContent = artistName;
          
          info.appendChild(name);
          info.appendChild(artist);
          
          // Match percentage
          const matchDiv = document.createElement('div');
          if (track.match) {
            matchDiv.className = 'text-xs text-purple-400 font-semibold';
            matchDiv.textContent = Math.round(parseFloat(track.match) * 100) + '%';
          }
          
          topSection.appendChild(img);
          topSection.appendChild(info);
          if (track.match) topSection.appendChild(matchDiv);
          
          // Streaming links section
          const linksSection = document.createElement('div');
          linksSection.className = 'flex gap-2 mt-2';
          
          // Spotify link
          const spotifyBtn = document.createElement('a');
          spotifyBtn.href = `https://open.spotify.com/search/${encodeURIComponent(trackName + ' ' + artistName)}`;
          spotifyBtn.target = '_blank';
          spotifyBtn.rel = 'noopener noreferrer';
          spotifyBtn.className = 'flex-1 flex items-center justify-center gap-1 px-2 py-1 bg-green-500/20 hover:bg-green-500/30 text-green-300 text-xs rounded transition-colors';
          spotifyBtn.innerHTML = `
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"/>
            </svg>
            Spotify
          `;
          
          // YouTube link
          const youtubeBtn = document.createElement('a');
          youtubeBtn.href = `https://www.youtube.com/results?search_query=${encodeURIComponent(trackName + ' ' + artistName)}`;
          youtubeBtn.target = '_blank';
          youtubeBtn.rel = 'noopener noreferrer';
          youtubeBtn.className = 'flex-1 flex items-center justify-center gap-1 px-2 py-1 bg-red-500/20 hover:bg-red-500/30 text-red-300 text-xs rounded transition-colors';
          youtubeBtn.innerHTML = `
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
              <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
            </svg>
            YouTube
          `;
          
          linksSection.appendChild(spotifyBtn);
          linksSection.appendChild(youtubeBtn);
          
          div.appendChild(topSection);
          div.appendChild(linksSection);
          container.appendChild(div);
        });
        
        $('#recs-loading').classList.add('hidden');
        $('#recs-content').classList.remove('hidden');
      } else {
        throw new Error('No similar tracks found');
      }
    } catch (error) {
      $('#recs-loading').classList.add('hidden');
      $('#recs-error').classList.remove('hidden');
      $('#recs-error-message').textContent = error.message || 'No recommendations found';
    }
  }

  // Panel controls
  if (showStatsBtn) {
    showStatsBtn.addEventListener('click', displayTrackStats);
  }
  
  if (showRecsBtn) {
    showRecsBtn.addEventListener('click', displaySimilarTracks);
  }
  
  if (showLyricsBtn) {
    showLyricsBtn.addEventListener('click', async () => {
      // Fetch track info for credits before displaying
      let trackInfo = null;
      if (currentMetadata && currentMetadata.artist !== 'Unknown Artist') {
        try {
          trackInfo = await fetchTrackInfo(currentMetadata.artist, currentMetadata.title);
        } catch (e) {
          console.warn('[bpm-player] Could not fetch track info for credits', e);
        }
      }
      displayLyrics(trackInfo);
    });
  }
  
  if (closeStats) {
    closeStats.addEventListener('click', () => statsPanel.classList.add('hidden'));
  }
  
  if (closeRecs) {
    closeRecs.addEventListener('click', () => recsPanel.classList.add('hidden'));
  }
  
  if (closeLyrics) {
    closeLyrics.addEventListener('click', () => {
      lyricsPanel.classList.add('hidden');
      stopLyricsSync();
    });
  }
  
  // LRC file upload
  if (lrcFileUpload) {
    lrcFileUpload.addEventListener('change', (e) => {
      const file = e.target.files[0];
      if (!file) return;
      
      const reader = new FileReader();
      reader.onload = (event) => {
        const lrcText = event.target.result;
        lyricsData = parseLRC(lrcText);
        console.log('[bpm-player] Loaded', lyricsData.length, 'lyrics lines');
        
        // Re-display lyrics if panel is open
        if (!lyricsPanel.classList.contains('hidden')) {
          displaySyncedLyrics();
        }
      };
      reader.readAsText(file);
    });
  }

  // cover upload UI has been removed — persistent logo handled separately

  // drag & drop support for audio files (images are ignored)
  function setupDragAndDrop() {
    const dropArea = document.getElementById('player-card');
    if (!dropArea) return;
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(evt => {
      dropArea.addEventListener(evt, (e) => { e.preventDefault(); e.stopPropagation(); });
    });
    dropArea.addEventListener('drop', async (e) => {
      const files = Array.from(e.dataTransfer.files || []);
      for (const f of files) {
        if (f.type && f.type.startsWith('audio/')) {
          // treat as audio file
          await handleFile(f);
        }
      }
    });
  }
  setupDragAndDrop();

  // cover upload/processing removed — persistent logo is used instead

  // (link/paste UI removed — file upload + drag/drop remain as primary analysis paths)

  if (fileInput) fileInput.addEventListener('change', async (ev) => { const f = ev.target.files && ev.target.files[0]; if (f) await handleFile(f); });

  // paste-link feature removed; status updates use #status-note instead

  if (playToggle) {
    playToggle.addEventListener('click', async () => {
      if (!audioEl || !audioEl.src) return;
      
      if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
      if (audioCtx.state === 'suspended') {
        try { await audioCtx.resume(); } catch (e) { console.warn('[bpm-player] resume failed', e); }
      }

      try {
        if (audioEl.paused) {
          // Start or resume playback
          await audioEl.play();
          playToggle.textContent = 'Pause';
          
          // Attach analyser on first play of each song
          if (!audioElementAttached) {
            await attachAudioElementToContext();
          } else if (!rafId && analyser) {
            // Resume visualization if it was stopped
            drawSpectrum();
          }
        } else {
          // Just pause, keep everything connected
          audioEl.pause();
          playToggle.textContent = 'Play';
        }
      } catch (e) {
        console.error('[bpm-player] play error', e);
      }
    });
  }

  // --- BPM estimation utilities ---
  async function fetchArrayBuffer(url) {
    // Try a ranged fetch (first ~3MB) to avoid downloading entire files and to work around some hosts
    const RANGE_BYTES = 3 * 1024 * 1024; // 3MB
    const headers = { 'Accept': '*/*' };
    try {
      const resp = await fetch(url, { headers: { ...headers, Range: 'bytes=0-' + (RANGE_BYTES - 1) } });
      if (!resp.ok && resp.status !== 206 && resp.status !== 200) throw new Error('Failed to fetch audio: ' + resp.status);
      return await resp.arrayBuffer();
    } catch (err) {
      // rethrow with a clear message for upstream handling
      throw new Error('Network/Fetch error: ' + (err && err.message ? err.message : String(err)));
    }
  }

  async function decodeAudioData(arrayBuffer) {
    if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    return await audioCtx.decodeAudioData(arrayBuffer.slice(0));
  }

  // Lightweight BPM estimator based on autocorrelation of the energy envelope
  async function estimateBPMFromUrl(url) {
    // show lightweight progress
    console.log('[bpm-player] estimating BPM for', url);
    const buffer = await fetchArrayBuffer(url);
    try {
      const audioBuffer = await decodeAudioData(buffer);
      return estimateBPMFromAudioBuffer(audioBuffer);
    } catch (e) {
      // decoding failed, provide extra context
      throw new Error('Audio decode failed: ' + (e && e.message ? e.message : 'unknown'));
    }
  }

  // Estimate BPM from a File object (client-side upload)
  async function estimateBPMFromFile(file) {
    if (!file) throw new Error('No file');
    const RANGE_BYTES = 3 * 1024 * 1024; // 3MB
    try {
      // Try decoding only the first N bytes for faster estimation
      const slice = file.slice(0, RANGE_BYTES);
      let arrayBuffer = await slice.arrayBuffer();
      try {
        const audioBuffer = await decodeAudioData(arrayBuffer);
        return estimateBPMFromAudioBuffer(audioBuffer);
      } catch (e) {
        // partial decode failed (format needs more data); fallback to full file
        const fullArray = await file.arrayBuffer();
        const audioBuffer = await decodeAudioData(fullArray);
        return estimateBPMFromAudioBuffer(audioBuffer);
      }
    } catch (e) {
      throw new Error('File decode failed: ' + (e && e.message ? e.message : 'unknown'));
    }
  }

  function estimateBPMFromAudioBuffer(audioBuffer) {
    // downmix to mono and get samples at a reduced rate for speed
    const sampleRate = audioBuffer.sampleRate;
    const channelData = audioBuffer.numberOfChannels > 1
      ? mergeChannels(audioBuffer)
      : audioBuffer.getChannelData(0).slice(0);

    // downsample to ~11025 for faster processing
    const desiredRate = Math.min(11025, sampleRate);
    const downsampleFactor = Math.max(1, Math.floor(sampleRate / desiredRate));
    const down = downsample(channelData, downsampleFactor);

    // compute energy envelope using windowing
    const frameSize = 1024;
    const hopSize = 512;
    const energy = [];
    for (let i = 0; i < down.length - frameSize; i += hopSize) {
      let sum = 0;
      for (let j = 0; j < frameSize; j++) {
        const v = down[i + j];
        sum += v * v;
      }
      energy.push(sum);
    }

    // normalize energy
    const maxE = Math.max(...energy, 1e-9);
    const norm = energy.map(e => e / maxE);

    // autocorrelate the envelope
    const ac = autocorrelate(norm);

    // find best lag corresponding to tempo between 60 and 200 BPM
    const fps = sampleRate / downsampleFactor / hopSize; // frames per second
    const minBpm = 60, maxBpm = 200;
    let best = { bpm: 0, score: -Infinity };
    for (let bpm = minBpm; bpm <= maxBpm; bpm++) {
      const period = Math.round((60 * fps) / bpm);
      if (period <= 0 || period >= ac.length) continue;
      const score = ac[period];
      if (score > best.score) best = { bpm, score };
    }

    // fallback: derive bpm from highest autocorrelation lag
    if (best.score <= 0) {
      const peakLag = ac.indexOf(Math.max(...ac));
      const derivedBpm = peakLag > 0 ? (60 * fps) / peakLag : 0;
      return Math.round(derivedBpm);
    }

    return Math.round(best.bpm);
  }

  function mergeChannels(audioBuffer) {
    const len = audioBuffer.length;
    const out = new Float32Array(len);
    for (let c = 0; c < audioBuffer.numberOfChannels; c++) {
      const ch = audioBuffer.getChannelData(c);
      for (let i = 0; i < len; i++) out[i] = (out[i] || 0) + (ch[i] / audioBuffer.numberOfChannels);
    }
    return out;
  }

  function downsample(samples, factor) {
    if (factor <= 1) return samples;
    const outLen = Math.floor(samples.length / factor);
    const out = new Float32Array(outLen);
    for (let i = 0; i < outLen; i++) {
      out[i] = samples[i * factor];
    }
    return out;
  }

  function autocorrelate(data) {
    const n = data.length;
    const ac = new Float32Array(n);
    for (let lag = 0; lag < n; lag++) {
      let sum = 0;
      for (let i = 0; i < n - lag; i++) sum += data[i] * data[i + lag];
      ac[lag] = sum;
    }
    return ac;
  }

  window.addEventListener('resize', () => fitCanvasToScreen());
  window.addEventListener('pagehide', () => { if (rafId) cancelAnimationFrame(rafId); if (audioCtx) audioCtx.close(); });
  fitCanvasToScreen();
  
  // Initialize history
  initHistory();
  
  // Try to load a persistent logo (prefer SVG then PNG) and show it when no cover is present
  (function loadPersistentLogo(){
    const tryUrls = ['/images/bpm-logo.svg', '/images/bpm-logo.png'];
    let idx = 0;
    function tryNext() {
      if (idx >= tryUrls.length) return;
      const url = tryUrls[idx++];
      const img = new Image();
      img.onload = () => {
        if (coverImage && coverImage.classList.contains('hidden')) {
          coverImage.src = url;
          coverImage.classList.remove('hidden');
        }
      };
      img.onerror = () => { tryNext(); };
      img.src = url;
    }
    tryNext();
  })();
});
