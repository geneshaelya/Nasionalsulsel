<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\Tp2gdDocument;
use App\Models\Tp2gdGuide;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Tp2gdController extends Controller
{
    public function index(): View
    {
        $guides = Tp2gdGuide::query()
            ->where('is_active', true)
            ->orderBy('tahap_nomor')
            ->get();

        $documents = Tp2gdDocument::query()
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get();

        $calonHeroes = Hero::query()
            ->where('is_published', true)
            ->where('kategori', 'calon')
            ->get();

        return view('tp2gd.index', [
            'guides' => $guides,
            'documents' => $documents,
            'calonHeroes' => $calonHeroes,
        ]);
    }

    public function download(Tp2gdDocument $document): StreamedResponse
    {
        if (! $document->is_active || ! Storage::disk('public')->exists($document->file_path)) {
            abort(404);
        }

        $filename = str($document->judul)->slug().'.pdf';

        return Storage::disk('public')->download($document->file_path, $filename);
    }
}
