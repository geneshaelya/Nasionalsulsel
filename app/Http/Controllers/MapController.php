<?php

namespace App\Http\Controllers;

use App\Models\HistoricalSite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MapController extends Controller
{
    public function index(Request $request): View
    {
        $sites = HistoricalSite::query()
            ->where('is_published', true)
            ->with('hero:id,slug,nama,foto_utama,kategori,warna_aksen')
            ->orderBy('kabupaten_kota')
            ->orderBy('nama')
            ->get();

        $regions = $sites->pluck('kabupaten_kota')->unique()->sort()->values();

        return view('map', [
            'sites' => $sites,
            'regions' => $regions,
            'selectedSiteSlug' => $request->string('site')->toString(),
            'selectedHeroSlug' => $request->string('hero')->toString(),
        ]);
    }

    public function sites(Request $request): JsonResponse
    {
        $query = HistoricalSite::query()
            ->where('is_published', true)
            ->with('hero:id,slug,nama,gelar_singkat,foto_utama,kategori,warna_aksen');

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->string('jenis')->toString());
        }

        if ($request->filled('kabupaten_kota')) {
            $query->where('kabupaten_kota', $request->string('kabupaten_kota')->toString());
        }

        $data = $query->get()->map(function (HistoricalSite $site): array {
            return [
                'id' => $site->id,
                'slug' => $site->slug,
                'nama' => $site->nama,
                'jenis' => $site->jenis,
                'jenis_label' => $site->jenis_label,
                'alamat' => $site->alamat,
                'kabupaten_kota' => $site->kabupaten_kota,
                'latitude' => $site->latitude,
                'longitude' => $site->longitude,
                'jam_kunjungan' => $site->jam_kunjungan,
                'info_ziarah' => $site->info_ziarah,
                'akses_navigasi' => $site->akses_navigasi,
                'google_maps_url' => $site->google_maps_url,
                'hero' => $site->hero ? [
                    'slug' => $site->hero->slug,
                    'nama' => $site->hero->nama,
                    'gelar_singkat' => $site->hero->gelar_singkat,
                    'foto_url' => $site->hero->foto_url,
                    'warna_aksen' => $site->hero->warna_aksen,
                    'url' => route('heroes.show', $site->hero->slug),
                ] : null,
            ];
        });

        return response()->json(['sites' => $data]);
    }
}
