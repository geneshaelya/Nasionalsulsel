@extends('layouts.app')

@section('title', $hero->nama . ' – Portal Pahlawan Nasional Sulawesi Selatan')
@section('accent_color', $hero->warna_aksen ?: '#33291a')

@section('content')
<section class="stage">
    <a class="close-stage" href="{{ route('heroes.index') }}" aria-label="Kembali ke Direktori">×</a>
    <span class="vc l sans">{{ $hero->nama }}</span>

    <img
        class="hero-portrait"
        src="{{ $hero->foto_url }}"
        alt="Potret {{ $hero->nama }}"
    >

    <div class="yr" data-year="{{ $hero->tahun_penanda }}">{{ $hero->tahun_penanda }}</div>
    <span class="vc r sans">{{ $hero->kategori_label }}</span>
    <p class="yl sans">{{ $hero->label_penanda ?: $hero->gelar_singkat }}</p>
</section>

<section
    class="sheet"
    x-data="{
        largeText: false,
        speaking: false,
        guideOpen: false,
        readFullBio() {
            if (this.speaking) {
                window.PortalAudio.stopSpeech();
                this.speaking = false;
                return;
            }
            const text = document.getElementById('tts-source').innerText;
            this.speaking = true;
            window.PortalAudio.say(text, {
                force: true,
                onStart: () => { this.speaking = true; },
                onEnd: () => { this.speaking = false; }
            });
        }
    }"
    :class="{ 'text-xl leading-relaxed': largeText }"
>
    <div class="border-b border-[#d6d3c5] pb-5 mb-6">
        <div class="flex flex-wrap items-center gap-2 mb-2">
            <span class="sans px-2.5 py-1 border border-[var(--c)] text-[var(--c)]">{{ $hero->kategori_label }}</span>
            <span class="sans text-[#7b786d]">Asal: {{ $hero->asal_daerah }}</span>
        </div>
        <h1 class="text-4xl sm:text-5xl font-medium text-[var(--c)] leading-tight m-0">{{ $hero->nama }}</h1>
        <p class="text-lg italic text-[#5a574c] mt-1">{{ $hero->gelar_singkat }}</p>

        {{-- Toolbar Aksesibilitas --}}
        <div class="mt-5 flex flex-wrap items-center gap-3 p-3.5 border border-[#d6d3c5] bg-[#fbfaf5]/85">
            <button
                type="button"
                @click="readFullBio()"
                class="editorial-btn-solid sans"
            >
                <span x-text="speaking ? '■ Hentikan Suara' : '🔊 Dengarkan Biografi (TTS)'"></span>
            </button>
            <button
                type="button"
                @click="largeText = !largeText"
                class="editorial-btn sans"
            >
                <span x-text="largeText ? 'Aa Ukuran Teks Normal' : 'Aa+ Perbesar Teks'"></span>
            </button>
            @if ($hero->quiz)
                <a href="{{ route('quiz.show', $hero->quiz->slug) }}" class="editorial-btn sans">
                    🧠 Kuis {{ $hero->nama }}
                </a>
            @endif
        </div>
    </div>

    <div id="tts-source">
        <h2 class="sec-heading rv">Biodata Tokoh</h2>
        <table class="sheet-table rv">
            <tbody>
                @if ($hero->tanggal_lahir || $hero->tempat_lahir)
                    <tr>
                        <td>Kelahiran</td>
                        <td>{{ collect([$hero->tanggal_lahir, $hero->tempat_lahir])->filter()->join(', ') }}</td>
                    </tr>
                @endif
                @if ($hero->tanggal_wafat || $hero->tempat_wafat)
                    <tr>
                        <td>Wafat</td>
                        <td>{{ collect([$hero->tanggal_wafat, $hero->tempat_wafat])->filter()->join(', ') }}</td>
                    </tr>
                @endif
                <tr>
                    <td>Asal Daerah</td>
                    <td>{{ $hero->asal_daerah }}</td>
                </tr>
                <tr>
                    <td>Kategori</td>
                    <td>{{ $hero->kategori_label }}</td>
                </tr>
                @if ($hero->keppres_nomor)
                    <tr>
                        <td>Penetapan Gelar</td>
                        <td>{{ $hero->keppres_nomor }} @if ($hero->tanggal_penetapan) ({{ $hero->tanggal_penetapan }}) @endif</td>
                    </tr>
                @endif
                @if ($hero->masa_jabatan)
                    <tr>
                        <td>Kedudukan / Jabatan</td>
                        <td>{{ $hero->masa_jabatan }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

        @if ($hero->biografi)
            <h2 class="sec-heading rv">Ringkasan Biografi</h2>
            <p class="rv">{{ $hero->biografi }}</p>
        @endif

        @if (! empty($hero->riwayat_hidup))
            <h2 class="sec-heading rv">Riwayat Hidup</h2>
            @foreach ($hero->riwayat_hidup as $paragraf)
                <p class="rv">{{ $paragraf }}</p>
            @endforeach
        @endif

        @if (! empty($hero->perjuangan_jasa))
            <h2 class="sec-heading rv">Perjuangan dan Jasa</h2>
            <ul class="list-disc pl-5 space-y-2 rv">
                @foreach ($hero->perjuangan_jasa as $poin)
                    <li>{{ $poin }}</li>
                @endforeach
            </ul>
        @endif

        @if ($hero->hubungan_keluarga)
            <h2 class="sec-heading rv">Hubungan & Jejaring Perjuangan</h2>
            <p class="rv">{{ $hero->hubungan_keluarga }}</p>
        @endif
    </div>

    @if (! empty($hero->fun_facts))
        <h2 class="sec-heading rv">Fakta Menarik Sejarah</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 rv">
            @foreach ($hero->fun_facts as $fact)
                <div class="border border-[#d6d3c5] bg-[#fbfaf5] p-4">
                    <span class="sans text-[var(--c)] block mb-1">{{ $fact['judul'] ?? 'Fakta Sejarah' }}</span>
                    <p class="text-base text-[#25231e] m-0">{{ $fact['fakta'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    @endif

    @if ($hero->galleries->isNotEmpty())
        <h2 class="sec-heading rv">Galeri Arsip</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 rv">
            @foreach ($hero->galleries as $item)
                <figure class="border border-[#d6d3c5] bg-[#fbfaf5] p-3 m-0">
                    <img
                        src="{{ $item->gambar_url }}"
                        alt="{{ $item->judul }}"
                        class="w-full aspect-[4/3] object-cover object-top"
                        style="filter: sepia(15%);"
                    >
                    <figcaption class="mt-2">
                        <strong class="block text-base text-[#25231e]">{{ $item->judul }}</strong>
                        @if ($item->keterangan)
                            <span class="block text-sm text-[#5a574c] mt-0.5">{{ $item->keterangan }}</span>
                        @endif
                        <span class="sans text-[#7b786d] block mt-1">
                            {{ collect([$item->tahun, $item->sumber])->filter()->join(' · ') }}
                        </span>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    @endif

    <h2 class="sec-heading rv">Lokasi Makam & Situs Sejarah</h2>
    @if ($hero->historicalSites->isNotEmpty())
        <div class="space-y-4 rv">
            @foreach ($hero->historicalSites as $site)
                <div class="border border-[#d6d3c5] bg-[#fbfaf5] p-5">
                    <span class="sans text-[var(--c)]">{{ $site->jenis_label }} · {{ $site->kabupaten_kota }}</span>
                    <h3 class="text-2xl font-medium text-[#25231e] mt-1">{{ $site->nama }}</h3>
                    <p class="text-sm text-[#5a574c] mt-1">{{ $site->alamat }}</p>
                    @if ($site->jam_kunjungan)
                        <p class="text-sm text-[#5a574c] mt-1"><strong>Jam Kunjungan:</strong> {{ $site->jam_kunjungan }}</p>
                    @endif
                    @if ($site->info_ziarah)
                        <p class="text-base text-[#25231e] mt-2">{{ $site->info_ziarah }}</p>
                    @endif
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ route('map.index', ['site' => $site->slug]) }}" class="editorial-btn-solid sans">
                            Lihat di Peta Portal
                        </a>
                        <a href="{{ $site->google_maps_url }}" target="_blank" rel="noopener" class="editorial-btn sans">
                            Petunjuk Arah Google Maps ↗
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="rv text-[#5a574c]">Titik situs sejarah terkait dapat ditelusuri melalui Peta Persebaran Makam & Situs Sejarah.</p>
        <a href="{{ route('map.index') }}" class="editorial-btn sans rv">Buka Peta Persebaran</a>
    @endif

    @if ($hero->glossaryTerms->isNotEmpty())
        <h2 class="sec-heading rv">Glosarium Bahasa Daerah Terkait</h2>
        <div class="space-y-3 rv">
            @foreach ($hero->glossaryTerms as $term)
                <div class="border border-[#d6d3c5] bg-[#fbfaf5] p-4 flex items-start justify-between gap-4">
                    <div>
                        <span class="sans text-[#7b786d]">Bahasa {{ $term->bahasa }} @if ($term->pelafalan) · /{{ $term->pelafalan }}/ @endif</span>
                        <h3 class="text-xl font-semibold text-[#25231e]">{{ $term->istilah }}</h3>
                        <p class="text-base text-[#3b3830] mt-1 m-0">{{ $term->arti }}</p>
                    </div>
                    <button
                        type="button"
                        class="editorial-btn sans shrink-0 py-2 px-3"
                        onclick="window.PortalAudio.say('{{ e($term->istilah . '. ' . $term->arti) }}', { force: true })"
                    >
                        🔊 Lafal
                    </button>
                </div>
            @endforeach
        </div>
    @endif

    @if ($hero->contributions->isNotEmpty())
        <h2 class="sec-heading rv">Arsip Kontribusi Publik Terverifikasi</h2>
        <div class="space-y-4 rv">
            @foreach ($hero->contributions as $contrib)
                <div class="border border-[#d6d3c5] bg-[#fbfaf5] p-4">
                    <span class="sans text-[#7b786d]">Dikirim oleh {{ $contrib->nama_pengirim }} @if ($contrib->hubungan_tokoh) ({{ $contrib->hubungan_tokoh }}) @endif</span>
                    <h3 class="text-xl font-medium text-[#25231e] mt-1">{{ $contrib->judul }}</h3>
                    <p class="text-base text-[#3b3830] mt-2">{{ $contrib->isi_catatan }}</p>
                </div>
            @endforeach
        </div>
    @endif

    @if (! empty($hero->sumber_referensi))
        <h2 class="sec-heading rv">Sumber Referensi & Dokumen</h2>
        <ul class="list-disc pl-5 space-y-1.5 rv">
            @foreach ($hero->sumber_referensi as $ref)
                <li>
                    <a href="{{ $ref['url'] ?? '#' }}" target="_blank" rel="noopener" class="underline text-[var(--c)]">
                        {{ $ref['judul'] ?? ($ref['url'] ?? 'Referensi Sejarah') }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

    <div class="border-t border-[#d6d3c5] pt-6 mt-10 flex flex-wrap items-center justify-between gap-4 rv">
        <div>
            <span class="sans text-[#7b786d] block">Punya arsip foto atau catatan sejarah keluarga {{ $hero->nama }}?</span>
            <a href="{{ route('contributions.create', ['hero' => $hero->slug]) }}" class="editorial-btn sans mt-2">
                Kirim Kontribusi Arsip
            </a>
        </div>
        @if ($hero->quiz)
            <a href="{{ route('quiz.show', $hero->quiz->slug) }}" class="editorial-btn-solid sans">
                Kerjakan Kuis {{ $hero->nama }} →
            </a>
        @endif
    </div>

    <div class="flex justify-between items-center gap-4 mt-10 pt-5 border-t border-[#d6d3c5] sans text-[var(--c)] rv">
        <div>
            @if ($prevHero)
                <a href="{{ route('heroes.show', $prevHero->slug) }}" class="hover:underline">← {{ $prevHero->nama }}</a>
            @endif
        </div>
        <div class="text-right">
            @if ($nextHero)
                <a href="{{ route('heroes.show', $nextHero->slug) }}" class="hover:underline">{{ $nextHero->nama }} →</a>
            @endif
        </div>
    </div>
</section>

{{-- Floating Pemandu Suara & Kuis Mini Interaktif --}}
<button type="button" id="open-guide-btn" class="gp sans">
    🔊 Pemandu Suara & Mini Kuis
</button>
@endsection

@push('scripts')
@php
    $heroGuideData = [
        'nama' => $hero->nama,
        'gelar' => $hero->gelar_singkat,
        'kategori' => $hero->kategori_label,
        'riwayat' => $hero->riwayat_hidup ?? [],
        'juang' => $hero->perjuangan_jasa ?? [],
        'quizUrl' => $hero->quiz ? route('quiz.show', $hero->quiz->slug) : route('quiz.index'),
        'nextUrl' => $nextHero ? route('heroes.show', $nextHero->slug) : null,
        'quizQuestion' => $hero->quiz && $hero->quiz->questions->isNotEmpty() ? [
            'q' => $hero->quiz->questions->first()->pertanyaan,
            'o' => $hero->quiz->questions->first()->opsi,
            'c' => $hero->quiz->questions->first()->jawaban_benar,
        ] : null,
    ];
@endphp
<script>
document.addEventListener('DOMContentLoaded', () => {
    const openBtn = document.getElementById('open-guide-btn');
    if (!openBtn) return;

    const heroData = @json($heroGuideData);

    let drawer = null;

    function closeDrawer() {
        window.PortalAudio.stopSpeech();
        if (drawer) {
            drawer.remove();
            drawer = null;
        }
    }

    openBtn.addEventListener('click', () => {
        if (drawer) return;
        window.PortalAudio.musicStart();
        window.PortalAudio.sfx('open');

        const steps = [
            { t: `Selamat datang. Mari mengenal ${heroData.nama}. ${heroData.gelar}. Termasuk dalam kelompok ${heroData.kategori}.` }
        ];
        heroData.riwayat.forEach((p) => steps.push({ t: p }));
        heroData.juang.forEach((p, idx) => steps.push({ t: (idx === 0 ? 'Perjuangan dan jasa utamanya: ' : '') + p }));
        if (heroData.quizQuestion) {
            steps.push(heroData.quizQuestion);
        }

        let i = 0;
        let xp = 0;
        let answered = false;

        drawer = document.createElement('div');
        drawer.className = 'gd';
        document.body.appendChild(drawer);

        function escHtml(s) {
            return String(s).replace(/[&<>"]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));
        }

        function render() {
            const s = steps[i];
            const isEnd = i >= steps.length;
            const pct = isEnd ? 100 : Math.round((i / steps.length) * 100);

            let html = `<div class="gs">
                <div class="gt">
                    <button type="button" data-a="x" class="gx" aria-label="Tutup">×</button>
                    <div class="gb"><i style="width:${pct}%"></i></div>
                    <span class="gxp">${xp} XP</span>
                </div>`;

            if (isEnd) {
                html += `<div class="gc">
                    <div class="av">🎉</div>
                    <div class="bub"><b>Selesai!</b> Kamu meraih ${xp} XP dari panduan suara ${escHtml(heroData.nama)}.</div>
                </div>
                <a href="${heroData.quizUrl}" class="go text-center no-underline block mb-2">KERJAKAN KUIS SERTIFIKAT</a>
                ${heroData.nextUrl ? `<a href="${heroData.nextUrl}" class="editorial-btn sans justify-center w-full mb-2">PAHLAWAN BERIKUTNYA →</a>` : ''}
                <button type="button" class="text-center sans text-[#7b786d] mt-2 bg-transparent border-0 cursor-pointer" data-a="x">Tutup Panel</button>`;
                drawer.innerHTML = html + '</div>';
                window.PortalAudio.sfx('ok');
                window.PortalAudio.say(`Selesai! Kamu meraih ${xp} X P.`, { force: true });
            } else if (s.q) {
                answered = false;
                html += `<div class="gc">
                    <div class="av" id="av">🧠</div>
                    <div class="bub">${escHtml(s.q)}</div>
                </div>
                <div>${s.o.map((opt, idx) => `<button type="button" class="op" data-a="o" data-j="${idx}">${escHtml(opt)}</button>`).join('')}</div>
                <p class="sans mt-2 mb-2 min-h-[1.3em]" id="fb"></p>
                <button type="button" class="go" data-a="n" id="gn" hidden>LANJUT</button>`;
                drawer.innerHTML = html + '</div>';
                window.PortalAudio.say(s.q, { force: true });
            } else {
                html += `<div class="gc">
                    <div class="av" id="av">🎙️</div>
                    <div class="bub">${escHtml(s.t)}</div>
                </div>
                <button type="button" class="sans text-[var(--c)] bg-transparent border-0 text-left mb-3 cursor-pointer" data-a="r">🔊 ULANGI SUARA</button>
                <button type="button" class="go" data-a="n">LANJUT</button>`;
                drawer.innerHTML = html + '</div>';
                window.PortalAudio.say(s.t, { force: true });
            }
        }

        drawer.addEventListener('click', (e) => {
            if (e.target === drawer) {
                closeDrawer();
                return;
            }
            const btn = e.target.closest('button');
            if (!btn) return;
            const action = btn.dataset.a;
            const currentStep = steps[i];

            if (action === 'x') return closeDrawer();
            if (action === 'r') return window.PortalAudio.say(currentStep.t, { force: true });
            if (action === 'n') {
                i++;
                return render();
            }
            if (action === 'o' && !answered) {
                answered = true;
                const chosen = parseInt(btn.dataset.j, 10);
                const ok = chosen === currentStep.c;
                const btns = drawer.querySelectorAll('.op');
                btns[chosen].classList.add(ok ? 'ok' : 'no');
                if (!ok && btns[currentStep.c]) {
                    btns[currentStep.c].classList.add('ok');
                }
                const fb = drawer.querySelector('#fb');
                if (ok) {
                    xp += 10;
                    drawer.querySelector('.gxp').textContent = `${xp} XP`;
                    fb.style.color = '#3f7d00';
                    fb.textContent = 'Benar! +10 XP';
                    window.PortalAudio.sfx('ok');
                    window.PortalAudio.say('Benar!', { force: true });
                } else {
                    fb.style.color = '#c0392b';
                    fb.textContent = `Belum tepat. Jawaban benar: ${currentStep.o[currentStep.c]}`;
                    window.PortalAudio.sfx('no');
                    window.PortalAudio.say(`Belum tepat. Jawabannya adalah ${currentStep.o[currentStep.c]}`, { force: true });
                }
                drawer.querySelector('#gn').hidden = false;
            }
        });

        render();
    });
});
</script>
@endpush
