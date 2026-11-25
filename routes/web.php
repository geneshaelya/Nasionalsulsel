<?php

use App\Http\Controllers\ContributionController;
use App\Http\Controllers\GlossaryController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\Tp2gdController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HeroController::class, 'home'])->name('home');

Route::get('/pahlawan', [HeroController::class, 'index'])->name('heroes.index');
Route::get('/pahlawan/{hero:slug}', [HeroController::class, 'show'])->name('heroes.show');

Route::get('/peta', [MapController::class, 'index'])->name('map.index');
Route::get('/api/sites', [MapController::class, 'sites'])->name('api.sites');

Route::get('/tp2gd', [Tp2gdController::class, 'index'])->name('tp2gd.index');
Route::get('/tp2gd/dokumen/{document}/unduh', [Tp2gdController::class, 'download'])->name('tp2gd.download');

Route::get('/kuis', [QuizController::class, 'index'])->name('quiz.index');
Route::get('/kuis/sertifikat/{attempt:nomor_sertifikat}', [QuizController::class, 'certificate'])->name('quiz.certificate');
Route::get('/kuis/{quiz:slug}', [QuizController::class, 'show'])->name('quiz.show');
Route::post('/kuis/{quiz:slug}/selesai', [QuizController::class, 'submit'])->name('quiz.submit');
Route::get('/kuis/{quiz:slug}/hasil/{attempt}', [QuizController::class, 'result'])->name('quiz.result');

Route::get('/kontribusi', [ContributionController::class, 'create'])->name('contributions.create');
Route::post('/kontribusi', [ContributionController::class, 'store'])->name('contributions.store');

Route::get('/glosarium', [GlossaryController::class, 'index'])->name('glossary.index');

Route::get('/tentang', [PageController::class, 'about'])->name('about');
