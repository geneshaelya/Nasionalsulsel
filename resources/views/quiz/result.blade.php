@extends('layouts.app')

@section('title', 'Hasil Kuis: ' . $quiz->judul)
@section('accent_color', $quiz->hero?->warna_aksen ?: '#33291a')

@section('content')
<div class="max-w-4xl mx-auto px-5 pt-28 pb-16">
    <div class="border-2 {{ $attempt->lulus ? 'border-[#3f7d00]' : 'border-[#8b3a2b]' }} bg-[#fbfaf5] p-6 sm:p-8 mb-10">
        <span class="sans {{ $attempt->lulus ? 'text-[#3f7d00]' : 'text-[#8b3a2b]' }}">
            {{ $attempt->lulus ? 'Selamat · Anda Lulus Evaluasi Sejarah' : 'Belum Memenuhi Batas Minimal Kelulusan' }}
        </span>
        <h1 class="text-4xl font-medium italic text-[#33291a] mt-1">{{ $quiz->judul }}</h1>
        <p class="text-lg text-[#5a574c] mt-1">
            Peserta: <strong>{{ $attempt->nama_peserta }}</strong> ({{ $attempt->asal_instansi }})
        </p>

        <div class="grid grid-cols-3 gap-4 my-6 border-y border-[#d6d3c5] py-5 text-center">
            <div>
                <div class="text-3xl font-semibold text-[#33291a]">{{ $attempt->persentase }}%</div>
                <div class="sans text-[#7b786d] mt-1">Nilai Akhir</div>
            </div>
            <div>
                <div class="text-3xl font-semibold text-[#33291a]">{{ $attempt->skor }} / {{ $attempt->total_soal }}</div>
                <div class="sans text-[#7b786d] mt-1">Jawaban Benar</div>
            </div>
            <div>
                <div class="text-3xl font-semibold text-[#33291a]">{{ $quiz->passing_score }}%</div>
                <div class="sans text-[#7b786d] mt-1">Syarat Lulus</div>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            @if ($attempt->lulus && $attempt->nomor_sertifikat)
                <a href="{{ route('quiz.certificate', $attempt->nomor_sertifikat) }}" class="editorial-btn-solid sans">
                    📜 Unduh Sertifikat PDF ({{ $attempt->nomor_sertifikat }})
                </a>
            @else
                <a href="{{ route('quiz.show', $quiz->slug) }}" class="editorial-btn-solid sans">
                    Ulangi Kuis Ini
                </a>
            @endif
            <a href="{{ route('quiz.index') }}" class="editorial-btn sans">Daftar Semua Kuis</a>
            @if ($quiz->hero)
                <a href="{{ route('heroes.show', $quiz->hero->slug) }}" class="editorial-btn sans">Kembali ke Profil {{ $quiz->hero->nama }}</a>
            @else
                <a href="{{ route('heroes.index') }}" class="editorial-btn sans">Jelajahi Tiap Pahlawan →</a>
            @endif
        </div>
    </div>

    <h2 class="text-3xl italic font-medium text-[#33291a] mb-5">Pembahasan Jawaban</h2>
    <div class="space-y-4">
        @foreach ($quiz->questions as $index => $question)
            @php
                $chosen = isset($submittedAnswers[$question->id]) ? (int) $submittedAnswers[$question->id] : null;
                $isCorrect = $chosen !== null && $chosen === (int) $question->jawaban_benar;
            @endphp
            <div class="border border-[#d6d3c5] bg-[#fbfaf5] p-5">
                <div class="flex items-center justify-between gap-2 mb-2">
                    <span class="sans text-[#7b786d]">Soal {{ $index + 1 }}</span>
                    @if ($chosen !== null)
                        <span class="sans {{ $isCorrect ? 'text-[#3f7d00]' : 'text-[#c0392b]' }}">
                            {{ $isCorrect ? '✓ Benar' : '✕ Kurang Tepat' }}
                        </span>
                    @endif
                </div>
                <h3 class="text-xl font-medium text-[#25231e]">{{ $question->pertanyaan }}</h3>
                <p class="text-base text-[#3f7d00] mt-2 mb-1">
                    <strong>Jawaban Benar:</strong> {{ $question->opsi[$question->jawaban_benar] ?? '-' }}
                </p>
                @if ($chosen !== null && ! $isCorrect)
                    <p class="text-sm text-[#c0392b] m-0 mb-1">
                        <strong>Pilihan Anda:</strong> {{ $question->opsi[$chosen] ?? '-' }}
                    </p>
                @endif
                @if ($question->penjelasan)
                    <p class="text-sm text-[#5a574c] mt-2 pt-2 border-t border-[#d6d3c5]/70 m-0">
                        {{ $question->penjelasan }}
                    </p>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    window.PortalAudio.sfx(@json($attempt->lulus) ? 'ok' : 'no');
});
</script>
@endpush
