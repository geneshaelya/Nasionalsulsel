@extends('layouts.app')

@section('title', 'Peta Persebaran Makam & Situs Sejarah – Sulawesi Selatan')

@section('content')
<div class="max-w-7xl mx-auto px-5 pt-28 pb-16">
    <div class="border-b border-[#d6d3c5] pb-6 mb-6">
        <p class="sans text-[#7b786d]">Pemetaan Geospasial Sejarah · Dinas Sosial Provinsi Sulawesi Selatan</p>
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mt-2">
            <div>
                <h1 class="text-4xl sm:text-5xl font-medium italic text-[#33291a]">
                    Peta Persebaran Makam & Situs Sejarah
                </h1>
                <p class="text-lg text-[#5a574c] mt-1 max-w-2xl">
                    Titik koordinat makam pahlawan, benteng maritim, dan monumen perjuangan di Sulawesi Selatan lengkap dengan panduan ziarah dan navigasi peta.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <select id="filter-jenis" class="border border-[#d6d3c5] bg-[#fbfaf5] px-3 py-2 text-sm text-[#25231e]">
                    <option value="">Semua Jenis Situs</option>
                    <option value="makam">Makam Pahlawan</option>
                    <option value="monumen">Monumen Perjuangan</option>
                    <option value="situs_perjuangan">Situs Sejarah & Benteng</option>
                </select>
                <select id="filter-kota" class="border border-[#d6d3c5] bg-[#fbfaf5] px-3 py-2 text-sm text-[#25231e]">
                    <option value="">Semua Kab/Kota</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region }}">{{ $region }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-8">
            <div class="border border-[#d6d3c5] bg-[#e9e6da] p-1.5">
                <div id="sulsel-map" class="w-full h-[460px] sm:h-[580px] z-10"></div>
            </div>
            <p class="sans text-[#7b786d] mt-2">
                Ketuk penanda pada peta untuk melihat alamat, jam ziarah, serta tautan Google Maps.
            </p>
        </div>

        <aside class="lg:col-span-4 border border-[#d6d3c5] bg-[#fbfaf5] flex flex-col max-h-[615px]">
            <div class="p-4 border-b border-[#d6d3c5] flex items-center justify-between">
                <span class="sans text-[#33291a]">Daftar Lokasi</span>
                <span id="site-count" class="sans text-[#7b786d]">{{ $sites->count() }} Titik</span>
            </div>
            <div id="site-list" class="overflow-y-auto divide-y divide-[#d6d3c5]/70 flex-1">
                @foreach ($sites as $site)
                    <button
                        type="button"
                        class="site-list-item w-full text-left p-4 hover:bg-[#f1f0ea] transition cursor-pointer"
                        data-slug="{{ $site->slug }}"
                        data-hero-slug="{{ $site->hero?->slug }}"
                        data-jenis="{{ $site->jenis }}"
                        data-kota="{{ $site->kabupaten_kota }}"
                    >
                        <span class="sans text-[#8b3a2b] block">{{ $site->jenis_label }} · {{ $site->kabupaten_kota }}</span>
                        <strong class="block text-lg font-medium text-[#25231e] mt-0.5">{{ $site->nama }}</strong>
                        @if ($site->hero)
                            <span class="block text-sm italic text-[#5a574c] mt-0.5">Tokoh: {{ $site->hero->nama }}</span>
                        @endif
                        <span class="block text-xs text-[#7b786d] mt-1">{{ $site->alamat }}</span>
                    </button>
                @endforeach
            </div>
        </aside>
    </div>
</div>
@endsection

@push('scripts')
@php
    $siteMarkersData = $sites->map(fn ($s) => [
        'slug' => $s->slug,
        'heroSlug' => $s->hero?->slug,
        'heroName' => $s->hero?->nama,
        'heroUrl' => $s->hero ? route('heroes.show', $s->hero->slug) : null,
        'nama' => $s->nama,
        'jenis' => $s->jenis,
        'jenisLabel' => $s->jenis_label,
        'alamat' => $s->alamat,
        'kota' => $s->kabupaten_kota,
        'lat' => $s->latitude,
        'lng' => $s->longitude,
        'jam' => $s->jam_kunjungan,
        'info' => $s->info_ziarah,
        'akses' => $s->akses_navigasi,
        'mapsUrl' => $s->google_maps_url,
        'color' => $s->hero?->warna_aksen ?? '#33291a',
    ])->values()->all();
@endphp
<script>
document.addEventListener('DOMContentLoaded', () => {
    const mapEl = document.getElementById('sulsel-map');
    if (!mapEl || typeof window.L === 'undefined') return;

    const L = window.L;
    const map = L.map('sulsel-map', {
        center: [-4.45, 119.85],
        zoom: 7,
        scrollWheelZoom: true
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        className: 'vintage-map-tile',
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const allSites = @json($siteMarkersData);

    const selectedSiteSlug = @json($selectedSiteSlug);
    const selectedHeroSlug = @json($selectedHeroSlug);
    const markersLayer = L.layerGroup().addTo(map);
    const markersBySlug = {};

    function makePin(color) {
        return L.divIcon({
            className: 'custom-vintage-pin',
            html: `<div style="width:22px;height:22px;border-radius:50% 50% 50% 0;background:${color};transform:rotate(-45deg);border:2px solid #fffdf6;box-shadow:0 3px 8px rgba(0,0,0,0.4);"></div>`,
            iconSize: [22, 22],
            iconAnchor: [11, 22],
            popupAnchor: [0, -22]
        });
    }

    function esc(s) {
        return String(s ?? '').replace(/[&<>"]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));
    }

    function renderMarkers(jenisFilter, kotaFilter) {
        markersLayer.clearLayers();
        let visibleCount = 0;

        document.querySelectorAll('.site-list-item').forEach((btn) => {
            const matchJenis = !jenisFilter || btn.dataset.jenis === jenisFilter;
            const matchKota = !kotaFilter || btn.dataset.kota === kotaFilter;
            const show = matchJenis && matchKota;
            btn.style.display = show ? 'block' : 'none';
            if (show) visibleCount++;
        });

        const countEl = document.getElementById('site-count');
        if (countEl) countEl.textContent = `${visibleCount} Titik`;

        allSites.forEach((site) => {
            if (jenisFilter && site.jenis !== jenisFilter) return;
            if (kotaFilter && site.kota !== kotaFilter) return;

            const marker = L.marker([site.lat, site.lng], { icon: makePin(site.color) });
            const popupHtml = `
                <div style="min-width:230px;max-width:290px;font-family:'Cormorant Garamond',Georgia,serif;color:#25231e;">
                    <div style="font-family:Inter,sans-serif;font-size:10px;letter-spacing:0.12em;text-transform:uppercase;color:${esc(site.color)};">${esc(site.jenisLabel)} · ${esc(site.kota)}</div>
                    <h3 style="margin:4px 0 6px;font-size:18px;font-weight:600;line-height:1.2;">${esc(site.nama)}</h3>
                    <p style="margin:0 0 6px;font-size:14px;color:#5a574c;">${esc(site.alamat)}</p>
                    ${site.jam ? `<p style="margin:0 0 6px;font-size:13px;"><b>Jam Kunjungan:</b> ${esc(site.jam)}</p>` : ''}
                    ${site.info ? `<p style="margin:0 0 8px;font-size:14px;line-height:1.4;">${esc(site.info)}</p>` : ''}
                    <div style="display:flex;flex-wrap:wrap;gap:6px;margin-top:8px;">
                        ${site.heroUrl ? `<a href="${site.heroUrl}" style="font-family:Inter,sans-serif;font-size:10px;letter-spacing:0.1em;text-transform:uppercase;border:1px solid #33291a;padding:5px 9px;color:#33291a;text-decoration:none;">Profil Tokoh</a>` : ''}
                        <a href="${site.mapsUrl}" target="_blank" rel="noopener" style="font-family:Inter,sans-serif;font-size:10px;letter-spacing:0.1em;text-transform:uppercase;background:#33291a;padding:5px 9px;color:#fffdf6;text-decoration:none;">Google Maps ↗</a>
                    </div>
                </div>
            `;
            marker.bindPopup(popupHtml);
            marker.addTo(markersLayer);
            markersBySlug[site.slug] = { marker, site };
        });
    }

    renderMarkers('', '');

    document.querySelectorAll('.site-list-item').forEach((btn, idx) => {
        btn.addEventListener('click', () => {
            const entry = markersBySlug[btn.dataset.slug];
            if (!entry) return;
            window.PortalAudio.sfx('tick', idx);
            map.flyTo([entry.site.lat, entry.site.lng], 15, { duration: 0.9 });
            entry.marker.openPopup();
        });
    });

    const jenisSelect = document.getElementById('filter-jenis');
    const kotaSelect = document.getElementById('filter-kota');
    const applyFilters = () => {
        renderMarkers(jenisSelect.value, kotaSelect.value);
    };
    jenisSelect.addEventListener('change', applyFilters);
    kotaSelect.addEventListener('change', applyFilters);

    if (selectedSiteSlug && markersBySlug[selectedSiteSlug]) {
        const entry = markersBySlug[selectedSiteSlug];
        map.setView([entry.site.lat, entry.site.lng], 15);
        entry.marker.openPopup();
    } else if (selectedHeroSlug) {
        const match = allSites.find((s) => s.heroSlug === selectedHeroSlug);
        if (match && markersBySlug[match.slug]) {
            const entry = markersBySlug[match.slug];
            map.setView([entry.site.lat, entry.site.lng], 14);
            entry.marker.openPopup();
        }
    }
});
</script>
@endpush
