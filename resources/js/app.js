import Alpine from 'alpinejs';
import L from 'leaflet';

window.Alpine = Alpine;
window.L = L;

/**
 * Interactive Web Audio API Synthesizer, SpeechSynthesis Voice Guide,
 * Scroll Tick Feedback, and Editorial Visual Effects.
 */
const PortalAudio = (() => {
    let AC = null;
    let MG = null;
    let SG = null;
    let mOn = true;
    let mStarted = false;
    let schedTimer = null;
    let nextT = 0;
    let stp = 0;

    try {
        if (localStorage.getItem('np_music') === '0') {
            mOn = false;
        }
    } catch {
        // Ignore storage restrictions
    }

    const MEL = [69, 65, 67, 62, 65, 67, 69, 0, 72, 69, 67, 65, 67, 65, 62, 0];
    const CH = [
        [50, 57, 62],
        [46, 53, 62],
        [53, 57, 65],
        [48, 55, 64],
    ];

    function hz(m) {
        return 440 * Math.pow(2, (m - 69) / 12);
    }

    function ensureContext() {
        if (!AC) {
            const C = window.AudioContext || window.webkitAudioContext;
            if (!C) {
                return null;
            }
            AC = new C();
            MG = AC.createGain();
            MG.gain.value = 0;
            MG.connect(AC.destination);
            SG = AC.createGain();
            SG.gain.value = 0.58;
            SG.connect(AC.destination);
        }
        if (AC.state === 'suspended') {
            AC.resume().catch(() => {});
        }
        return AC;
    }

    function tone(f, t0, d, type, v, dest) {
        if (!AC || !dest) return;
        const o = AC.createOscillator();
        const g = AC.createGain();
        o.type = type || 'sine';
        o.frequency.value = f;
        g.gain.setValueAtTime(0, t0);
        g.gain.linearRampToValueAtTime(v, t0 + 0.05);
        g.gain.exponentialRampToValueAtTime(0.0001, t0 + d);
        o.connect(g);
        g.connect(dest);
        o.start(t0);
        o.stop(t0 + d + 0.05);
    }

    function sched() {
        if (!AC || !mOn) return;
        while (nextT < AC.currentTime + 0.6) {
            const b = stp % 16;
            const n = MEL[b];
            if (n) {
                tone(hz(n), nextT, 1.5, 'triangle', 0.45, MG);
            }
            if (b % 4 === 0) {
                CH[b / 4].forEach((m) => tone(hz(m), nextT, 3.4, 'sine', 0.2, MG));
            }
            nextT += 0.85;
            stp++;
        }
    }

    function setMuButton() {
        const b = document.getElementById('mu');
        if (!b) return;
        b.className = mOn ? (mStarted ? 'on' : '') : 'off';
        b.setAttribute('aria-pressed', mOn ? 'true' : 'false');
    }

    function level(v) {
        if (AC && MG) {
            MG.gain.cancelScheduledValues(AC.currentTime);
            MG.gain.linearRampToValueAtTime(v, AC.currentTime + 0.55);
        }
    }

    function musicStart() {
        if (!mOn || !ensureContext()) return;
        if (!mStarted) {
            mStarted = true;
            nextT = AC.currentTime + 0.2;
            schedTimer = window.setInterval(sched, 200);
        }
        level(0.14);
        setMuButton();
    }

    function duck(on) {
        if (mOn && mStarted) {
            level(on ? 0.04 : 0.14);
        }
    }

    function sfx(k, x = 0) {
        if (!mOn || !AC || AC.state !== 'running') return;
        const t = AC.currentTime;
        if (k === 'tick') {
            tone(480 + (x % 8) * 52, t, 0.11, 'sine', 0.2, SG);
        } else if (k === 'open') {
            tone(hz(74), t, 0.45, 'triangle', 0.28, SG);
            tone(hz(81), t + 0.12, 0.75, 'triangle', 0.28, SG);
        } else if (k === 'ok') {
            [72, 76, 79].forEach((m, i) => tone(hz(m), t + i * 0.09, 0.4, 'triangle', 0.34, SG));
        } else if (k === 'no') {
            tone(150, t, 0.32, 'sawtooth', 0.16, SG);
            tone(115, t + 0.12, 0.42, 'sawtooth', 0.16, SG);
        }
    }

    function toggle() {
        mOn = !mOn;
        try {
            localStorage.setItem('np_music', mOn ? '1' : '0');
        } catch {
            // Ignore
        }
        if (mOn) {
            musicStart();
            sfx('open');
        } else {
            level(0);
            if (window.speechSynthesis) {
                window.speechSynthesis.cancel();
            }
        }
        setMuButton();
    }

    function say(text, { onStart, onEnd, force = false } = {}) {
        const ss = window.speechSynthesis;
        if (!ss || !window.SpeechSynthesisUtterance) {
            onEnd && onEnd();
            return false;
        }
        if (!mOn && !force) {
            onEnd && onEnd();
            return false;
        }

        ss.cancel();
        const u = new SpeechSynthesisUtterance(String(text).replace(/\*/g, ''));
        u.lang = 'id-ID';
        u.rate = 0.95;

        const idVoice = ss.getVoices().find((v) => /^id/i.test(v.lang));
        if (idVoice) {
            u.voice = idVoice;
        }

        let finished = false;
        const done = () => {
            if (finished) return;
            finished = true;
            duck(false);
            onEnd && onEnd();
        };

        u.onstart = () => {
            duck(true);
            onStart && onStart();
        };
        u.onend = done;
        u.onerror = done;
        ss.speak(u);
        return true;
    }

    function stopSpeech() {
        if (window.speechSynthesis) {
            window.speechSynthesis.cancel();
        }
        duck(false);
    }

    function init() {
        const muBtn = document.getElementById('mu');
        if (muBtn) {
            muBtn.addEventListener('click', toggle);
        }
        const firstGesture = () => {
            document.removeEventListener('pointerdown', firstGesture);
            document.removeEventListener('keydown', firstGesture);
            musicStart();
        };
        document.addEventListener('pointerdown', firstGesture);
        document.addEventListener('keydown', firstGesture);
        setMuButton();
    }

    return {
        init,
        musicStart,
        sfx,
        say,
        stopSpeech,
        isOn: () => mOn,
    };
})();

window.PortalAudio = PortalAudio;

function initReveals() {
    const items = document.querySelectorAll('.rv');
    if (!items.length || !('IntersectionObserver' in window)) {
        items.forEach((el) => el.classList.add('on'));
        return;
    }
    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('on');
                    io.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12 }
    );
    items.forEach((el) => io.observe(el));
}

function initHeroStrip() {
    const st = document.getElementById('strip');
    const mk = document.getElementById('mk');
    if (!st) return;

    st.addEventListener(
        'wheel',
        (e) => {
            if (Math.abs(e.deltaY) > Math.abs(e.deltaX)) {
                st.scrollLeft += e.deltaY;
                e.preventDefault();
            }
        },
        { passive: false }
    );

    const its = Array.from(st.querySelectorAll('.it'));
    let lastCenteredIndex = -1;

    function updateMarker() {
        if (!mk || !mk.parentNode) return;
        const maxScroll = st.scrollWidth - st.clientWidth;
        const progress = maxScroll > 0 ? st.scrollLeft / maxScroll : 0;
        mk.style.transform = `translateX(${progress * (mk.parentNode.clientWidth - 22)}px)`;
    }

    function updateStripScales() {
        const center = st.scrollLeft + st.clientWidth / 2;
        let bestIdx = 0;
        let bestDist = Infinity;

        its.forEach((el, idx) => {
            if (el.classList.contains('dim')) {
                el.style.setProperty('--s', '0.95');
                return;
            }
            const dist = Math.abs(el.offsetLeft + el.offsetWidth / 2 - center);
            if (dist < bestDist) {
                bestDist = dist;
                bestIdx = idx;
            }
            const scale = 1 + 0.18 * Math.max(0, 1 - dist / (st.clientWidth * 0.55));
            el.style.setProperty('--s', scale.toFixed(3));
        });

        if (bestIdx !== lastCenteredIndex) {
            if (lastCenteredIndex > -1) {
                PortalAudio.sfx('tick', bestIdx);
            }
            lastCenteredIndex = bestIdx;
        }
    }

    st.addEventListener('scroll', () => {
        updateMarker();
        updateStripScales();
    });

    window.addEventListener('resize', () => {
        updateMarker();
        updateStripScales();
    });

    updateMarker();
    updateStripScales();

    const searchInput = document.getElementById('q');
    const countLabel = document.getElementById('sn');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const val = searchInput.value.toLowerCase().trim();
            let visibleCount = 0;
            let firstMatch = null;
            its.forEach((card) => {
                const hay = card.dataset.s || '';
                const matched = !val || hay.includes(val);
                card.classList.toggle('dim', !matched);
                if (matched) {
                    visibleCount++;
                    if (!firstMatch) firstMatch = card;
                }
            });
            if (countLabel) {
                countLabel.textContent = val ? (visibleCount ? `${visibleCount} tokoh` : 'Tidak ditemukan') : '';
            }
            if (firstMatch && visibleCount === 1) {
                firstMatch.scrollIntoView({ inline: 'center', block: 'nearest', behavior: 'smooth' });
            }
            updateStripScales();
        });

        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                const visible = st.querySelectorAll('.it:not(.dim)');
                if (visible.length === 1) {
                    window.location.href = visible[0].getAttribute('href');
                }
            }
        });
    }
}

function initYearCounter() {
    const ye = document.querySelector('.stage .yr[data-year]');
    if (!ye) return;
    const target = parseInt(ye.dataset.year, 10);
    if (Number.isNaN(target)) return;

    PortalAudio.sfx('open');

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    let t0 = null;
    function step(t) {
        if (t0 === null) t0 = t;
        const p = Math.min(1, (t - t0) / 1100);
        const eased = 1 - Math.pow(1 - p, 3);
        ye.textContent = String(Math.round(target - 70 + 70 * eased));
        if (p < 1) {
            window.requestAnimationFrame(step);
        }
    }
    window.requestAnimationFrame(step);
}

document.addEventListener('DOMContentLoaded', () => {
    PortalAudio.init();
    initReveals();
    initHeroStrip();
    initYearCounter();
});

Alpine.start();
