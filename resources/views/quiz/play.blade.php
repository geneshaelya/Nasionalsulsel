@extends('layouts.app')

@section('title', $quiz->judul . ' – Kuis Pahlawan Sulsel')
@section('accent_color', $quiz->hero?->warna_aksen ?: '#33291a')

@section('content')
<div
    class="max-w-3xl mx-auto px-5 pt-28 pb-16"
    x-data="{
        totalQuestions: {{ $quiz->questions->count() }},
        answered: {},
        secondsLeft: {{ $quiz->durasi_menit * 60 }},
        init() {
            window.setInterval(() => {
                if (this.secondsLeft > 0) this.secondsLeft--;
            }, 1000);
        },
        markAnswered(qid) {
            this.answered[qid] = true;
            window.PortalAudio.sfx('tick', Object.keys(this.answered).length);
        },
        get answeredCount() {
            return Object.keys(this.answered).length;
        },
        get formattedTime() {
            const m = Math.floor(this.secondsLeft / 60);
            const s = this.secondsLeft % 60;
            return String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
        }
    }"
>
    <div class="mb-6">
        <a href="{{ route('quiz.index') }}" class="sans text-[var(--c)] hover:underline">← Kembali ke Daftar Kuis</a>
    </div>

    <div class="border border-[#d6d3c5] bg-[#fbfaf5] p-6 sm:p-8 mb-8">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-2">
            <span class="sans text-[var(--c)]">
                {{ $quiz->hero ? 'Kuis Tokoh: ' . $quiz->hero->nama : 'Kuis Umum Keseluruhan' }}
            </span>
            <span class="sans px-2.5 py-1 border border-[#d6d3c5] text-[#33291a]">
                Waktu: <span x-text="formattedTime"></span>
            </span>
        </div>

        <h1 class="text-3xl sm:text-4xl italic font-medium text-[var(--c)]">{{ $quiz->judul }}</h1>
        <p class="text-base text-[#5a574c] mt-2">{{ $quiz->deskripsi }}</p>

        <div class="mt-4">
            <div class="flex justify-between sans text-[#7b786d] mb-1">
                <span>Progres Jawaban</span>
                <span><span x-text="answeredCount"></span> / {{ $quiz->questions->count() }} Terjawab · KKM {{ $quiz->passing_score }}%</span>
            </div>
            <div class="w-full h-2.5 bg-[#e6e2d3] overflow-hidden">
                <div
                    class="h-full bg-[var(--c)] transition-all duration-300"
                    :style="'width: ' + (totalQuestions > 0 ? Math.round((answeredCount / totalQuestions) * 100) : 0) + '%'"
                ></div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="border border-[#c0392b] bg-[#fde5e2] text-[#7a1d14] p-4 mb-6">
            <ul class="list-disc pl-5 m-0 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('quiz.submit', $quiz->slug) }}" class="space-y-6">
        @csrf

        <div class="border border-[#d6d3c5] bg-[#fbfaf5] p-6">
            <span class="sans text-[#7b786d] block mb-3">Identitas Peserta (Untuk Sertifikat PDF)</span>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nama_peserta" class="sans text-[#33291a] block mb-1">Nama Lengkap *</label>
                    <input
                        id="nama_peserta"
                        type="text"
                        name="nama_peserta"
                        value="{{ old('nama_peserta') }}"
                        required
                        placeholder="Contoh: Andi Nurul Hidayah"
                        class="w-full border border-[#d6d3c5] bg-white px-3 py-2 text-base"
                    >
                </div>
                <div>
                    <label for="asal_instansi" class="sans text-[#33291a] block mb-1">Sekolah / Kampus / Instansi</label>
                    <input
                        id="asal_instansi"
                        type="text"
                        name="asal_instansi"
                        value="{{ old('asal_instansi') }}"
                        placeholder="Contoh: SMAN 1 Makassar / PNUP"
                        class="w-full border border-[#d6d3c5] bg-white px-3 py-2 text-base"
                    >
                </div>
            </div>
        </div>

        @foreach ($quiz->questions as $index => $question)
            <fieldset class="border border-[#d6d3c5] bg-[#fbfaf5] p-6">
                <div class="flex items-start justify-between gap-4 mb-3">
                    <legend class="text-xl font-semibold text-[#25231e] leading-snug">
                        <span class="sans text-[var(--c)] block mb-1">Pertanyaan {{ $index + 1 }}</span>
                        {{ $question->pertanyaan }}
                    </legend>
                    <button
                        type="button"
                        class="editorial-btn sans py-1 px-2.5 shrink-0"
                        onclick="window.PortalAudio.say('{{ e('Pertanyaan ' . ($index + 1) . '. ' . $question->pertanyaan) }}', { force: true })"
                    >
                        🔊 Baca
                    </button>
                </div>

                <div class="space-y-2.5 mt-3">
                    @foreach ($question->opsi as $optIndex => $optText)
                        <label class="flex items-start gap-3 p-3.5 border border-[#d6d3c5] bg-white hover:border-[var(--c)] cursor-pointer transition">
                            <input
                                type="radio"
                                name="answers[{{ $question->id }}]"
                                value="{{ $optIndex }}"
                                required
                                @checked(old("answers.{$question->id}") !== null && (int) old("answers.{$question->id}") === $optIndex)
                                @change="markAnswered({{ $question->id }})"
                                class="mt-1.5 accent-[var(--c)]"
                            >
                            <span class="text-lg text-[#25231e]">{{ $optText }}</span>
                        </label>
                    @endforeach
                </div>
            </fieldset>
        @endforeach

        <button type="submit" class="editorial-btn-solid sans w-full justify-center py-4 text-xs">
            Selesaikan Kuis & Lihat Hasil Nilai
        </button>
    </form>
</div>
@endsection
