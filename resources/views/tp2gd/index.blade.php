@extends('layouts.app')

@section('title', 'Portal TP2GD & Syarat Pengusulan Gelar Pahlawan – Dinsos Sulsel')

@section('content')
<div class="max-w-5xl mx-auto px-5 pt-28 pb-16">
    <div class="border-b border-[#d6d3c5] pb-8 mb-10">
        <p class="sans text-[#7b786d]">Tim Peneliti dan Pengkaji Gelar Daerah (TP2GD) Provinsi Sulawesi Selatan</p>
        <h1 class="text-4xl sm:text-5xl font-medium italic text-[#33291a] mt-2">
            Panduan & Syarat Pengusulan Gelar Pahlawan Nasional
        </h1>
        <p class="text-lg text-[#5a574c] mt-3 max-w-3xl">
            Informasi resmi alur verifikasi, syarat administratif maupun akademik berdasarkan UU No. 20 Tahun 2009 serta dokumen templat yang dapat diunduh langsung untuk pengusulan tokoh daerah dari Sulawesi Selatan.
        </p>
    </div>

    {{-- Tahapan Alur TP2GD --}}
    <section class="mb-14">
        <h2 class="text-3xl italic font-medium text-[#33291a] mb-6">Alur Pengusulan Bertahap (Daerah ke Pusat)</h2>
        <div class="space-y-5">
            @foreach ($guides as $guide)
                <article class="border border-[#d6d3c5] bg-[#fbfaf5] p-6 rv">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                        <span class="sans px-2.5 py-1 bg-[#33291a] text-[#fffdf6]">Tahap {{ $guide->tahap_nomor }}</span>
                        <div class="flex flex-wrap gap-4 sans text-[#7b786d]">
                            @if ($guide->instansi_terkait)
                                <span>{{ $guide->instansi_terkait }}</span>
                            @endif
                            @if ($guide->estimasi_waktu)
                                <span>Estimasi: {{ $guide->estimasi_waktu }}</span>
                            @endif
                        </div>
                    </div>
                    <h3 class="text-2xl font-semibold text-[#25231e] mt-2">{{ $guide->judul }}</h3>
                    <p class="text-base italic text-[#5a574c] mt-1">{{ $guide->ringkasan }}</p>
                    <p class="text-base text-[#25231e] mt-3">{{ $guide->deskripsi }}</p>

                    @if (! empty($guide->persyaratan))
                        <div class="mt-4 pt-4 border-t border-[#d6d3c5]/80">
                            <span class="sans text-[#7b786d] block mb-2">Kelengkapan & Persyaratan:</span>
                            <ul class="list-disc pl-5 space-y-1 text-base text-[#3b3830]">
                                @foreach ($guide->persyaratan as $syarat)
                                    <li>{{ $syarat }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </article>
            @endforeach
        </div>
    </section>

    {{-- Unduhan Dokumen PDF --}}
    <section class="mb-14 rv">
        <div class="border-t border-[#d6d3c5] pt-8 mb-6">
            <p class="sans text-[#7b786d]">Berkas Resmi & Templat Pengusul</p>
            <h2 class="text-3xl italic font-medium text-[#33291a] mt-1">Dokumen PDF yang Dapat Diunduh</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach ($documents as $doc)
                <div class="border border-[#d6d3c5] bg-[#fbfaf5] p-5 flex flex-col justify-between">
                    <div>
                        <span class="sans text-[#8b3a2b]">{{ $doc->kategori }} @if ($doc->ukuran_kb) · {{ $doc->ukuran_kb }} KB PDF @endif</span>
                        <h3 class="text-xl font-semibold text-[#25231e] mt-2">{{ $doc->judul }}</h3>
                        <p class="text-sm text-[#5a574c] mt-2">{{ $doc->deskripsi }}</p>
                    </div>
                    <a href="{{ route('tp2gd.download', $doc) }}" class="editorial-btn-solid sans mt-5 justify-center">
                        Unduh Dokumen PDF ↓
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Tokoh dalam Pengkajian TP2GD --}}
    @if ($calonHeroes->isNotEmpty())
        <section class="border border-[#d6d3c5] bg-[#fbfaf5] p-6 sm:p-8 rv">
            <span class="sans text-[#7b786d]">Status Pengkajian Aktif</span>
            <h2 class="text-2xl italic font-medium text-[#33291a] mt-1">Tokoh dalam Kajian Pengusulan TP2GD</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-4">
                @foreach ($calonHeroes as $calon)
                    <div class="flex items-center gap-4 border border-[#d6d3c5] p-4 bg-[#f1f0ea]/60">
                        <img src="{{ $calon->foto_url }}" alt="{{ $calon->nama }}" class="w-16 h-20 object-cover object-top shrink-0">
                        <div>
                            <h3 class="text-xl font-semibold text-[#25231e]">{{ $calon->nama }}</h3>
                            <p class="text-sm text-[#5a574c]">{{ $calon->gelar_singkat }}</p>
                            <div class="mt-2 flex gap-3">
                                <a href="{{ route('heroes.show', $calon->slug) }}" class="sans text-[#33291a] underline">Lihat Profil</a>
                                <a href="{{ route('contributions.create', ['hero' => $calon->slug]) }}" class="sans text-[#8b3a2b] underline">Kirim Bukti Arsip</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
