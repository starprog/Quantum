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

  if (fileInput) fileInput.addEventListener('change', async (ev) => { const f = ev.target.files && ev.target.files[0]; if (f) await handleFile(f); });

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
