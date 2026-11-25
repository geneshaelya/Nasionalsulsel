@extends('layouts.app')

@section('title', 'Tentang Portal – Pahlawan Nasional Sulawesi Selatan')

@section('content')
<div class="max-w-4xl mx-auto px-5 pt-28 pb-16">
    <div class="border-b border-[#d6d3c5] pb-8 mb-8">
        <p class="sans text-[#7b786d]">Informasi Portal & Mitra Penyelenggara</p>
        <h1 class="text-4xl sm:text-5xl font-medium italic text-[#33291a] mt-2">
            Tentang Portal Edukasi Pahlawan Nasional Sulawesi Selatan
        </h1>
    </div>

    <div class="space-y-6 text-lg leading-relaxed text-[#25231e]">
        <p class="rv">
            <strong>Portal Edukasi Pahlawan Nasional Sulawesi Selatan</strong> merupakan platform arsip digital sejarah, pemetaan lokasi ziarah, layanan informasi Tim Peneliti dan Pengkaji Gelar Daerah (TP2GD), serta media pembelajaran interaktif yang dikembangkan bersama <strong>Dinas Sosial Provinsi Sulawesi Selatan</strong>.
        </p>

        <p class="rv">
            Situs ini menghimpun biografi terverifikasi seluruh <strong>{{ $nasionalCount }} Pahlawan Nasional asal Sulawesi Selatan</strong> — termasuk penetapan terbaru Jenderal TNI (Purn.) Andi Muhammad Jusuf Amir (M. Jusuf) berdasarkan Keppres No. 93/TK/Tahun 2026 — bersama tokoh perjuangan daerah dan tokoh yang tengah dikaji melalui mekanisme TP2GD.
        </p>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 my-8 rv">
            <div class="border border-[#d6d3c5] bg-[#fbfaf5] p-4 text-center">
                <div class="text-3xl font-semibold text-[#33291a]">{{ $nasionalCount }}</div>
                <div class="sans text-[#7b786d] mt-1">Pahlawan Nasional</div>
            </div>
            <div class="border border-[#d6d3c5] bg-[#fbfaf5] p-4 text-center">
                <div class="text-3xl font-semibold text-[#33291a]">{{ $totalHeroesCount }}</div>
                <div class="sans text-[#7b786d] mt-1">Total Tokoh Terarsip</div>
            </div>
            <div class="border border-[#d6d3c5] bg-[#fbfaf5] p-4 text-center">
                <div class="text-3xl font-semibold text-[#33291a]">{{ $sitesCount }}</div>
                <div class="sans text-[#7b786d] mt-1">Titik Makam & Situs</div>
            </div>
            <div class="border border-[#d6d3c5] bg-[#fbfaf5] p-4 text-center">
                <div class="text-3xl font-semibold text-[#33291a]">{{ $quizzesCount }}</div>
                <div class="sans text-[#7b786d] mt-1">Paket Kuis Edukatif</div>
            </div>
        </div>

        <h2 class="text-2xl italic font-medium text-[#33291a] pt-4 rv">Pilar Fitur & Aksesibilitas</h2>
        <ul class="list-disc pl-6 space-y-2 rv">
            <li><strong>Narasi Audio & Pemandu Suara (Text-to-Speech):</strong> Seluruh halaman profil biografi dilengkapi tombol pembaca suara berbahasa Indonesia dan kontrol pembesar huruf bagi sahabat disabilitas serta lansia.</li>
            <li><strong>Suara Interaktif & Musik Ambien:</strong> Efek alunan nada tradisional sintetis dan penanda gulir aktif membantu pengalaman membaca yang imersif dan dapat diatur kapan saja melalui tombol <strong>♪</strong> di bilah navigasi.</li>
            <li><strong>Peta Interaktif Leaflet.js:</strong> Menyajikan koordinat makam di TMP Panaikang Makassar maupun situs sejarah di Gowa, Toraja Utara, Wajo, Luwu, Takalar, hingga Bulukumba.</li>
            <li><strong>Partisipasi Publik Termoderasi:</strong> Masyarakat serta keluarga tokoh dapat mengirimkan foto dan catatan sejarah yang akan diverifikasi terlebih dahulu oleh admin kurator Dinas Sosial sebelum diterbitkan.</li>
        </ul>

        <div class="border border-[#d6d3c5] bg-[#fbfaf5] p-6 mt-8 rv">
            <span class="sans text-[#7b786d]">Pengembangan & Kemitraan Akademik</span>
            <h3 class="text-2xl font-medium text-[#33291a] mt-1">
                Teknik Komputer dan Jaringan · Politeknik Negeri Ujung Pandang
            </h3>
            <p class="text-base text-[#5a574c] mt-2 m-0">
                Dikembangkan oleh tim mahasiswa Program Studi Teknik Komputer dan Jaringan, Politeknik Negeri Ujung Pandang bersama Dinas Sosial Provinsi Sulawesi Selatan sebagai kontribusi pelestarian memori sejarah bangsa dan literasi kepahlawanan daerah.
            </p>
        </div>

        <div class="pt-4 flex flex-wrap gap-3 rv">
            <a href="{{ route('heroes.index') }}" class="editorial-btn-solid sans">Jelajahi Direktori Pahlawan</a>
            <a href="{{ route('quiz.index') }}" class="editorial-btn sans">Coba Kuis & Raih Sertifikat</a>
            <a href="{{ route('map.index') }}" class="editorial-btn sans">Buka Peta Situs Sejarah</a>
        </div>
    </div>
</div>
@endsection
