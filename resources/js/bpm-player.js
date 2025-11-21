// BPM player and spectrum visualizer (restored, DPR-aware)

document.addEventListener('DOMContentLoaded', () => {
  const $ = sel => document.querySelector(sel);
  const fileInput = $('#file-input');
  const coverImage = $('#cover-image');
  const noCover = $('#no-cover');
  const bpmDisplay = $('#bpm-display');
  const trackTitle = $('#track-title');
  const playToggle = $('#play-toggle');
  const audioEl = $('#audio');
  const linkInput = $('#link-input');
  const loadLinkBtn = $('#load-link');
  const linkEmbed = $('#link-embed');
  const linkNote = $('#link-note');
  const canvas = $('#spectrum-canvas');

  let audioCtx = null;
  let analyser = null;
  let sourceNode = null;
  let rafId = null;

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
    if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    try {
      if (sourceNode) {
        try { sourceNode.disconnect(); } catch (e) {}
        sourceNode = null;
      }
      try {
        sourceNode = audioCtx.createMediaElementSource(audioEl);
        analyser = audioCtx.createAnalyser(); analyser.fftSize = 2048;
        sourceNode.connect(analyser); analyser.connect(audioCtx.destination);
        console.log('[bpm-player] attached MediaElementSource');
      } catch (err) {
        console.warn('[bpm-player] createMediaElementSource failed, trying captureStream', err);
        const stream = audioEl.captureStream ? audioEl.captureStream() : (audioEl.mozCaptureStream ? audioEl.mozCaptureStream() : null);
        if (stream) {
          const ms = audioCtx.createMediaStreamSource(stream);
          analyser = audioCtx.createAnalyser(); analyser.fftSize = 2048;
          ms.connect(analyser); analyser.connect(audioCtx.destination);
          sourceNode = ms;
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
    coverImage.classList.add('hidden'); noCover.classList.remove('hidden');

    if (audioEl) {
      audioEl.src = URL.createObjectURL(file);
      audioEl.classList.remove('hidden');
      audioEl.muted = false; audioEl.volume = 1;
    }

    // Setup listeners now but DO NOT attach analyser until user plays.
    setupAudioElementListeners();
  }

  // Helpers for link handling
  function isAudioUrl(url) {
    return /\.(mp3|wav|ogg|m4a|flac|aac)(\?|$)/i.test(url);
  }

  function isYouTubeUrl(url) {
    return /(youtube\.com\/watch|youtu\.be\/)/i.test(url);
  }

  function youTubeIdFromUrl(url) {
    try {
      const u = new URL(url);
      if (u.hostname.includes('youtu.be')) return u.pathname.slice(1);
      return u.searchParams.get('v');
    } catch (e) { return null; }
  }

  function isSpotifyTrack(url) {
    return /open\.spotify\.com\/track\//i.test(url) || /spotify:track:/i.test(url);
  }

  function spotifyIdFromUrl(url) {
    try {
      if (/spotify:track:/i.test(url)) return url.split(':').pop();
      const u = new URL(url);
      if (u.pathname) return u.pathname.split('/').pop();
    } catch (e) { return null; }
  }

  async function handleLink(url) {
    if (!url) return;
    linkEmbed.innerHTML = '';
    if (isAudioUrl(url)) {
      // direct audio file — load into audio element and allow analysis
      if (bpmDisplay) bpmDisplay.textContent = '— BPM';
      trackTitle.textContent = url.split('/').pop();
      coverImage.classList.add('hidden'); noCover.classList.remove('hidden');
      audioEl.src = url;
      audioEl.classList.remove('hidden');
      audioEl.muted = false; audioEl.volume = 1;
      setupAudioElementListeners();
      if (linkNote) linkNote.textContent = 'Loaded direct audio URL — analysis will run after you press Play.';

      // Offer an option to load via server proxy to avoid CORS issues and allow analysis
      const proxyBtn = document.createElement('button');
      proxyBtn.textContent = 'Load via proxy';
      proxyBtn.className = 'mt-3 px-3 py-2 rounded bg-emerald-600 text-white';
      proxyBtn.addEventListener('click', () => {
        const proxyUrl = '/proxy/audio?url=' + encodeURIComponent(url);
        trackTitle.textContent = '(proxied) ' + (url.split('/').pop() || url);
        audioEl.src = proxyUrl;
        audioEl.classList.remove('hidden');
        if (linkNote) linkNote.textContent = 'Loaded via server proxy — press Play to begin analysis.';
        setupAudioElementListeners();
      });
      linkEmbed.appendChild(proxyBtn);
      return;
    }

    if (isYouTubeUrl(url)) {
      const id = youTubeIdFromUrl(url);
      if (!id) { if (linkNote) linkNote.textContent = 'Could not parse YouTube ID.'; return; }
      const src = `https://www.youtube.com/embed/${encodeURIComponent(id)}?rel=0&autoplay=1&modestbranding=1`;
      linkEmbed.innerHTML = `<div class="aspect-video w-full rounded overflow-hidden"><iframe id="yt-embed" class="w-full h-64" src="${src}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>`;
      audioEl.pause(); audioEl.src = '';
      if (linkNote) linkNote.textContent = 'YouTube playback is embedded. In-browser BPM analysis usually requires a direct audio file or a server-side proxy — you can try "Attempt analysis" but it may fail due to cross-origin rules.';
      // add attempt button
      const btn = document.createElement('button'); btn.textContent = 'Attempt analysis'; btn.className = 'mt-3 px-3 py-2 rounded bg-yellow-600 text-white';
      btn.addEventListener('click', async () => {
        const iframe = document.getElementById('yt-embed');
        try {
          // try captureStream on iframe (will usually fail for cross-origin)
          const stream = iframe.captureStream ? iframe.captureStream() : null;
          if (stream) {
            if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            const ms = audioCtx.createMediaStreamSource(stream);
            analyser = audioCtx.createAnalyser(); analyser.fftSize = 2048;
            ms.connect(analyser); analyser.connect(audioCtx.destination);
            if (!rafId) drawSpectrum();
            if (linkNote) linkNote.textContent = 'Analysis attached via captureStream.';
          } else {
            if (linkNote) linkNote.textContent = 'Could not capture audio from embed (cross-origin). Analysis unavailable.';
          }
        } catch (e) {
          console.warn('[bpm-player] embed analysis failed', e);
          if (linkNote) linkNote.textContent = 'Attempt failed — cross-origin restrictions prevent analysis.';
        }
      });
      linkEmbed.appendChild(btn);
      return;
    }

    if (isSpotifyTrack(url)) {
      const id = spotifyIdFromUrl(url);
      if (!id) { if (linkNote) linkNote.textContent = 'Could not parse Spotify track ID.'; return; }
      const src = `https://open.spotify.com/embed/track/${encodeURIComponent(id)}`;
      linkEmbed.innerHTML = `<div class="w-full rounded overflow-hidden"><iframe id="sp-embed" class="w-full h-24" src="${src}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>`;
      audioEl.pause(); audioEl.src = '';
      if (linkNote) linkNote.textContent = 'Spotify embed will play, but analysis is usually not available due to cross-origin restrictions.';
      const btn = document.createElement('button'); btn.textContent = 'Attempt analysis'; btn.className = 'mt-3 px-3 py-2 rounded bg-yellow-600 text-white';
      btn.addEventListener('click', async () => {
        const iframe = document.getElementById('sp-embed');
        try {
          const stream = iframe.captureStream ? iframe.captureStream() : null;
          if (stream) {
            if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            const ms = audioCtx.createMediaStreamSource(stream);
            analyser = audioCtx.createAnalyser(); analyser.fftSize = 2048;
            ms.connect(analyser); analyser.connect(audioCtx.destination);
            if (!rafId) drawSpectrum();
            if (linkNote) linkNote.textContent = 'Analysis attached via captureStream.';
          } else {
            if (linkNote) linkNote.textContent = 'Could not capture audio from embed (cross-origin). Analysis unavailable.';
          }
        } catch (e) {
          console.warn('[bpm-player] spotify attempt failed', e);
          if (linkNote) linkNote.textContent = 'Attempt failed — cross-origin restrictions prevent analysis.';
        }
      });
      linkEmbed.appendChild(btn);
      return;
    }

    // fallback: show the link in embed area
    linkEmbed.innerHTML = `<div class="p-3 text-sm text-slate-300">Cannot automatically handle that link. Try a direct audio file URL (mp3/wav) or copy the URL and download it first.</div>`;
    if (linkNote) linkNote.textContent = 'Unsupported link type for automatic analysis.';
  }

  if (fileInput) fileInput.addEventListener('change', async (ev) => { const f = ev.target.files && ev.target.files[0]; if (f) await handleFile(f); });

  // link load events
  if (loadLinkBtn) loadLinkBtn.addEventListener('click', async () => { const url = linkInput && linkInput.value && linkInput.value.trim(); if (url) await handleLink(url); });
  if (linkInput) linkInput.addEventListener('keydown', async (e) => { if (e.key === 'Enter') { e.preventDefault(); const url = linkInput.value && linkInput.value.trim(); if (url) await handleLink(url); } });

  if (playToggle) {
    playToggle.addEventListener('click', async () => {
      if (!audioEl) return;
      if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
      if (audioCtx.state === 'suspended') {
        try { await audioCtx.resume(); } catch (e) { console.warn('[bpm-player] resume failed', e); }
      }

      try {
        if (audioEl.paused) {
          // start playback first (user gesture), then attach analyser so captureStream has tracks
          await audioEl.play();
          playToggle.textContent = 'Pause';
          // now attach analyser (will try MediaElementSource first, fallback to captureStream)
          await attachAudioElementToContext();
        } else {
          audioEl.pause();
          playToggle.textContent = 'Play';
        }
      } catch (e) {
        console.error('[bpm-player] play error', e);
      }
    });
  }

  window.addEventListener('resize', () => fitCanvasToScreen());
  window.addEventListener('pagehide', () => { if (rafId) cancelAnimationFrame(rafId); if (audioCtx) audioCtx.close(); });
  fitCanvasToScreen();
});
