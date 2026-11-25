@extends('layouts.app')

@section('title', 'Glosarium Istilah Sejarah & Bahasa Daerah – Sulawesi Selatan')

@section('content')
<div class="max-w-5xl mx-auto px-5 pt-28 pb-16">
    <div class="border-b border-[#d6d3c5] pb-8 mb-8">
        <p class="sans text-[#7b786d]">Aksesibilitas Budaya & Literasi Lokal</p>
        <h1 class="text-4xl sm:text-5xl font-medium italic text-[#33291a] mt-2">
            Glosarium Istilah Bugis, Makassar, Toraja & Mandar
        </h1>
        <p class="text-lg text-[#5a574c] mt-2 max-w-2xl">
            Memahami gelar kehormatan, falsafah perjuangan, dan kosakata sejarah lokal Sulawesi Selatan lengkap dengan panduan pelafalan suara.
        </p>
    </div>

    <form method="GET" action="{{ route('glossary.index') }}" class="flex flex-wrap items-end gap-4 mb-10">
        <div class="flex-1 min-w-[220px]">
            <label for="glos-q" class="sans text-[#7b786d] block mb-1">Cari Istilah atau Makna</label>
            <input
                id="glos-q"
                type="search"
                name="q"
                value="{{ $search }}"
                placeholder="Mis. Siri, Karaeng, Arung Matoa, Maraqdia…"
                class="w-full border border-[#d6d3c5] bg-[#fbfaf5] px-3 py-2 text-base text-[#25231e] focus:border-[#33291a] focus:outline-none"
            >
        </div>

        <div>
            <label for="glos-lang" class="sans text-[#7b786d] block mb-1">Rumpun Bahasa</label>
            <select id="glos-lang" name="bahasa" class="border border-[#d6d3c5] bg-[#fbfaf5] px-3 py-2 text-base text-[#25231e]">
                <option value="">Semua Bahasa Daerah</option>
                @foreach ($languages as $lang)
                    <option value="{{ $lang }}" @selected($activeLanguage === $lang)>{{ $lang }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="editorial-btn-solid sans">Cari</button>
        @if ($activeLanguage !== '' || $search !== '')
            <a href="{{ route('glossary.index') }}" class="editorial-btn sans">Reset</a>
        @endif
    </form>

    @if ($terms->isEmpty())
        <div class="border border-dashed border-[#d6d3c5] p-10 text-center">
            <p class="text-xl italic text-[#5a574c]">Belum ada istilah yang cocok dengan pencarian Anda.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach ($terms as $term)
                <article class="border border-[#d6d3c5] bg-[#fbfaf5] p-6 flex flex-col justify-between rv">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <span class="sans px-2.5 py-0.5 border border-[#33291a] text-[#33291a]">{{ $term->bahasa }}</span>
                            @if ($term->pelafalan)
                                <span class="text-sm italic text-[#7b786d]">/{{ $term->pelafalan }}/</span>
                            @endif
                        </div>

                        <h2 class="text-2xl font-semibold text-[#25231e] mt-1">{{ $term->istilah }}</h2>
                        <p class="text-base text-[#25231e] mt-2">{{ $term->arti }}</p>

                        @if ($term->konteks_sejarah)
                            <p class="text-sm text-[#5a574c] mt-3 pt-3 border-t border-[#d6d3c5]/70">
                                <strong>Konteks Sejarah:</strong> {{ $term->konteks_sejarah }}
                            </p>
                        @endif
                    </div>

                    <div class="mt-4 pt-3 border-t border-[#d6d3c5]/70 flex items-center justify-between gap-3">
                        <button
                            type="button"
                            class="editorial-btn sans py-1.5 px-3"
                            onclick="window.PortalAudio.say('{{ e($term->istilah . '. Dalam bahasa ' . $term->bahasa . ', artinya ' . $term->arti) }}', { force: true })"
                        >
                            🔊 Dengarkan
                        </button>
                        @if ($term->hero)
                            <a href="{{ route('heroes.show', $term->hero->slug) }}" class="sans text-[#8b3a2b] hover:underline">
                                {{ $term->hero->nama }} →
                            </a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endsection
