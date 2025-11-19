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
  // Particles for beat effects
  let particles = [];
  let energyEma = 0;
  const BEAT_SENSITIVITY = 1.45; // threshold multiplier for beat detection
  const PARTICLES_PER_BEAT = 30;
  const PARTICLE_GRAVITY = 0.06;
  const PARTICLE_COLORS = ['#60a5fa','#3b82f6','#7c3aed','#38bdf8','#93c5fd'];

  function fitCanvasToScreen() {
    if (!canvas) return;
    // Use full viewport size so the canvas covers entire background
    const w = Math.max(window.innerWidth, document.documentElement.clientWidth || 0);
    const h = Math.max(window.innerHeight, document.documentElement.clientHeight || 0);
    canvas.width = Math.floor(w * devicePixelRatio);
    canvas.height = Math.floor(h * devicePixelRatio);
    // ensure CSS size matches viewport
    canvas.style.width = w + 'px';
    canvas.style.height = h + 'px';
  }

  function drawSpectrum() {
    if (!analyser || !canvas) return;
    const ctx = canvas.getContext('2d');
    fitCanvasToScreen();
    const w = canvas.width;
    const h = canvas.height;

    // subtle dimming to create trailing effect
    ctx.fillStyle = 'rgba(6,10,20,0.36)';
    ctx.fillRect(0, 0, w, h);

    const freq = new Uint8Array(analyser.frequencyBinCount);
    analyser.getByteFrequencyData(freq);

    // Simple real-time beat detection using instant energy vs exponential moving average
    let instantEnergy = 0;
    for (let i = 0; i < freq.length; i++) instantEnergy += freq[i];
    instantEnergy = instantEnergy / freq.length; // normalize
    energyEma = energyEma * 0.92 + instantEnergy * 0.08; // EMA smoothing
    const isBeat = instantEnergy > energyEma * BEAT_SENSITIVITY;
    if (isBeat) {
      // spawn particles across width, biased toward center
      const rect = canvas.getBoundingClientRect();
      const spawnX = rect.width / 2;
      const spawnY = rect.height / 2;
      for (let i = 0; i < PARTICLES_PER_BEAT; i++) {
        const angle = (Math.random() - 0.5) * Math.PI;
        const speed = 1 + Math.random() * 4;
        particles.push({
          x: spawnX * devicePixelRatio,
          y: spawnY * devicePixelRatio,
          vx: Math.cos(angle) * speed * (0.6 + Math.random()),
          vy: Math.sin(angle) * speed * (0.6 + Math.random()) * -1,
          life: 60 + Math.floor(Math.random() * 40),
          age: 0,
          size: 2 + Math.random() * 5,
          color: PARTICLE_COLORS[Math.floor(Math.random() * PARTICLE_COLORS.length)],
        });
      }
      // visual pulse on player card
      const card = document.getElementById('player-card');
      if (card) {
        card.classList.add('beat-pulse');
        setTimeout(() => card.classList.remove('beat-pulse'), 120);
      }
    }

    const barWidth = Math.max(1, Math.floor((w / devicePixelRatio) / freq.length));

    // create a blue gradient for the bars
    const grad = ctx.createLinearGradient(0, 0, w, 0);
    grad.addColorStop(0, '#60a5fa'); // sky-400
    grad.addColorStop(0.5, '#3b82f6'); // blue-500
    grad.addColorStop(1, '#7c3aed'); // purple-600

    for (let i=0;i<freq.length;i++){
      const value = freq[i];
      const percent = value / 255;
      const x = Math.floor(i * barWidth * devicePixelRatio);
      const barH = Math.floor(percent * h);

      // glow layer
      ctx.fillStyle = 'rgba(59,130,246,0.08)';
      ctx.fillRect(x - 1, h - barH - 6, barWidth * devicePixelRatio + 2, barH + 6);

      // main bar with gradient
      ctx.fillStyle = grad;
      ctx.fillRect(x, h - barH, barWidth * devicePixelRatio, barH);
    }

    // update and draw particles on top
    for (let i = particles.length - 1; i >= 0; i--) {
      const p = particles[i];
      p.vy += PARTICLE_GRAVITY;
      p.x += p.vx * devicePixelRatio;
      p.y += p.vy * devicePixelRatio;
      p.age++;
      const alpha = Math.max(0, 1 - p.age / p.life);
      ctx.globalAlpha = alpha;
      ctx.fillStyle = p.color;
      ctx.beginPath();
      ctx.arc(p.x, p.y, p.size * devicePixelRatio, 0, Math.PI * 2);
      ctx.fill();
      ctx.globalAlpha = 1;
      if (p.age >= p.life) particles.splice(i, 1);
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
