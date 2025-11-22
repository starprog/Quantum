// BPM player and spectrum visualizer (restored, DPR-aware)

document.addEventListener('DOMContentLoaded', () => {
  const $ = sel => document.querySelector(sel);
  const fileInput = $('#file-input');
  const coverImage = $('#cover-image');
  const bpmDisplay = $('#bpm-display');
  const trackTitle = $('#track-title');
  const playToggle = $('#play-toggle');
  const audioEl = $('#audio');
  const statusNote = $('#status-note');
  const canvas = $('#spectrum-canvas');
  const coverSpinner = $('#cover-spinner');
  const coverSpinnerText = $('#cover-spinner-text');

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
    // hide cover image until embedded artwork is handled; persistent logo load will run on init
    coverImage.classList.add('hidden');

    if (audioEl) {
      audioEl.src = URL.createObjectURL(file);
      audioEl.classList.remove('hidden');
      audioEl.muted = false; audioEl.volume = 1;
    }

    // Setup listeners now but DO NOT attach analyser until user plays.
    setupAudioElementListeners();

    // Attempt to estimate BPM from the uploaded file (client-side)
    if (statusNote) statusNote.textContent = 'Estimating BPM from uploaded file...';
    if (coverSpinner) coverSpinner.classList.remove('hidden');
    try {
      const bpm = await estimateBPMFromFile(file);
      if (bpm && bpm > 0) {
        if (bpmDisplay) bpmDisplay.textContent = Math.round(bpm) + ' BPM';
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

    // (no per-track cover persistence anymore)
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
