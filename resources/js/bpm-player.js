// BPM player and spectrum visualizer (clean, DPR-aware, async-safe)

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
  let particles = [];
  let energyEma = 0;

  const BEAT_SENSITIVITY = 1.45;
  const PARTICLES_PER_BEAT = 18;
  const PARTICLE_GRAVITY = 0.06;
  const PARTICLE_COLORS = ['#60a5fa','#3b82f6','#7c3aed','#38bdf8','#93c5fd'];

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

    let instantEnergy = 0;
    for (let i=0;i<freq.length;i++) instantEnergy += freq[i];
    instantEnergy = instantEnergy / freq.length;
    energyEma = energyEma * 0.92 + instantEnergy * 0.08;
    const isBeat = instantEnergy > energyEma * BEAT_SENSITIVITY;
    if (isBeat) {
      const rect = canvas.getBoundingClientRect();
      const spawnX = rect.width / 2;
      const spawnY = rect.height / 2;
      for (let i=0;i<PARTICLES_PER_BEAT;i++) {
        const angle = (Math.random() - 0.5) * Math.PI * 2;
        const speed = 1 + Math.random() * 3;
        particles.push({ x: spawnX, y: spawnY, vx: Math.cos(angle)*speed, vy: Math.sin(angle)*speed*-1, life: 50 + Math.floor(Math.random()*60), age:0, size:2+Math.random()*5, color: PARTICLE_COLORS[Math.floor(Math.random()*PARTICLE_COLORS.length)] });
      }
      const card = document.getElementById('player-card');
      if (card) { card.classList.add('beat-pulse'); setTimeout(()=>card.classList.remove('beat-pulse'),120); }
    }

    const barWidth = Math.max(1, Math.floor(wCss / freq.length));
    const grad = ctx.createLinearGradient(0,0,wCss,0);
    grad.addColorStop(0,'#60a5fa'); grad.addColorStop(0.5,'#3b82f6'); grad.addColorStop(1,'#7c3aed');
    for (let i=0;i<freq.length;i++){
      const value = freq[i]; const percent = value/255; const x = i*barWidth; const barH = Math.floor(percent * hCss);
      ctx.fillStyle = 'rgba(59,130,246,0.08)'; ctx.fillRect(x-1, hCss-barH-6, barWidth+2, barH+6);
      ctx.fillStyle = grad; ctx.fillRect(x, hCss-barH, barWidth, barH);
    }

    for (let i = particles.length - 1; i >= 0; i--) {
      const p = particles[i]; p.vy += PARTICLE_GRAVITY; p.x += p.vx; p.y += p.vy; p.age++; const alpha = Math.max(0, 1 - p.age / p.life);
      ctx.globalAlpha = alpha; ctx.fillStyle = p.color; ctx.beginPath(); ctx.arc(p.x, p.y, p.size, 0, Math.PI*2); ctx.fill(); ctx.globalAlpha = 1;
      if (p.age >= p.life) particles.splice(i,1);
    }

    rafId = requestAnimationFrame(drawSpectrum);
  }

  async function attachAudioElementToContext() {
    if (!audioEl) return;
    if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    try { if (sourceNode) sourceNode.disconnect(); } catch(e){}
    sourceNode = audioCtx.createMediaElementSource(audioEl);
    analyser = audioCtx.createAnalyser(); analyser.fftSize = 2048;
    sourceNode.connect(analyser); analyser.connect(audioCtx.destination);
    if (!rafId) drawSpectrum();
  }

  function arrayBufferToMonoFloat32(buffer) {
    const ch = buffer.numberOfChannels; const len = buffer.length; const out = new Float32Array(len);
    if (ch === 1) { buffer.copyFromChannel(out,0); return {data: out, rate: buffer.sampleRate}; }
    const tmp = new Float32Array(len);
    for (let c=0;c<ch;c++){ buffer.copyFromChannel(tmp,c); for (let i=0;i<len;i++) out[i] += tmp[i]; }
    for (let i=0;i<len;i++) out[i] = out[i]/ch; return {data: out, rate: buffer.sampleRate};
  }

  function detectBPMFromBuffer(audioBuffer) {
    try {
      const {data, rate} = arrayBufferToMonoFloat32(audioBuffer);
      const targetRate = 200; const sampleFactor = Math.max(1, Math.floor(rate/targetRate));
      const length = Math.floor(data.length / sampleFactor);
      const envelope = new Float32Array(length);
      for (let i=0;i<length;i++){ let sum=0; for (let j=0;j<sampleFactor;j++){ const v = data[i*sampleFactor+j]; sum += v*v; } envelope[i] = Math.sqrt(sum/sampleFactor); }
      const onset = new Float32Array(length); for (let i=1;i<length;i++) onset[i] = Math.max(0, envelope[i]-envelope[i-1]);
      const minBpm = 40, maxBpm = 200; const minLag = Math.floor((60/maxBpm)*targetRate); const maxLag = Math.ceil((60/minBpm)*targetRate);
      let bestLag = minLag, bestVal = -Infinity;
      for (let lag=minLag; lag<=maxLag; lag++){ let sum=0; for (let i=0;i+lag<length;i++) sum += onset[i]*onset[i+lag]; if (sum > bestVal){ bestVal = sum; bestLag = lag; } }
      const bpm = Math.round(60 * (targetRate / bestLag)); if (!isFinite(bpm) || bpm <= 0) return null; return bpm;
    } catch (e) { console.warn('BPM detection failed', e); return null; }
  }

  async function loadJsMediaTagsIfNeeded(){ if (window.jsmediatags) return; return new Promise((res,rej)=>{ const s = document.createElement('script'); s.src = 'https://unpkg.com/jsmediatags@3.9.5/dist/jsmediatags.min.js'; s.onload=res; s.onerror=rej; document.head.appendChild(s); }); }

  async function handleFile(file){ if (!file) return; if (bpmDisplay) bpmDisplay.textContent = '— BPM'; if (trackTitle) trackTitle.textContent = file.name; coverImage.classList.add('hidden'); noCover.classList.remove('hidden');
    try { await loadJsMediaTagsIfNeeded(); window.jsmediatags.read(file, { onSuccess: function(tag){ try{ const pic = tag.tags.picture; if (pic && pic.data){ const arr = new Uint8Array(pic.data); const blob = new Blob([arr], {type: pic.format || 'image/jpeg'}); coverImage.src = URL.createObjectURL(blob); coverImage.classList.remove('hidden'); noCover.classList.add('hidden'); } else { coverImage.classList.add('hidden'); noCover.classList.remove('hidden'); } } catch(e){ coverImage.classList.add('hidden'); noCover.classList.remove('hidden'); } }, onError: function(){ coverImage.classList.add('hidden'); noCover.classList.remove('hidden'); } }); } catch(e){ coverImage.classList.add('hidden'); noCover.classList.remove('hidden'); }

    try {
      if (audioEl) { audioEl.src = URL.createObjectURL(file); audioEl.load(); }
      const arrayBuffer = await file.arrayBuffer(); if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)(); const decoded = await audioCtx.decodeAudioData(arrayBuffer.slice(0)); const bpm = detectBPMFromBuffer(decoded); if (bpmDisplay) bpmDisplay.textContent = bpm ? `${bpm} BPM` : 'Unknown BPM';
    } catch (err) { console.error('Error preparing audio:', err); if (bpmDisplay) bpmDisplay.textContent = 'Error'; }

    await attachAudioElementToContext();
  }

  if (fileInput) {
    fileInput.addEventListener('change', async (ev)=>{ const f = ev.target.files && ev.target.files[0]; if (f) await handleFile(f); });
  }

  if (playToggle) {
    playToggle.addEventListener('click', async ()=>{
      if (!audioEl) return; if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)(); if (audioCtx.state === 'suspended') await audioCtx.resume(); if (audioEl.paused) { try { await audioEl.play(); playToggle.textContent = 'Pause'; await attachAudioElementToContext(); } catch(e){ console.error('Playback failed:', e); } } else { audioEl.pause(); playToggle.textContent = 'Play'; }
    });
  }

  window.addEventListener('resize', ()=>fitCanvasToScreen());
  window.addEventListener('pagehide', ()=>{ if (rafId) cancelAnimationFrame(rafId); if (audioCtx) audioCtx.close(); });
  fitCanvasToScreen();
});
