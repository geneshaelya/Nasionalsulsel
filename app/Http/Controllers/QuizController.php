<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;

class QuizController extends Controller
{
    public function index(): View
    {
        $overallQuiz = Quiz::query()
            ->whereNull('hero_id')
            ->where('is_active', true)
            ->withCount('questions')
            ->first();

        $heroQuizzes = Quiz::query()
            ->whereNotNull('hero_id')
            ->where('is_active', true)
            ->with('hero:id,slug,nama,gelar_singkat,asal_daerah,foto_utama,warna_aksen,urutan')
            ->withCount('questions')
            ->get()
            ->sortBy(fn (Quiz $quiz): int => $quiz->hero?->urutan ?? 999)
            ->values();

        return view('quiz.index', [
            'overallQuiz' => $overallQuiz,
            'heroQuizzes' => $heroQuizzes,
        ]);
    }

    public function show(Quiz $quiz): View
    {
        if (! $quiz->is_active) {
            abort(404);
        }

        $quiz->load(['hero', 'questions']);

        return view('quiz.play', [
            'quiz' => $quiz,
        ]);
    }

    public function submit(Request $request, Quiz $quiz): RedirectResponse
    {
        if (! $quiz->is_active) {
            abort(404);
        }

        $validated = $request->validate([
            'nama_peserta' => ['required', 'string', 'min:2', 'max:120'],
            'asal_instansi' => ['nullable', 'string', 'max:150'],
            'answers' => ['required', 'array'],
        ], [
            'nama_peserta.required' => 'Nama lengkap wajib diisi untuk pencatatan hasil dan sertifikat.',
            'answers.required' => 'Silakan jawab pertanyaan kuis terlebih dahulu.',
        ]);

        $questions = $quiz->questions()->get();
        $totalSoal = $questions->count();
        $submittedAnswers = $validated['answers'];
        $benar = 0;

        foreach ($questions as $question) {
            $chosen = $submittedAnswers[$question->id] ?? null;
            if ($chosen !== null && (int) $chosen === (int) $question->jawaban_benar) {
                $benar++;
            }
        }

        $persentase = $totalSoal > 0 ? (int) round(($benar / $totalSoal) * 100) : 0;
        $lulus = $persentase >= $quiz->passing_score;

        $certificateNumber = $lulus
            ? 'SULSEL-'.now()->format('Ymd').'-'.strtoupper(Str::random(6))
            : null;

        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'nama_peserta' => $validated['nama_peserta'],
            'asal_instansi' => $validated['asal_instansi'] ?: 'Masyarakat Umum / Pelajar',
            'skor' => $benar,
            'total_soal' => $totalSoal,
            'persentase' => $persentase,
            'lulus' => $lulus,
            'nomor_sertifikat' => $certificateNumber,
            'completed_at' => now(),
        ]);

        session()->put("quiz_answers_{$attempt->id}", $submittedAnswers);

        return redirect()->route('quiz.result', [$quiz->slug, $attempt->id]);
    }

    public function result(Quiz $quiz, QuizAttempt $attempt): View
    {
        if ($attempt->quiz_id !== $quiz->id) {
            abort(404);
        }

        $quiz->load(['hero', 'questions']);
        $submittedAnswers = session()->get("quiz_answers_{$attempt->id}", []);

        return view('quiz.result', [
            'quiz' => $quiz,
            'attempt' => $attempt,
            'submittedAnswers' => $submittedAnswers,
        ]);
    }

    public function certificate(QuizAttempt $attempt): Response
    {
        if (! $attempt->lulus || ! $attempt->nomor_sertifikat) {
            abort(403, 'Sertifikat hanya tersedia bagi peserta yang mencapai batas kelulusan.');
        }

        $attempt->load('quiz.hero');

        $pdf = Pdf::loadView('quiz.certificate', [
            'attempt' => $attempt,
            'quiz' => $attempt->quiz,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('sertifikat-'.str($attempt->nama_peserta)->slug().'-'.$attempt->nomor_sertifikat.'.pdf');
    }
}
