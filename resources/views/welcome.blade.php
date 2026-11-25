@extends('layouts.app')

@section('title', 'Portal Edukasi Pahlawan Nasional Sulawesi Selatan')

@section('content')
<section class="home-stage">
    <div class="px-5 text-center max-w-2xl mx-auto mb-5">
        <p class="sans text-[#7b786d] mb-2">Dinas Sosial Provinsi Sulawesi Selatan</p>
        <h1 class="text-3xl sm:text-5xl font-medium italic text-[#33291a] leading-tight">
            Jejak 14 Pahlawan Nasional & Pejuang Sulawesi Selatan
        </h1>
    </div>

    <div class="sbar">
        <input
            id="q"
            type="search"
            placeholder="Cari nama tokoh atau daerah asal (mis. Gowa, Bone, Luwu, M. Jusuf)…"
            aria-label="Cari nama pahlawan"
            autocomplete="off"
        >
        <span id="sn" class="sans text-[#7b786d]"></span>
    </div>

    <div class="strip" id="strip" aria-label="Galeri Linimasa Pahlawan Sulawesi Selatan">
        @foreach ($heroes as $index => $hero)
            <a
                class="it"
                href="{{ route('heroes.show', $hero->slug) }}"
                data-s="{{ strtolower($hero->nama . ' ' . $hero->gelar_singkat . ' ' . $hero->asal_daerah . ' ' . $hero->kategori) }}"
                style="--k: {{ $hero->ukuran_strip }}; --i: {{ $index }};"
            >
                <img
                    src="{{ $hero->foto_url }}"
                    alt="Potret {{ $hero->nama }}"
                    loading="lazy"
                >
                <span class="it-name sans">{{ $hero->nama }}</span>
                <span class="it-meta">{{ $hero->tahun_penanda }} · {{ $hero->asal_daerah }}</span>
            </a>
        @endforeach
    </div>

    <div class="range" aria-hidden="true">
        <span>{{ $minYear }}</span>
        <i class="rl"><b id="mk"></b></i>
        <span>{{ $maxYear }}</span>
    </div>

    <p class="sans hint">Gulir menyamping untuk mendengar alunan & menjelajah · ketuk potret untuk membuka biografi lengkap</p>

    <div class="max-w-5xl mx-auto w-full px-5 mt-12">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-5 border-t border-[#d6d3c5] pt-8">
            <div class="md:col-span-5 border border-[#d6d3c5] bg-[#fbfaf5] p-6 flex flex-col justify-between">
                <div>
                    <p class="sans text-[#7b786d]">Uji Pemahaman Sebelum Menjelajah</p>
                    <h2 class="text-2xl italic font-medium text-[#33291a] mt-2">
                        Kuis Umum Sejarah Pahlawan Sulawesi Selatan
                    </h2>
                    <p class="text-base text-[#5a574c] mt-2">
                        Kerjakan kuis menyeluruh terlebih dahulu atau pilih kuis khusus pada setiap halaman profil pahlawan untuk meraih sertifikat digital PDF resmi.
                    </p>
                </div>
                <div class="mt-5 flex flex-wrap gap-3">
                    @if ($overallQuiz)
                        <a href="{{ route('quiz.show', $overallQuiz->slug) }}" class="editorial-btn-solid sans">
                            Mulai Kuis Umum
                        </a>
                    @endif
                    <a href="{{ route('quiz.index') }}" class="editorial-btn sans">
                        Semua Paket Kuis
                    </a>
                </div>
            </div>

            <div class="md:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('heroes.index') }}" class="border border-[#d6d3c5] bg-[#fbfaf5] p-5 hover:border-[#33291a] transition block">
                    <span class="sans text-[#7b786d]">01 · Arsip Lengkap</span>
                    <h3 class="text-xl font-semibold text-[#33291a] mt-1">Direktori Pahlawan & Daerah</h3>
                    <p class="text-sm text-[#5a574c] mt-1">Jelajahi 14 Pahlawan Nasional termasuk M. Jusuf (2026), tokoh daerah, dan galeri arsip.</p>
                </a>

                <a href="{{ route('map.index') }}" class="border border-[#d6d3c5] bg-[#fbfaf5] p-5 hover:border-[#33291a] transition block">
                    <span class="sans text-[#7b786d]">02 · Geospasial Ziarah</span>
                    <h3 class="text-xl font-semibold text-[#33291a] mt-1">Peta Makam & Situs Sejarah</h3>
                    <p class="text-sm text-[#5a574c] mt-1">Peta interaktif TMP Panaikang, Katangka, Toraja, Luwu, Takalar hingga Bulukumba.</p>
                </a>

                <a href="{{ route('tp2gd.index') }}" class="border border-[#d6d3c5] bg-[#fbfaf5] p-5 hover:border-[#33291a] transition block">
                    <span class="sans text-[#7b786d]">03 · Layanan Usulan Gelar</span>
                    <h3 class="text-xl font-semibold text-[#33291a] mt-1">Portal Informasi TP2GD</h3>
                    <p class="text-sm text-[#5a574c] mt-1">Alur pengusulan Pahlawan Nasional dari daerah serta unduhan panduan & templat PDF.</p>
                </a>

                <a href="{{ route('contributions.create') }}" class="border border-[#d6d3c5] bg-[#fbfaf5] p-5 hover:border-[#33291a] transition block">
                    <span class="sans text-[#7b786d]">04 · Partisipasi Publik</span>
                    <h3 class="text-xl font-semibold text-[#33291a] mt-1">Kirim Arsip & Glosarium</h3>
                    <p class="text-sm text-[#5a574c] mt-1">Sumbangkan foto atau catatan keluarga untuk verifikasi Dinsos dan pelajari istilah lokal.</p>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
