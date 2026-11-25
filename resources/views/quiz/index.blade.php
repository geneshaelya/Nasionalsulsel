@extends('layouts.app')

@section('title', 'Kuis Interaktif Sejarah Pahlawan – Sulawesi Selatan')

@section('content')
<div class="max-w-6xl mx-auto px-5 pt-28 pb-16">
    <div class="border-b border-[#d6d3c5] pb-8 mb-10">
        <p class="sans text-[#7b786d]">Evaluasi Edukatif & Sertifikat Digital · Dinas Sosial Sulsel</p>
        <h1 class="text-4xl sm:text-5xl font-medium italic text-[#33291a] mt-2">
            Kuis Interaktif Pahlawan Sulawesi Selatan
        </h1>
        <p class="text-lg text-[#5a574c] mt-2 max-w-3xl">
            Uji pemahaman Anda melalui <strong>Kuis Umum Keseluruhan</strong> terlebih dahulu, lalu tantang diri Anda pada <strong>kuis individual masing-masing tokoh</strong>. Peserta yang mencapai nilai minimal kelulusan berhak mengunduh sertifikat PDF resmi.
        </p>
    </div>

    {{-- Kuis Keseluruhan di Bagian Awal Sebelum Kuis Tiap Individual Pahlawan --}}
    @if ($overallQuiz)
        <section class="border-2 border-[#33291a] bg-[#fbfaf5] p-6 sm:p-8 mb-12 rv">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                <div class="lg:col-span-8">
                    <span class="sans px-2.5 py-1 bg-[#33291a] text-[#fffdf6] inline-block mb-3">
                        Tahap 1 · Kuis Menyeluruh (14 Pahlawan Sulsel)
                    </span>
                    <h2 class="text-3xl sm:text-4xl italic font-medium text-[#33291a]">
                        {{ $overallQuiz->judul }}
                    </h2>
                    <p class="text-lg text-[#5a574c] mt-2">
                        {{ $overallQuiz->deskripsi }}
                    </p>
                    <div class="flex flex-wrap gap-5 mt-4 sans text-[#7b786d]">
                        <span>{{ $overallQuiz->questions_count }} Pertanyaan</span>
                        <span>Durasi Disarankan: {{ $overallQuiz->durasi_menit }} Menit</span>
                        <span>Batas Lulus: {{ $overallQuiz->passing_score }}%</span>
                    </div>
                </div>
                <div class="lg:col-span-4 lg:text-right">
                    <a href="{{ route('quiz.show', $overallQuiz->slug) }}" class="editorial-btn-solid sans px-6 py-4">
                        Mulai Kuis Keseluruhan →
                    </a>
                </div>
            </div>
        </section>
    @endif

    <div class="mb-6">
        <span class="sans text-[#7b786d]">Tahap 2 · Spesialisasi Tokoh</span>
        <h2 class="text-3xl italic font-medium text-[#33291a] mt-1">
            Kuis Individual Setiap Pahlawan
        </h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($heroQuizzes as $quiz)
            <article class="border border-[#d6d3c5] bg-[#fbfaf5] p-5 flex flex-col justify-between rv hover:border-[#33291a] transition">
                <div>
                    <div class="flex items-center gap-3.5 mb-3">
                        @if ($quiz->hero)
                            <img
                                src="{{ $quiz->hero->foto_url }}"
                                alt="{{ $quiz->hero->nama }}"
                                class="w-14 h-16 object-cover object-top border border-[#d6d3c5]"
                                style="filter: sepia(15%);"
                            >
                        @endif
                        <div>
                            <span class="sans text-[#7b786d]">{{ $quiz->hero?->asal_daerah }} · {{ $quiz->questions_count }} Soal</span>
                            <h3 class="text-xl font-semibold text-[#25231e] leading-snug mt-0.5">
                                {{ $quiz->hero?->nama ?? $quiz->judul }}
                            </h3>
                        </div>
                    </div>
                    <p class="text-sm text-[#5a574c]">{{ $quiz->deskripsi }}</p>
                </div>

                <div class="mt-4 pt-3 border-t border-[#d6d3c5]/70 flex items-center justify-between gap-2">
                    <a href="{{ route('quiz.show', $quiz->slug) }}" class="editorial-btn-solid sans py-2 px-3">
                        Mulai Kuis
                    </a>
                    @if ($quiz->hero)
                        <a href="{{ route('heroes.show', $quiz->hero->slug) }}" class="sans text-[#7b786d] hover:text-[#33291a]">
                            Baca Biografi
                        </a>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
</div>
@endsection
