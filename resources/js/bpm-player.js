// BPM player and waveform background using Web Audio API

document.addEventListener('DOMContentLoaded', () => {
  const loadJsMediaTags = () => {
    if (window.jsmediatags) return Promise.resolve();
    return new Promise((resolve, reject) => {
      const s = document.createElement('script');
      s.src = 'https://unpkg.com/jsmediatags@3.9.5/dist/jsmediatags.min.js';
      s.onload = () => resolve();
      s.onerror = () => reject(new Error('Failed to load jsmediatags'));
      document.head.appendChild(s);
    });
  };

  function $(sel) { return document.querySelector(sel); }

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
    canvas.width = canvas.clientWidth * devicePixelRatio;
    canvas.height = canvas.clientHeight * devicePixelRatio;
  }

  function drawSpectrum() {
    if (!analyser || !canvas) return;
    const ctx = canvas.getContext('2d');
    fitCanvasToScreen();
    const w = canvas.width;
    const h = canvas.height;
    ctx.clearRect(0,0,w,h);

    const freq = new Uint8Array(analyser.frequencyBinCount);
    analyser.getByteFrequencyData(freq);

    const barWidth = Math.max(1, Math.floor(w / freq.length));
    for (let i=0;i<freq.length;i++){
      const value = freq[i];
      const percent = value / 255;
      const hue = Math.round(200 - percent * 200);
      ctx.fillStyle = `hsla(${hue},80%,60%,0.06)`;
      const x = i*barWidth;
      ctx.fillRect(x, h - percent*h, barWidth, percent*h);
    }
    rafId = requestAnimationFrame(drawSpectrum);
  }

  async function attachAudioElementToContext() {
    if (!audioEl) return;
    if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    if (sourceNode) sourceNode.disconnect();
    sourceNode = audioCtx.createMediaElementSource(audioEl);
    analyser = audioCtx.createAnalyser();
    analyser.fftSize = 2048;
    sourceNode.connect(analyser);
    analyser.connect(audioCtx.destination);
    if (!rafId) drawSpectrum();
  }

  function arrayBufferToMonoFloat32(buffer) {
    const ch = buffer.numberOfChannels;
    const len = buffer.length;
    const out = new Float32Array(len);
    if (ch === 1) {
      buffer.copyFromChannel(out, 0);
      return {data: out, rate: buffer.sampleRate};
    }
    const tmp = new Float32Array(len);
    for (let c=0;c<ch;c++){
      buffer.copyFromChannel(tmp, c);
      for (let i=0;i<len;i++) out[i] += tmp[i];
    }
    for (let i=0;i<len;i++) out[i] = out[i]/ch;
    return {data: out, rate: buffer.sampleRate};
  }

  function detectBPMFromBuffer(buffer) {
    const {data, rate} = arrayBufferToMonoFloat32(buffer);
    const targetRate = 200;
    const sampleFactor = Math.max(1, Math.floor(rate / targetRate));
    const length = Math.floor(data.length / sampleFactor);
    const envelope = new Float32Array(length);
    for (let i=0;i<length;i++){
      let sum = 0;
      for (let j=0;j<sampleFactor;j++){
        const v = data[i*sampleFactor + j];
        sum += v*v;
      }
      envelope[i] = Math.sqrt(sum / sampleFactor);
    }

    const onset = new Float32Array(length);
    for (let i=1;i<length;i++) onset[i] = Math.max(0, envelope[i] - envelope[i-1]);

    const minLag = Math.floor((60/200) * targetRate);
    const upper = Math.floor((60/40)*targetRate);
    const ac = new Float32Array(upper + 1);
    for (let lag = minLag; lag <= upper; lag++){
      let sum = 0;
      for (let i=0;i+lag<length;i++) sum += onset[i]*onset[i+lag];
      ac[lag] = sum;
    }

    let bestLag = minLag; let bestVal = -1;
    for (let lag=minLag; lag<=upper; lag++){
      if (ac[lag] > bestVal) { bestVal = ac[lag]; bestLag = lag; }
    }
    const bpm = 60 * (targetRate / bestLag);
    return Math.round(bpm);
  }

  async function analyzeBPM(file) {
    if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    const arrayBuffer = await file.arrayBuffer();
    const decoded = await audioCtx.decodeAudioData(arrayBuffer.slice(0));
    try {
      const bpm = detectBPMFromBuffer(decoded);
      return bpm;
    } catch (e) {
      console.warn('BPM detection failed', e);
      return null;
    }
  }

  function showCoverFromTags(tags) {
    if (!tags || !tags.picture) { if (coverImage) coverImage.classList.add('hidden'); if (noCover) noCover.classList.remove('hidden'); return; }
    const pic = tags.picture;
    const blob = new Blob([new Uint8Array(pic.data)], { type: pic.format });
    const url = URL.createObjectURL(blob);
    if (coverImage) {
      coverImage.src = url;
      coverImage.classList.remove('hidden');
    }
    if (noCover) noCover.classList.add('hidden');
  }

  if (fileInput) {
    fileInput.addEventListener('change', async (e) => {
      const f = e.target.files && e.target.files[0];
      if (!f) return;
      if (trackTitle) trackTitle.textContent = f.name;
      if (audioEl) {
        audioEl.src = URL.createObjectURL(f);
        audioEl.classList.remove('hidden');
      }
      if (bpmDisplay) bpmDisplay.textContent = 'Detecting...';

      try {
        await loadJsMediaTags();
        window.jsmediatags.read(f, {
          onSuccess: function(tag) { showCoverFromTags(tag.tags); },
          onError: function() { showCoverFromTags(null); }
        });
      } catch (err) { showCoverFromTags(null); }

      try {
        const bpm = await analyzeBPM(f);
        if (bpmDisplay) bpmDisplay.textContent = bpm ? `${bpm} BPM` : 'Unknown BPM';
      } catch (err) {
        if (bpmDisplay) bpmDisplay.textContent = 'Error';
        console.error(err);
      }

      await attachAudioElementToContext();
    });
  }

  if (playToggle) {
    playToggle.addEventListener('click', async () => {
      if (!audioEl) return;
      if (audioEl.paused) {
        if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        if (audioCtx.state === 'suspended') await audioCtx.resume();
        await audioEl.play();
        playToggle.textContent = 'Pause';
      } else {
        audioEl.pause();
        playToggle.textContent = 'Play';
      }
    });
  }

  window.addEventListener('resize', () => { fitCanvasToScreen(); });

  window.addEventListener('pagehide', () => {
    if (rafId) cancelAnimationFrame(rafId);
    if (audioCtx) audioCtx.close();
  });

  // initial canvas sizing
  fitCanvasToScreen();
});
