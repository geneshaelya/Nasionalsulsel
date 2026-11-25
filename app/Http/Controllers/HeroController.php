<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HeroController extends Controller
{
    public function home(Request $request): View
    {
        $heroes = Hero::query()
            ->where('is_published', true)
            ->orderBy('tahun_penanda')
            ->orderBy('urutan')
            ->get();

        $overallQuiz = Quiz::query()
            ->whereNull('hero_id')
            ->where('is_active', true)
            ->first();

        return view('welcome', [
            'heroes' => $heroes,
            'overallQuiz' => $overallQuiz,
            'openSearch' => $request->boolean('cari'),
            'minYear' => $heroes->min('tahun_penanda') ?? 1667,
            'maxYear' => $heroes->max('tahun_penanda') ?? 2026,
        ]);
    }

    public function index(Request $request): View
    {
        $kategori = $request->string('kategori')->toString();
        $daerah = $request->string('daerah')->toString();
        $search = trim($request->string('q')->toString());

        $heroesQuery = Hero::query()
            ->where('is_published', true)
            ->with(['quiz', 'historicalSites'])
            ->orderBy('urutan')
            ->orderBy('tahun_penanda');

        if ($kategori !== '' && in_array($kategori, ['nasional', 'daerah', 'calon'], true)) {
            $heroesQuery->where('kategori', $kategori);
        }

        if ($daerah !== '') {
            $heroesQuery->where('asal_daerah', $daerah);
        }

        if ($search !== '') {
            $heroesQuery->where(function ($query) use ($search): void {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('gelar_singkat', 'like', "%{$search}%")
                    ->orWhere('asal_daerah', 'like', "%{$search}%")
                    ->orWhere('ringkasan', 'like', "%{$search}%");
            });
        }

        $heroes = $heroesQuery->get();

        $regions = Hero::query()
            ->where('is_published', true)
            ->distinct()
            ->orderBy('asal_daerah')
            ->pluck('asal_daerah');

        $overallQuiz = Quiz::query()
            ->whereNull('hero_id')
            ->where('is_active', true)
            ->withCount('questions')
            ->first();

        $nasionalCount = Hero::query()
            ->where('is_published', true)
            ->where('kategori', 'nasional')
            ->count();

        return view('heroes.index', [
            'heroes' => $heroes,
            'regions' => $regions,
            'overallQuiz' => $overallQuiz,
            'nasionalCount' => $nasionalCount,
            'activeKategori' => $kategori,
            'activeDaerah' => $daerah,
            'search' => $search,
        ]);
    }

    public function show(Hero $hero): View
    {
        if (! $hero->is_published) {
            abort(404);
        }

        $hero->load([
            'galleries',
            'historicalSites' => fn ($query) => $query->where('is_published', true),
            'quiz.questions',
            'glossaryTerms',
            'contributions' => fn ($query) => $query->whereIn('status', ['published', 'approved'])->latest(),
        ]);

        $orderedHeroes = Hero::query()
            ->where('is_published', true)
            ->orderBy('tahun_penanda')
            ->orderBy('urutan')
            ->get(['id', 'slug', 'nama']);

        $currentIndex = $orderedHeroes->search(fn (Hero $item): bool => $item->id === $hero->id);
        $prevHero = ($currentIndex !== false && $currentIndex > 0) ? $orderedHeroes[$currentIndex - 1] : null;
        $nextHero = ($currentIndex !== false && $currentIndex < $orderedHeroes->count() - 1) ? $orderedHeroes[$currentIndex + 1] : null;

        return view('heroes.show', [
            'hero' => $hero,
            'prevHero' => $prevHero,
            'nextHero' => $nextHero,
        ]);
    }
}
