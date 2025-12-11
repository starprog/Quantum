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
  const hideLyrics = $('#hide-lyrics');
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
  let currentAudioAnalysis = null; // Store energy, danceability, time signature
  let playlists = []; // Store user playlists
  let currentBPMFilter = { min: 0, max: 999 }; // Current BPM filter
  

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

  // === PLAYLISTS MANAGEMENT ===
  function initPlaylists() {
    const playlistsToggle = $('#playlists-toggle');
    const playlistsPanel = $('#playlists-panel');
    const closePlaylists = $('#close-playlists');
    const createPlaylistBtn = $('#create-playlist-btn');
    const saveToPlaylistBtn = $('#save-to-playlist-btn');
    
    // Load playlists from localStorage
    const saved = localStorage.getItem('bpm-playlists');
    if (saved) {
      try {
        playlists = JSON.parse(saved);
        updatePlaylistsDisplay();
      } catch (e) {
        console.warn('[bpm-player] failed to load playlists', e);
      }
    }
    
    if (playlistsToggle) {
      playlistsToggle.addEventListener('click', () => {
        playlistsPanel.classList.toggle('hidden');
        // Close other panels
        $('#bpm-filter-panel').classList.add('hidden');
        $('#history-panel').classList.add('hidden');
      });
    }
    
    if (closePlaylists) {
      closePlaylists.addEventListener('click', () => {
        playlistsPanel.classList.add('hidden');
      });
    }
    
    if (createPlaylistBtn) {
      createPlaylistBtn.addEventListener('click', () => {
        showCreatePlaylistModal();
      });
    }
    
    if (saveToPlaylistBtn) {
      saveToPlaylistBtn.addEventListener('click', () => {
        if (sessionHistory.length === 0) {
          showNotification('No tracks in session history to save.', 'error');
          return;
        }
        showTrackSelectionModal();
      });
    }
  }
  
  function createPlaylist(name) {
    const playlist = {
      id: Date.now() + Math.random(),
      name: name,
      tracks: [],
      created: Date.now()
    };
    playlists.push(playlist);
    savePlaylists();
    updatePlaylistsDisplay();
  }
  
  function deletePlaylist(playlistId) {
    if (confirm('Delete this playlist?')) {
      playlists = playlists.filter(p => p.id !== playlistId);
      savePlaylists();
      updatePlaylistsDisplay();
    }
  }
  
  function renamePlaylist(playlistId) {
    const playlist = playlists.find(p => p.id === playlistId);
    if (!playlist) return;
    
    showRenamePlaylistModal(playlistId, playlist.name);
  }
  
  function addTrackToPlaylist(playlistId, track) {
    const playlist = playlists.find(p => p.id === playlistId);
    if (!playlist) return;
    
    // Check if track already exists
    const exists = playlist.tracks.some(t => 
      t.title === track.title && t.artist === track.artist
    );
    
    if (exists) {
      alert('Track already in playlist!');
      return;
    }
    
    playlist.tracks.push(track);
    savePlaylists();
    updatePlaylistsDisplay();
  }
  
  function removeTrackFromPlaylist(playlistId, trackIndex) {
    const playlist = playlists.find(p => p.id === playlistId);
    if (!playlist) return;
    
    playlist.tracks.splice(trackIndex, 1);
    savePlaylists();
    updatePlaylistsDisplay();
  }
  
  function showCreatePlaylistModal() {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 animate-fadeIn';
    modal.innerHTML = `
      <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl border border-white/10 transform transition-all animate-slideUp">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-teal-500 flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-white">Create New Playlist</h3>
        </div>
        <div class="mb-6">
          <label class="block text-sm font-medium text-slate-300 mb-2">Playlist Name</label>
          <input 
            type="text" 
            id="playlist-name-input" 
            placeholder="e.g., Workout Mix, Chill Vibes..."
            class="w-full px-4 py-3 bg-white border border-slate-600 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
            maxlength="50"
          />
          <div class="mt-2 text-xs text-slate-400">
            <span id="char-count">0</span>/50 characters
          </div>
        </div>
        <div class="flex gap-3">
          <button id="cancel-create-playlist" class="flex-1 px-4 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-all font-medium">
            Cancel
          </button>
          <button id="confirm-create-playlist" class="flex-1 px-4 py-3 bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-600 hover:to-teal-600 text-white rounded-lg transition-all font-medium shadow-lg shadow-green-500/20">
            Create Playlist
          </button>
        </div>
      </div>
    `;
    
    document.body.appendChild(modal);
    
    const input = modal.querySelector('#playlist-name-input');
    const charCount = modal.querySelector('#char-count');
    const confirmBtn = modal.querySelector('#confirm-create-playlist');
    const cancelBtn = modal.querySelector('#cancel-create-playlist');
    
    // Auto-focus input
    setTimeout(() => input.focus(), 100);
    
    // Character counter
    input.addEventListener('input', () => {
      charCount.textContent = input.value.length;
    });
    
    // Enter key to confirm
    input.addEventListener('keypress', (e) => {
      if (e.key === 'Enter' && input.value.trim()) {
        createPlaylist(input.value.trim());
        document.body.removeChild(modal);
      }
    });
    
    // Confirm button
    confirmBtn.addEventListener('click', () => {
      if (input.value.trim()) {
        createPlaylist(input.value.trim());
        document.body.removeChild(modal);
      } else {
        input.classList.add('ring-2', 'ring-red-500');
        setTimeout(() => input.classList.remove('ring-2', 'ring-red-500'), 500);
      }
    });
    
    // Cancel button
    cancelBtn.addEventListener('click', () => {
      document.body.removeChild(modal);
    });
    
    // Click outside to close
    modal.addEventListener('click', (e) => {
      if (e.target === modal) document.body.removeChild(modal);
    });
    
    // Escape key to close
    const escapeHandler = (e) => {
      if (e.key === 'Escape') {
        document.body.removeChild(modal);
        document.removeEventListener('keydown', escapeHandler);
      }
    };
    document.addEventListener('keydown', escapeHandler);
  }
  
  function showRenamePlaylistModal(playlistId, currentName) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 animate-fadeIn';
    modal.innerHTML = `
      <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl border border-white/10 transform transition-all animate-slideUp">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-white">Rename Playlist</h3>
        </div>
        <div class="mb-6">
          <label class="block text-sm font-medium text-slate-300 mb-2">Playlist Name</label>
          <input 
            type="text" 
            id="playlist-rename-input" 
            value="${currentName}"
            class="w-full px-4 py-3 bg-white border border-slate-600 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
            maxlength="50"
          />
          <div class="mt-2 text-xs text-slate-400">
            <span id="char-count-rename">${currentName.length}</span>/50 characters
          </div>
        </div>
        <div class="flex gap-3">
          <button id="cancel-rename-playlist" class="flex-1 px-4 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-all font-medium">
            Cancel
          </button>
          <button id="confirm-rename-playlist" class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white rounded-lg transition-all font-medium shadow-lg shadow-blue-500/20">
            Rename
          </button>
        </div>
      </div>
    `;
    
    document.body.appendChild(modal);
    
    const input = modal.querySelector('#playlist-rename-input');
    const charCount = modal.querySelector('#char-count-rename');
    const confirmBtn = modal.querySelector('#confirm-rename-playlist');
    const cancelBtn = modal.querySelector('#cancel-rename-playlist');
    
    // Auto-focus and select text
    setTimeout(() => {
      input.focus();
      input.select();
    }, 100);
    
    // Character counter
    input.addEventListener('input', () => {
      charCount.textContent = input.value.length;
    });
    
    // Enter key to confirm
    input.addEventListener('keypress', (e) => {
      if (e.key === 'Enter' && input.value.trim()) {
        const playlist = playlists.find(p => p.id === playlistId);
        if (playlist) {
          playlist.name = input.value.trim();
          savePlaylists();
          updatePlaylistsDisplay();
        }
        document.body.removeChild(modal);
      }
    });
    
    // Confirm button
    confirmBtn.addEventListener('click', () => {
      if (input.value.trim()) {
        const playlist = playlists.find(p => p.id === playlistId);
        if (playlist) {
          playlist.name = input.value.trim();
          savePlaylists();
          updatePlaylistsDisplay();
        }
        document.body.removeChild(modal);
      } else {
        input.classList.add('ring-2', 'ring-red-500');
        setTimeout(() => input.classList.remove('ring-2', 'ring-red-500'), 500);
      }
    });
    
    // Cancel button
    cancelBtn.addEventListener('click', () => {
      document.body.removeChild(modal);
    });
    
    // Click outside to close
    modal.addEventListener('click', (e) => {
      if (e.target === modal) document.body.removeChild(modal);
    });
    
    // Escape key to close
    const escapeHandler = (e) => {
      if (e.key === 'Escape') {
        document.body.removeChild(modal);
        document.removeEventListener('keydown', escapeHandler);
      }
    };
    document.addEventListener('keydown', escapeHandler);
  }
  
  function savePlaylists() {
    localStorage.setItem('bpm-playlists', JSON.stringify(playlists));
  }
  
  function showTrackSelectionModal() {
    const TRACKS_PER_PAGE = 5;
    let currentPage = 0;
    const totalPages = Math.ceil(sessionHistory.length / TRACKS_PER_PAGE);
    
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 animate-fadeIn';
    modal.innerHTML = `
      <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 max-w-2xl w-full mx-4 shadow-2xl border border-white/10 transform transition-all animate-slideUp max-h-[90vh] flex flex-col">
        <div class="flex items-center justify-between mb-6">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
              </svg>
            </div>
            <div>
              <h3 class="text-xl font-bold text-white">Select Tracks</h3>
              <p class="text-xs text-slate-400">Choose tracks to add to playlist</p>
            </div>
          </div>
          <button id="close-track-selection" class="text-slate-400 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        
        <div class="mb-4 flex items-center gap-3">
          <button id="select-all-tracks" class="px-3 py-1.5 text-sm bg-purple-500/20 text-purple-300 hover:bg-purple-500/30 rounded-lg transition-colors">
            Select All on Page
          </button>
          <button id="deselect-all-tracks" class="px-3 py-1.5 text-sm bg-slate-700 text-slate-300 hover:bg-slate-600 rounded-lg transition-colors">
            Deselect All
          </button>
          <div class="ml-auto text-sm text-slate-400">
            <span id="selected-count">0</span> selected
          </div>
        </div>
        
        <div id="track-selection-list" class="space-y-2 mb-4 flex-1">
          <!-- Tracks will be rendered here -->
        </div>
        
        <!-- Pagination Controls -->
        <div class="flex items-center justify-center gap-4 mb-6 pb-4 border-b border-white/10">
          <button id="prev-page" class="p-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-all disabled:opacity-30 disabled:cursor-not-allowed" disabled>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
          </button>
          <div class="text-sm text-slate-300">
            Page <span id="current-page">1</span> of <span id="total-pages">${totalPages}</span>
          </div>
          <button id="next-page" class="p-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-all disabled:opacity-30 disabled:cursor-not-allowed">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </button>
        </div>
        
        <div class="flex gap-3">
          <button id="cancel-track-selection" class="flex-1 px-4 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-all font-medium">
            Cancel
          </button>
          <button id="add-songs-to-playlist" class="flex-1 px-4 py-3 bg-gradient-to-r from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 text-white rounded-lg transition-all font-medium shadow-lg shadow-purple-500/20 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
            Add Songs to Playlist
          </button>
        </div>
      </div>
    `;
    
    document.body.appendChild(modal);
    
    const trackListContainer = modal.querySelector('#track-selection-list');
    const selectedCountEl = modal.querySelector('#selected-count');
    const addSongsBtn = modal.querySelector('#add-songs-to-playlist');
    const selectAllBtn = modal.querySelector('#select-all-tracks');
    const deselectAllBtn = modal.querySelector('#deselect-all-tracks');
    const closeBtn = modal.querySelector('#close-track-selection');
    const cancelBtn = modal.querySelector('#cancel-track-selection');
    const prevPageBtn = modal.querySelector('#prev-page');
    const nextPageBtn = modal.querySelector('#next-page');
    const currentPageEl = modal.querySelector('#current-page');
    
    let selectedIndices = new Set();
    
    function renderPage() {
      const start = currentPage * TRACKS_PER_PAGE;
      const end = Math.min(start + TRACKS_PER_PAGE, sessionHistory.length);
      const pageTracks = sessionHistory.slice(start, end);
      
      trackListContainer.innerHTML = pageTracks.map((track, pageIndex) => {
        const actualIndex = start + pageIndex;
        const isChecked = selectedIndices.has(actualIndex);
        return `
          <label class="flex items-center gap-3 p-3 bg-slate-700/30 hover:bg-slate-700/50 rounded-lg cursor-pointer transition-all group">
            <input type="checkbox" ${isChecked ? 'checked' : ''} class="track-checkbox w-5 h-5 rounded border-2 border-slate-500 bg-slate-800 text-purple-500 focus:ring-2 focus:ring-purple-500 focus:ring-offset-0 transition-all cursor-pointer" data-track-index="${actualIndex}">
            ${track.albumArt ? `<img src="${track.albumArt}" alt="${track.title}" class="w-12 h-12 rounded object-cover">` : '<div class="w-12 h-12 rounded bg-slate-700 flex items-center justify-center"><svg class="w-6 h-6 text-slate-500" fill="currentColor" viewBox="0 0 20 20"><path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"></path></svg></div>'}
            <div class="flex-1 min-w-0">
              <div class="text-sm font-medium text-white truncate group-hover:text-purple-300 transition-colors">${track.title || 'Unknown'}</div>
              <div class="text-xs text-slate-400 truncate">${track.artist || 'Unknown Artist'}</div>
            </div>
            <div class="text-right">
              <div class="text-sm font-bold text-purple-400">${track.bpm || '—'}</div>
              <div class="text-xs text-slate-500">BPM</div>
            </div>
          </label>
        `;
      }).join('');
      
      // Update pagination controls
      currentPageEl.textContent = currentPage + 1;
      prevPageBtn.disabled = currentPage === 0;
      nextPageBtn.disabled = currentPage >= totalPages - 1;
      
      // Attach checkbox listeners
      const checkboxes = trackListContainer.querySelectorAll('.track-checkbox');
      checkboxes.forEach(cb => {
        cb.addEventListener('change', (e) => {
          const index = parseInt(e.target.dataset.trackIndex);
          if (e.target.checked) {
            selectedIndices.add(index);
          } else {
            selectedIndices.delete(index);
          }
          updateSelectedCount();
        });
      });
    }
    
    function updateSelectedCount() {
      selectedCountEl.textContent = selectedIndices.size;
      addSongsBtn.disabled = selectedIndices.size === 0;
    }
    
    selectAllBtn.addEventListener('click', () => {
      const start = currentPage * TRACKS_PER_PAGE;
      const end = Math.min(start + TRACKS_PER_PAGE, sessionHistory.length);
      for (let i = start; i < end; i++) {
        selectedIndices.add(i);
      }
      renderPage();
      updateSelectedCount();
    });
    
    deselectAllBtn.addEventListener('click', () => {
      selectedIndices.clear();
      renderPage();
      updateSelectedCount();
    });
    
    prevPageBtn.addEventListener('click', () => {
      if (currentPage > 0) {
        currentPage--;
        renderPage();
      }
    });
    
    nextPageBtn.addEventListener('click', () => {
      if (currentPage < totalPages - 1) {
        currentPage++;
        renderPage();
      }
    });
    
    addSongsBtn.addEventListener('click', () => {
      const selectedTracks = Array.from(selectedIndices)
        .map(index => sessionHistory[index]);
      
      document.body.removeChild(modal);
      showPlaylistConfirmationModal(selectedTracks);
    });
    
    closeBtn.addEventListener('click', () => {
      document.body.removeChild(modal);
    });
    
    cancelBtn.addEventListener('click', () => {
      document.body.removeChild(modal);
    });
    
    modal.addEventListener('click', (e) => {
      if (e.target === modal) document.body.removeChild(modal);
    });
    
    const escapeHandler = (e) => {
      if (e.key === 'Escape') {
        document.body.removeChild(modal);
        document.removeEventListener('keydown', escapeHandler);
      }
    };
    document.addEventListener('keydown', escapeHandler);
    
    // Initial render
    renderPage();
    updateSelectedCount();
  }
  
  function showPlaylistConfirmationModal(tracks) {
    if (playlists.length === 0) {
      showNotification('Create a playlist first!', 'error');
      return;
    }
    
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 animate-fadeIn';
    modal.innerHTML = `
      <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl border border-white/10 transform transition-all animate-slideUp">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-teal-500 flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
            </svg>
          </div>
          <div>
            <h3 class="text-xl font-bold text-white">Select Destination Playlist</h3>
            <p class="text-xs text-slate-400">${tracks.length} track${tracks.length !== 1 ? 's' : ''} selected</p>
          </div>
        </div>
        
        <p class="text-sm text-slate-300 mb-4">Click a playlist to add your selected songs:</p>
        
        <div class="space-y-2 max-h-96 overflow-y-auto mb-6">
          ${playlists.map(playlist => `
            <button class="w-full text-left px-4 py-3 bg-slate-700/50 hover:bg-slate-700 hover:ring-2 hover:ring-green-500/50 rounded-lg transition-all text-white playlist-select-btn group" data-playlist-id="${playlist.id}">
              <div class="flex items-center justify-between">
                <div class="flex-1">
                  <div class="font-medium group-hover:text-green-300 transition-colors">${playlist.name}</div>
                  <div class="text-xs text-slate-400">${playlist.tracks.length} tracks</div>
                </div>
                <div class="w-8 h-8 rounded-full bg-green-500/20 group-hover:bg-green-500 flex items-center justify-center transition-all">
                  <svg class="w-5 h-5 text-green-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                  </svg>
                </div>
              </div>
            </button>
          `).join('')}
        </div>
        <button class="w-full px-4 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition-all font-medium" id="cancel-playlist-select">Cancel</button>
      </div>
    `;
    
    document.body.appendChild(modal);
    
    modal.querySelectorAll('.playlist-select-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const playlistId = parseFloat(btn.dataset.playlistId);
        const playlist = playlists.find(p => p.id === playlistId);
        
        if (playlist) {
          let addedCount = 0;
          let skippedCount = 0;
          
          tracks.forEach(track => {
            const exists = playlist.tracks.some(t => 
              t.title === track.title && t.artist === track.artist
            );
            
            if (!exists) {
              playlist.tracks.push(track);
              addedCount++;
            } else {
              skippedCount++;
            }
          });
          
          // Save after all tracks are added
          savePlaylists();
          updatePlaylistsDisplay();
          
          document.body.removeChild(modal);
          
          if (addedCount > 0) {
            showNotification(`Successfully added ${addedCount} track${addedCount !== 1 ? 's' : ''} to "${playlist.name}"!`, 'success');
          } else {
            showNotification(`All tracks already exist in "${playlist.name}"!`, 'error');
          }
        }
      });
    });
    
    modal.querySelector('#cancel-playlist-select').addEventListener('click', () => {
      document.body.removeChild(modal);
    });
    
    modal.addEventListener('click', (e) => {
      if (e.target === modal) document.body.removeChild(modal);
    });
    
    const escapeHandler = (e) => {
      if (e.key === 'Escape') {
        document.body.removeChild(modal);
        document.removeEventListener('keydown', escapeHandler);
      }
    };
    document.addEventListener('keydown', escapeHandler);
  }
  
  function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    notification.className = `fixed top-6 right-6 ${bgColor} text-white px-6 py-3 rounded-lg shadow-2xl z-[60] animate-slideUp`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
      notification.style.opacity = '0';
      notification.style.transform = 'translateY(-20px)';
      notification.style.transition = 'all 0.3s ease-out';
      setTimeout(() => document.body.removeChild(notification), 300);
    }, 3000);
  }
  
  function updatePlaylistsDisplay() {
    const container = $('#playlists-list');
    if (!container) return;
    
    if (playlists.length === 0) {
      container.innerHTML = '<div class="text-center py-8 text-slate-400">No playlists yet. Create one to get started!</div>';
      return;
    }
    
    container.innerHTML = playlists.map(playlist => `
      <div class="bg-slate-800/50 rounded-lg p-4">
        <div class="flex justify-between items-start mb-3">
          <div class="flex-1">
            <h3 class="font-bold text-white mb-1">${playlist.name}</h3>
            <div class="text-xs text-slate-400">${playlist.tracks.length} tracks</div>
          </div>
          <div class="flex gap-2">
            <button class="text-slate-400 hover:text-blue-400 transition-colors" onclick="window.renamePlaylist(${playlist.id})" title="Rename">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
              </svg>
            </button>
            <button class="text-slate-400 hover:text-red-400 transition-colors" onclick="window.deletePlaylist(${playlist.id})" title="Delete">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
              </svg>
            </button>
          </div>
        </div>
        <div class="space-y-2 max-h-60 overflow-y-auto">
          ${playlist.tracks.length === 0 ? '<div class="text-xs text-slate-500 text-center py-2">No tracks yet</div>' : 
            playlist.tracks.map((track, index) => `
              <div class="flex items-center gap-2 bg-slate-700/50 rounded p-2">
                ${track.albumArt ? `<img src="${track.albumArt}" alt="${track.title}" class="w-8 h-8 rounded object-cover">` : '<div class="w-8 h-8 rounded bg-slate-600"></div>'}
                <div class="flex-1 min-w-0">
                  <div class="text-xs font-medium text-white truncate">${track.title || 'Unknown'}</div>
                  <div class="text-xs text-slate-400 truncate">${track.artist || 'Unknown'}</div>
                </div>
                <div class="text-xs font-bold text-purple-400">${track.bpm || '—'}</div>
                <button class="text-slate-400 hover:text-red-400 transition-colors" onclick="window.removeTrackFromPlaylist(${playlist.id}, ${index})" title="Remove">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
                </button>
              </div>
            `).join('')
          }
        </div>
      </div>
    `).join('');
  }

  // === BPM FILTER MANAGEMENT ===
  function initBPMFilter() {
    const bpmFilterToggle = $('#bpm-filter-toggle');
    const bpmFilterPanel = $('#bpm-filter-panel');
    const closeBPMFilter = $('#close-bpm-filter');
    const filterButtons = document.querySelectorAll('.bpm-filter-btn');
    
    if (bpmFilterToggle) {
      bpmFilterToggle.addEventListener('click', () => {
        bpmFilterPanel.classList.toggle('hidden');
        // Close other panels
        $('#playlists-panel').classList.add('hidden');
        $('#history-panel').classList.add('hidden');
      });
    }
    
    if (closeBPMFilter) {
      closeBPMFilter.addEventListener('click', () => {
        bpmFilterPanel.classList.add('hidden');
      });
    }
    
    filterButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        const min = parseInt(btn.dataset.min);
        const max = parseInt(btn.dataset.max);
        currentBPMFilter = { min, max };
        
        // Update active state
        filterButtons.forEach(b => b.classList.remove('ring-2', 'ring-white'));
        btn.classList.add('ring-2', 'ring-white');
        
        // Filter and display
        filterHistoryByBPM(min, max);
      });
    });
  }
  
  function filterHistoryByBPM(min, max) {
    const filtered = sessionHistory.filter(track => {
      const bpm = parseFloat(track.bpm);
      if (isNaN(bpm)) return false;
      return bpm >= min && bpm <= max;
    });
    
    const container = $('#filtered-results');
    if (!container) return;
    
    if (filtered.length === 0) {
      container.innerHTML = '<div class="text-center py-8 text-slate-400 col-span-full">No tracks found in this BPM range.</div>';
      return;
    }
    
    container.innerHTML = filtered.map(track => `
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
  
  // Fetch lyrics from Lyrics.ovh API with timeout
  async function fetchLyrics(artist, title) {
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 5000); // 5 second timeout
    const MAX_LYRICS_RETRIES = 3;
    let lyricsRetryCount = 0;
    
    try {
      const response = await fetch(`https://api.lyrics.ovh/v1/${encodeURIComponent(artist)}/${encodeURIComponent(title)}`, {
        signal: controller.signal
      });
      clearTimeout(timeoutId);
      if (!response.ok) throw new Error('Lyrics not found');
      const data = await response.json();
      return data.lyrics;
    } catch (error) {
      clearTimeout(timeoutId);
      if (error.name === 'AbortError') {
        console.error('[bpm-player] Lyrics fetch timeout');
      } else {
        console.error('[bpm-player] Lyrics fetch error', error);
      }
      throw error;
    }
  }
  
  // Fetch lyrics with automatic retry
  async function fetchLyricsWithRetry(artist, title, retryCount = 0) {
    try {
      const lyrics = await fetchLyrics(artist, title);
      if (lyrics) {
        displayPlainLyrics(lyrics);
        lyricsRetryCount = 0; // Reset on success
      } else {
        throw new Error('No lyrics found');
      }
    } catch (error) {
      lyricsRetryCount = retryCount + 1;
      
      if (lyricsRetryCount < MAX_LYRICS_RETRIES) {
        // Show retry message
        $('#lyrics-loading').classList.add('hidden');
        $('#lyrics-error').classList.remove('hidden');
        const errorMsg = $('#lyrics-error-message');
        if (errorMsg) {
          errorMsg.textContent = `Attempting to reload lyrics... (${lyricsRetryCount}/${MAX_LYRICS_RETRIES})`;
        }
        
        // Retry after 2 seconds
        console.log(`[bpm-player] Retrying lyrics fetch (${lyricsRetryCount}/${MAX_LYRICS_RETRIES})`);
        await new Promise(resolve => setTimeout(resolve, 2000));
        
        // Show loading again
        $('#lyrics-loading').classList.remove('hidden');
        $('#lyrics-error').classList.add('hidden');
        
        await fetchLyricsWithRetry(artist, title, lyricsRetryCount);
      } else {
        // Max retries reached
        $('#lyrics-loading').classList.add('hidden');
        $('#lyrics-error').classList.remove('hidden');
        const errorMsg = $('#lyrics-error-message');
        if (errorMsg) {
          errorMsg.textContent = 'Lyrics not available for this track. Upload an LRC file for synced lyrics.';
        }
        lyricsRetryCount = 0;
      }
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
      lyricsRetryCount = 0; // Reset retry count
    } else if (currentMetadata && currentMetadata.artist !== 'Unknown Artist') {
      // Try to fetch lyrics automatically from API with auto-retry
      await fetchLyricsWithRetry(currentMetadata.artist, currentMetadata.title);
    } else {
      // Show error message prompting to upload LRC
      $('#lyrics-loading').classList.add('hidden');
      $('#lyrics-error').classList.remove('hidden');
      lyricsRetryCount = 0;
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
      const analysis = await estimateBPMFromFile(file);
      const bpm = analysis.bpm || analysis;
      if (bpm && bpm > 0) {
        estimatedBpm = Math.round(bpm);
        if (typeof analysis === 'object' && analysis.energy !== undefined) {
          currentAudioAnalysis = {
            energy: analysis.energy,
            danceability: analysis.danceability,
            timeSignature: analysis.timeSignature
          };
          console.log('[bpm-player] Audio analysis:', currentAudioAnalysis);
        }
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
        
        // Display audio analysis if available
        if (currentAudioAnalysis) {
          $('#time-signature').textContent = currentAudioAnalysis.timeSignature || '4/4';
          $('#energy-value').textContent = currentAudioAnalysis.energy + '%';
          $('#energy-bar').style.width = currentAudioAnalysis.energy + '%';
          $('#danceability-value').textContent = currentAudioAnalysis.danceability + '%';
          $('#danceability-bar').style.width = currentAudioAnalysis.danceability + '%';
        } else {
          $('#time-signature').textContent = '—';
          $('#energy-value').textContent = '—';
          $('#energy-bar').style.width = '0%';
          $('#danceability-value').textContent = '—';
          $('#danceability-bar').style.width = '0%';
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
  
  if (hideLyrics) {
    hideLyrics.addEventListener('click', () => {
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
    let detectedBpm;
    if (best.score <= 0) {
      const peakLag = ac.indexOf(Math.max(...ac));
      detectedBpm = peakLag > 0 ? (60 * fps) / peakLag : 0;
    } else {
      detectedBpm = best.bpm;
    }
    
    // Calculate additional audio characteristics
    const audioAnalysis = analyzeAudioCharacteristics(channelData, norm, detectedBpm, sampleRate);
    
    return {
      bpm: Math.round(detectedBpm),
      ...audioAnalysis
    };
  }
  
  function analyzeAudioCharacteristics(samples, energyEnvelope, bpm, sampleRate) {
    // Calculate Energy (0-100): Average RMS of the signal
    let rmsSum = 0;
    for (let i = 0; i < samples.length; i++) {
      rmsSum += samples[i] * samples[i];
    }
    const rms = Math.sqrt(rmsSum / samples.length);
    const energy = Math.min(100, Math.round(rms * 500)); // Scale to 0-100
    
    // Calculate Danceability (0-100): Based on beat regularity and tempo
    const avgEnergy = energyEnvelope.reduce((a, b) => a + b, 0) / energyEnvelope.length;
    let variance = 0;
    for (let i = 0; i < energyEnvelope.length; i++) {
      variance += Math.pow(energyEnvelope[i] - avgEnergy, 2);
    }
    variance /= energyEnvelope.length;
    const consistency = 1 / (1 + variance); // Lower variance = more consistent = more danceable
    
    // Tempo factor: 90-130 BPM is most danceable
    let tempoFactor = 1.0;
    if (bpm >= 90 && bpm <= 130) {
      tempoFactor = 1.0;
    } else if (bpm < 90) {
      tempoFactor = 0.5 + (bpm / 180); // Slower = less danceable
    } else {
      tempoFactor = 0.5 + (1.0 - Math.min(1.0, (bpm - 130) / 100)); // Too fast = less danceable
    }
    
    const danceability = Math.min(100, Math.round(consistency * tempoFactor * 100));
    
    // Detect Time Signature: Analyze beat patterns
    const timeSignature = detectTimeSignature(energyEnvelope, bpm, sampleRate);
    
    return {
      energy,
      danceability,
      timeSignature
    };
  }
  
  function detectTimeSignature(energyEnvelope, bpm, sampleRate) {
    // Improved time signature detection with support for compound meters and triplet feels
    
    if (energyEnvelope.length < 100) return '4/4'; // Not enough data
    
    const avgEnergy = energyEnvelope.reduce((a, b) => a + b, 0) / energyEnvelope.length;
    
    // Use adaptive threshold based on energy distribution
    const sortedEnergy = [...energyEnvelope].sort((a, b) => b - a);
    const top20PercentThreshold = sortedEnergy[Math.floor(sortedEnergy.length * 0.2)];
    const threshold = Math.max(avgEnergy * 1.3, top20PercentThreshold);
    
    // Find peaks (strong beats) with minimum distance to avoid duplicates
    const peaks = [];
    const minPeakDistance = Math.floor(energyEnvelope.length / (bpm / 60) / 8); // At least 1/8 beat apart
    
    for (let i = 2; i < energyEnvelope.length - 2; i++) {
      if (energyEnvelope[i] > threshold && 
          energyEnvelope[i] >= energyEnvelope[i - 1] && 
          energyEnvelope[i] >= energyEnvelope[i + 1] &&
          energyEnvelope[i] > energyEnvelope[i - 2] &&
          energyEnvelope[i] > energyEnvelope[i + 2]) {
        // Check minimum distance from last peak
        if (peaks.length === 0 || i - peaks[peaks.length - 1] >= minPeakDistance) {
          peaks.push(i);
        }
      }
    }
    
    if (peaks.length < 8) return '4/4'; // Default if insufficient peaks
    
    // Analyze intervals between consecutive peaks
    const intervals = [];
    for (let i = 1; i < peaks.length; i++) {
      intervals.push(peaks[i] - peaks[i - 1]);
    }
    
    // Calculate interval statistics
    intervals.sort((a, b) => a - b);
    const medianInterval = intervals[Math.floor(intervals.length / 2)];
    
    // Look for triplet subdivisions (3:2 ratio pattern)
    let tripletCount = 0;
    let straightCount = 0;
    
    for (let i = 0; i < intervals.length; i++) {
      const ratio = intervals[i] / medianInterval;
      // Check if interval fits triplet pattern (roughly 2/3 or 3/2 of median)
      if (Math.abs(ratio - 0.67) < 0.15 || Math.abs(ratio - 1.5) < 0.2) {
        tripletCount++;
      } else if (Math.abs(ratio - 1.0) < 0.15) {
        straightCount++;
      }
    }
    
    const hasTripletFeel = tripletCount > straightCount * 0.4;
    
    // Count peaks in groups to detect measure boundaries
    const measureLength = medianInterval * 4; // Assume 4 beats per measure initially
    const measures = Math.floor(peaks.length / 4);
    
    if (measures < 2) return '4/4';
    
    // Analyze peak strength patterns to identify downbeats
    const peakStrengths = peaks.map(p => energyEnvelope[p]);
    const avgPeakStrength = peakStrengths.reduce((a, b) => a + b, 0) / peakStrengths.length;
    
    // Find stronger peaks (likely downbeats)
    const strongPeaks = [];
    for (let i = 0; i < peaks.length; i++) {
      if (peakStrengths[i] > avgPeakStrength * 1.1) {
        strongPeaks.push(i);
      }
    }
    
    // Calculate beats between strong peaks (downbeats)
    const beatsPerMeasure = [];
    for (let i = 1; i < strongPeaks.length && i < 10; i++) {
      beatsPerMeasure.push(strongPeaks[i] - strongPeaks[i - 1]);
    }
    
    if (beatsPerMeasure.length > 0) {
      const avgBeatsPerMeasure = Math.round(
        beatsPerMeasure.reduce((a, b) => a + b, 0) / beatsPerMeasure.length
      );
      
      // Determine time signature based on beat grouping and feel
      if (hasTripletFeel) {
        // Compound meters (6/8, 9/8, 12/8)
        if (avgBeatsPerMeasure >= 11 || (avgBeatsPerMeasure >= 4 && bpm < 80)) {
          return '12/8'; // 4 groups of 3 eighth notes
        } else if (avgBeatsPerMeasure >= 8) {
          return '9/8'; // 3 groups of 3 eighth notes
        } else if (avgBeatsPerMeasure >= 5) {
          return '6/8'; // 2 groups of 3 eighth notes
        }
      }
      
      // Simple meters
      if (avgBeatsPerMeasure <= 2) return '2/4';
      if (avgBeatsPerMeasure === 3) return '3/4';
      if (avgBeatsPerMeasure === 5) return '5/4';
      if (avgBeatsPerMeasure === 6 && !hasTripletFeel) return '6/4';
      if (avgBeatsPerMeasure >= 7) return '7/4';
    }
    
    // Final fallback based on BPM and triplet feel
    if (hasTripletFeel && bpm >= 60 && bpm <= 90) {
      return '12/8'; // Slow triplet feel songs like "Hold the Line"
    }
    
    return '4/4'; // Most common default
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
  
  // Initialize playlists
  initPlaylists();
  
  // Initialize BPM filter
  initBPMFilter();
  
  // Expose playlist functions to global scope for onclick handlers
  window.deletePlaylist = deletePlaylist;
  window.renamePlaylist = renamePlaylist;
  window.removeTrackFromPlaylist = removeTrackFromPlaylist;
  
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
