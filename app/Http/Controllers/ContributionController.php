<?php

namespace App\Http\Controllers;

use App\Models\ArchiveContribution;
use App\Models\Hero;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContributionController extends Controller
{
    public function create(Request $request): View
    {
        $captcha = $this->generateCaptcha($request);

        $heroes = Hero::query()
            ->where('is_published', true)
            ->orderBy('nama')
            ->get(['id', 'slug', 'nama']);

        $publishedContributions = ArchiveContribution::query()
            ->whereIn('status', ['published', 'approved'])
            ->with('hero:id,slug,nama')
            ->latest('verified_at')
            ->limit(6)
            ->get();

        return view('contributions.create', [
            'heroes' => $heroes,
            'selectedHeroSlug' => $request->string('hero')->toString(),
            'captchaQuestion' => $captcha['question'],
            'publishedContributions' => $publishedContributions,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $expectedAnswer = $request->session()->get('contribution_captcha_answer');

        $validated = $request->validate([
            'hero_id' => ['nullable', 'exists:heroes,id'],
            'nama_pengirim' => ['required', 'string', 'min:2', 'max:120'],
            'hubungan_tokoh' => ['nullable', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'judul' => ['required', 'string', 'min:5', 'max:180'],
            'jenis_kontribusi' => ['required', 'in:foto_arsip,catatan_sejarah,dokumen_keluarga'],
            'isi_catatan' => ['required', 'string', 'min:20', 'max:5000'],
            'sumber_dokumen' => ['nullable', 'string', 'max:255'],
            'lampiran' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:4096'],
            'captcha_answer' => [
                'required',
                'integer',
                function (string $attribute, mixed $value, \Closure $fail) use ($expectedAnswer): void {
                    if ($expectedAnswer === null || (int) $value !== (int) $expectedAnswer) {
                        $fail('Jawaban verifikasi keamanan (CAPTCHA) tidak sesuai. Silakan coba hitung kembali.');
                    }
                },
            ],
        ], [
            'nama_pengirim.required' => 'Nama lengkap pengirim wajib diisi.',
            'email.required' => 'Alamat email wajib diisi untuk konfirmasi kurator.',
            'judul.required' => 'Judul arsip atau catatan wajib diisi.',
            'isi_catatan.min' => 'Uraian catatan sejarah minimal 20 karakter.',
            'lampiran.max' => 'Ukuran file lampiran maksimal 4 MB.',
        ]);

        $filePath = null;
        if ($request->hasFile('lampiran')) {
            $filePath = $request->file('lampiran')->store('contributions', 'public');
        }

        ArchiveContribution::create([
            'hero_id' => $validated['hero_id'] ?? null,
            'nama_pengirim' => $validated['nama_pengirim'],
            'hubungan_tokoh' => $validated['hubungan_tokoh'] ?? null,
            'email' => $validated['email'],
            'telepon' => $validated['telepon'] ?? null,
            'judul' => $validated['judul'],
            'jenis_kontribusi' => $validated['jenis_kontribusi'],
            'isi_catatan' => $validated['isi_catatan'],
            'sumber_dokumen' => $validated['sumber_dokumen'] ?? null,
            'file_path' => $filePath,
            'status' => 'draft',
        ]);

        $this->generateCaptcha($request);

        return redirect()
            ->route('contributions.create')
            ->with('success', 'Terima kasih! Kontribusi arsip Anda telah diterima dengan status draft dan akan diverifikasi oleh tim kurator Dinas Sosial Provinsi Sulawesi Selatan sebelum diterbitkan.');
    }

    /**
     * @return array{question: string, answer: int}
     */
    private function generateCaptcha(Request $request): array
    {
        $a = random_int(2, 12);
        $b = random_int(1, 9);
        $answer = $a + $b;

        $request->session()->put('contribution_captcha_answer', $answer);

        return [
            'question' => "{$a} + {$b}",
            'answer' => $answer,
        ];
    }
}
