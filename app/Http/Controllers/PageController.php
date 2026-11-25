<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\HistoricalSite;
use App\Models\Quiz;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('about', [
            'nasionalCount' => Hero::query()->where('is_published', true)->where('kategori', 'nasional')->count(),
            'totalHeroesCount' => Hero::query()->where('is_published', true)->count(),
            'sitesCount' => HistoricalSite::query()->where('is_published', true)->count(),
            'quizzesCount' => Quiz::query()->where('is_active', true)->count(),
        ]);
    }
}
