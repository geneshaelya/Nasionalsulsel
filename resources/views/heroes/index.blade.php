@extends('layouts.app')

@section('title', 'Direktori Pahlawan Nasional & Daerah – Sulawesi Selatan')

@section('content')
<div class="max-w-6xl mx-auto px-5 pt-28 pb-16">
    <div class="border-b border-[#d6d3c5] pb-8 mb-8">
        <p class="sans text-[#7b786d]">Katalog Sejarah · Dinas Sosial Provinsi Sulawesi Selatan</p>
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mt-2">
            <div>
                <h1 class="text-4xl sm:text-5xl font-medium italic text-[#33291a]">
                    Direktori Pahlawan Sulawesi Selatan
                </h1>
                <p class="text-lg text-[#5a574c] mt-2 max-w-2xl">
                    Memuat <strong>{{ $nasionalCount }} Pahlawan Nasional</strong> asal Sulawesi Selatan (hingga penetapan Jenderal TNI (Purn.) Andi Muhammad Jusuf Amir tahun 2026), tokoh perjuangan daerah, serta tokoh dalam kajian TP2GD.
                </p>
            </div>
            <a href="{{ route('contributions.create') }}" class="editorial-btn sans shrink-0">
                + Kirim Arsip Keluarga
            </a>
        </div>
    </div>

    {{-- Kuis Umum Keseluruhan Sebelum Daftar Individual Pahlawan --}}
    @if ($overallQuiz)
        <section class="border border-[#33291a]/30 bg-[#fbfaf5] p-6 sm:p-8 mb-10 rv">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="max-w-2xl">
                    <span class="sans text-[#8b3a2b]">Evaluasi Menyeluruh · Sebelum Menelusuri Tiap Tokoh</span>
                    <h2 class="text-3xl italic font-medium text-[#33291a] mt-1">
                        {{ $overallQuiz->judul }}
                    </h2>
                    <p class="text-base text-[#5a574c] mt-2">
                        {{ $overallQuiz->deskripsi }} Tersedia {{ $overallQuiz->questions_count }} soal pilihan ganda beserta sertifikat PDF otomatis bagi peserta yang lulus, selain kuis khusus pada setiap halaman profil pahlawan.
                    </p>
                </div>
                <div class="flex flex-wrap gap-3 shrink-0">
                    <a href="{{ route('quiz.show', $overallQuiz->slug) }}" class="editorial-btn-solid sans">
                        Ikuti Kuis Umum
                    </a>
                    <a href="{{ route('quiz.index') }}" class="editorial-btn sans">
                        Lihat Semua Kuis
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- Filter & Pencarian --}}
    <form method="GET" action="{{ route('heroes.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-10 border-b border-[#d6d3c5] pb-8">
        <div class="sm:col-span-2">
            <label for="dir-q" class="sans text-[#7b786d] block mb-1">Cari Nama atau Gelar</label>
            <input
                id="dir-q"
                type="search"
                name="q"
                value="{{ $search }}"
                placeholder="Mis. Hasanuddin, M. Jusuf, Pong Tiku…"
                class="w-full border border-[#d6d3c5] bg-[#fbfaf5] px-3 py-2 text-base text-[#25231e] focus:border-[#33291a] focus:outline-none"
            >
        </div>

        <div>
            <label for="dir-kat" class="sans text-[#7b786d] block mb-1">Kategori</label>
            <select id="dir-kat" name="kategori" class="w-full border border-[#d6d3c5] bg-[#fbfaf5] px-3 py-2 text-base text-[#25231e] focus:border-[#33291a] focus:outline-none">
                <option value="">Semua Kategori</option>
                <option value="nasional" @selected($activeKategori === 'nasional')>Pahlawan Nasional (14)</option>
                <option value="daerah" @selected($activeKategori === 'daerah')>Pahlawan Daerah Sulsel</option>
                <option value="calon" @selected($activeKategori === 'calon')>Calon TP2GD</option>
            </select>
        </div>

        <div>
            <label for="dir-daerah" class="sans text-[#7b786d] block mb-1">Asal Daerah</label>
            <div class="flex gap-2">
                <select id="dir-daerah" name="daerah" class="w-full border border-[#d6d3c5] bg-[#fbfaf5] px-3 py-2 text-base text-[#25231e] focus:border-[#33291a] focus:outline-none">
                    <option value="">Semua Daerah</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region }}" @selected($activeDaerah === $region)>{{ $region }}</option>
                    @endforeach
                </select>
                <button type="submit" class="editorial-btn-solid sans px-4">Saring</button>
            </div>
        </div>
    </form>

    @if ($heroes->isEmpty())
        <div class="border border-dashed border-[#d6d3c5] p-10 text-center">
            <p class="text-xl italic text-[#5a574c]">Tidak ada data pahlawan yang sesuai dengan pencarian Anda.</p>
            <a href="{{ route('heroes.index') }}" class="editorial-btn sans mt-4">Tampilkan Semua Tokoh</a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
            @foreach ($heroes as $hero)
                <article class="border border-[#d6d3c5] bg-[#fbfaf5] flex flex-col justify-between rv hover:border-[#33291a] transition">
                    <div>
                        <a href="{{ route('heroes.show', $hero->slug) }}" class="block overflow-hidden bg-[#e7e3d4]">
                            <img
                                src="{{ $hero->foto_url }}"
                                alt="Potret {{ $hero->nama }}"
                                class="w-full aspect-[3/4] object-cover object-top transition duration-500 hover:scale-[1.03]"
                                style="filter: sepia(12%) contrast(1.03);"
                                loading="lazy"
                            >
                        </a>
                        <div class="h-1 w-full" style="background: {{ $hero->warna_aksen }};"></div>
                        <div class="p-5">
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="sans text-[#7b786d]">{{ $hero->asal_daerah }} · {{ $hero->tahun_penanda }}</span>
                                <span class="sans px-2 py-0.5 border border-[#d6d3c5] text-[#33291a] text-[0.55rem]">
                                    {{ $hero->kategori === 'nasional' ? 'Nasional' : ($hero->kategori === 'daerah' ? 'Daerah' : 'Calon TP2GD') }}
                                </span>
                            </div>
                            <h2 class="text-2xl font-semibold text-[#25231e] leading-snug">
                                <a href="{{ route('heroes.show', $hero->slug) }}" class="hover:underline">
                                    {{ $hero->nama }}
                                </a>
                            </h2>
                            <p class="text-sm italic text-[#7b786d] mt-1">{{ $hero->gelar_singkat }}</p>
                            <p class="text-base text-[#3b3830] mt-3 line-clamp-3">{{ $hero->ringkasan }}</p>
                        </div>
                    </div>

                    <div class="px-5 pb-5 pt-3 border-t border-[#d6d3c5]/70 flex items-center justify-between gap-2">
                        <a href="{{ route('heroes.show', $hero->slug) }}" class="sans text-[#33291a] hover:underline">
                            Baca Biografi →
                        </a>
                        @if ($hero->quiz)
                            <a href="{{ route('quiz.show', $hero->quiz->slug) }}" class="sans text-[#7b786d] hover:text-[#33291a]">
                                Kuis Tokoh
                            </a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endsection
