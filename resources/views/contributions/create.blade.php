@extends('layouts.app')

@section('title', 'Kontribusi Arsip Publik – Portal Pahlawan Sulsel')

@section('content')
<div class="max-w-5xl mx-auto px-5 pt-28 pb-16">
    <div class="border-b border-[#d6d3c5] pb-8 mb-8">
        <p class="sans text-[#7b786d]">Partisipasi Masyarakat & Keluarga Tokoh · Moderasi Dinsos Sulsel</p>
        <h1 class="text-4xl sm:text-5xl font-medium italic text-[#33291a] mt-2">
            Kirim Kontribusi Arsip Sejarah
        </h1>
        <p class="text-lg text-[#5a574c] mt-2 max-w-3xl">
            Apakah Anda memiliki foto bersejarah, salinan dokumen keluarga, atau kesaksian riwayat pahlawan Sulawesi Selatan? Kirimkan melalui formulir berikut. Setiap kiriman berstatus <strong>draft</strong> dan wajib diverifikasi oleh kurator Dinas Sosial sebelum tayang.
        </p>
    </div>

    @if (session('success'))
        <div class="border border-[#3f7d00] bg-[#e8f7d4] text-[#234700] p-5 mb-8">
            <span class="sans block mb-1">Kiriman Diterima</span>
            <p class="m-0 text-base">{{ session('success') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="border border-[#c0392b] bg-[#fde5e2] text-[#7a1d14] p-5 mb-8">
            <span class="sans block mb-2">Periksa Kembali Isian Anda</span>
            <ul class="list-disc pl-5 m-0 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-7">
            <form method="POST" action="{{ route('contributions.store') }}" enctype="multipart/form-data" class="border border-[#d6d3c5] bg-[#fbfaf5] p-6 space-y-5">
                @csrf

                <div>
                    <label for="hero_id" class="sans text-[#7b786d] block mb-1">Tokoh Pahlawan Terkait (Opsional)</label>
                    <select id="hero_id" name="hero_id" class="w-full border border-[#d6d3c5] bg-white px-3 py-2 text-base">
                        <option value="">Umum / Usulan Tokoh Baru</option>
                        @foreach ($heroes as $hero)
                            <option
                                value="{{ $hero->id }}"
                                @selected(old('hero_id') == $hero->id || $selectedHeroSlug === $hero->slug)
                            >
                                {{ $hero->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_pengirim" class="sans text-[#7b786d] block mb-1">Nama Lengkap Pengirim *</label>
                        <input id="nama_pengirim" type="text" name="nama_pengirim" value="{{ old('nama_pengirim') }}" required class="w-full border border-[#d6d3c5] bg-white px-3 py-2 text-base">
                    </div>
                    <div>
                        <label for="hubungan_tokoh" class="sans text-[#7b786d] block mb-1">Hubungan / Kapasitas</label>
                        <input id="hubungan_tokoh" type="text" name="hubungan_tokoh" value="{{ old('hubungan_tokoh') }}" placeholder="Mis. Cucu tokoh, Peneliti sejarah" class="w-full border border-[#d6d3c5] bg-white px-3 py-2 text-base">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="sans text-[#7b786d] block mb-1">Alamat Email *</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full border border-[#d6d3c5] bg-white px-3 py-2 text-base">
                    </div>
                    <div>
                        <label for="telepon" class="sans text-[#7b786d] block mb-1">Nomor Telepon / WhatsApp</label>
                        <input id="telepon" type="text" name="telepon" value="{{ old('telepon') }}" class="w-full border border-[#d6d3c5] bg-white px-3 py-2 text-base">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="jenis_kontribusi" class="sans text-[#7b786d] block mb-1">Jenis Kontribusi *</label>
                        <select id="jenis_kontribusi" name="jenis_kontribusi" required class="w-full border border-[#d6d3c5] bg-white px-3 py-2 text-base">
                            <option value="catatan_sejarah" @selected(old('jenis_kontribusi') === 'catatan_sejarah')>Catatan Sejarah</option>
                            <option value="foto_arsip" @selected(old('jenis_kontribusi') === 'foto_arsip')>Foto Arsip / Dokumentasi</option>
                            <option value="dokumen_keluarga" @selected(old('jenis_kontribusi') === 'dokumen_keluarga')>Dokumen / Surat Keluarga</option>
                        </select>
                    </div>
                    <div>
                        <label for="sumber_dokumen" class="sans text-[#7b786d] block mb-1">Sumber / Tahun Arsip</label>
                        <input id="sumber_dokumen" type="text" name="sumber_dokumen" value="{{ old('sumber_dokumen') }}" placeholder="Mis. Koleksi Keluarga (1948)" class="w-full border border-[#d6d3c5] bg-white px-3 py-2 text-base">
                    </div>
                </div>

                <div>
                    <label for="judul" class="sans text-[#7b786d] block mb-1">Judul Arsip / Catatan *</label>
                    <input id="judul" type="text" name="judul" value="{{ old('judul') }}" required class="w-full border border-[#d6d3c5] bg-white px-3 py-2 text-base">
                </div>

                <div>
                    <label for="isi_catatan" class="sans text-[#7b786d] block mb-1">Uraian Catatan Sejarah *</label>
                    <textarea id="isi_catatan" name="isi_catatan" rows="5" required class="w-full border border-[#d6d3c5] bg-white px-3 py-2 text-base">{{ old('isi_catatan') }}</textarea>
                </div>

                <div>
                    <label for="lampiran" class="sans text-[#7b786d] block mb-1">Unggah Foto atau PDF Pendukung (Maks. 4 MB)</label>
                    <input id="lampiran" type="file" name="lampiran" accept=".jpg,.jpeg,.png,.webp,.pdf" class="w-full border border-[#d6d3c5] bg-white px-3 py-2 text-sm">
                </div>

                {{-- Proteksi CAPTCHA --}}
                <div class="border border-[#33291a]/30 bg-[#f1f0ea] p-4">
                    <label for="captcha_answer" class="sans text-[#33291a] block mb-1">
                        Verifikasi Keamanan (CAPTCHA): Berapa hasil dari {{ $captchaQuestion }} ? *
                    </label>
                    <input id="captcha_answer" type="number" name="captcha_answer" required class="w-36 border border-[#33291a] bg-white px-3 py-1.5 text-base" placeholder="Jawaban angka">
                </div>

                <button type="submit" class="editorial-btn-solid sans w-full justify-center py-3">
                    Kirim Arsip untuk Verifikasi Dinsos
                </button>
            </form>
        </div>

        <aside class="lg:col-span-5 space-y-5">
            <div class="border border-[#d6d3c5] bg-[#fbfaf5] p-6">
                <span class="sans text-[#8b3a2b]">Alur Kurasi & Moderasi</span>
                <h2 class="text-2xl italic font-medium text-[#33291a] mt-1">Bagaimana Kiriman Anda Diproses?</h2>
                <ol class="list-decimal pl-5 space-y-2 text-base text-[#3b3830] mt-3">
                    <li>Setiap kontribusi otomatis tersimpan dengan status <strong>Draft</strong> dan tidak langsung tampil di publik.</li>
                    <li>Tim verifikator Bidang Kepahlawanan Dinas Sosial Provinsi Sulsel meninjau keaslian sumber dan kesesuaian data sejarah.</li>
                    <li>Kontribusi yang valid akan diterbitkan pada halaman profil pahlawan terkait beserta kredit nama pengirim.</li>
                </ol>
            </div>

            <div class="border border-[#d6d3c5] bg-[#fbfaf5] p-6">
                <span class="sans text-[#7b786d]">Arsip Publik Terverifikasi</span>
                <h3 class="text-xl font-medium text-[#33291a] mt-1 mb-3">Kiriman Terbaru yang Tayang</h3>
                @if ($publishedContributions->isEmpty())
                    <p class="text-sm italic text-[#7b786d] m-0">Belum ada arsip publik yang diterbitkan. Jadilah kontributor pertama yang mengirim catatan sejarah keluarga.</p>
                @else
                    <div class="space-y-3">
                        @foreach ($publishedContributions as $item)
                            <div class="border-t border-[#d6d3c5] pt-3">
                                <strong class="block text-base text-[#25231e]">{{ $item->judul }}</strong>
                                <span class="sans text-[#7b786d] text-[0.55rem]">
                                    Oleh {{ $item->nama_pengirim }} @if ($item->hero) · {{ $item->hero->nama }} @endif
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </aside>
    </div>
</div>
@endsection
