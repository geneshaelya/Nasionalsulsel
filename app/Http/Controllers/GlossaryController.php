<?php

namespace App\Http\Controllers;

use App\Models\GlossaryTerm;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GlossaryController extends Controller
{
    public function index(Request $request): View
    {
        $bahasa = $request->string('bahasa')->toString();
        $search = trim($request->string('q')->toString());

        $query = GlossaryTerm::query()
            ->where('is_published', true)
            ->with('hero:id,slug,nama')
            ->orderBy('bahasa')
            ->orderBy('istilah');

        if ($bahasa !== '' && in_array($bahasa, ['Bugis', 'Makassar', 'Toraja', 'Mandar'], true)) {
            $query->where('bahasa', $bahasa);
        }

        if ($search !== '') {
            $query->where(function ($sub) use ($search): void {
                $sub->where('istilah', 'like', "%{$search}%")
                    ->orWhere('arti', 'like', "%{$search}%")
                    ->orWhere('konteks_sejarah', 'like', "%{$search}%");
            });
        }

        $terms = $query->get();

        return view('glossary.index', [
            'terms' => $terms,
            'languages' => ['Bugis', 'Makassar', 'Toraja', 'Mandar'],
            'activeLanguage' => $bahasa,
            'search' => $search,
        ]);
    }
}
