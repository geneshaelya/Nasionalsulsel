<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal Edukasi Pahlawan Nasional Sulawesi Selatan')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
@php
    $accentColor = trim($__env->yieldContent('accent_color'));
@endphp
<body
    x-data="{ mobileNav: false }"
    @if ($accentColor !== '')
        style="--ac: {{ $accentColor }}; --c: {{ $accentColor }}; background: color-mix(in srgb, {{ $accentColor }} 9%, #f6f3ea);"
    @endif
>
    <header>
        <nav class="site-nav" aria-label="Navigasi Utama">
            <div class="flex items-center gap-3">
                <button
                    type="button"
                    class="lg:hidden border border-current/40 px-2.5 py-1 text-xs sans"
                    @click="mobileNav = !mobileNav"
                    aria-label="Buka Menu"
                >
                    Menu
                </button>
                <div class="hidden lg:flex site-nav-links">
                    <a class="sans {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    <a class="sans {{ request()->routeIs('heroes.*') ? 'active' : '' }}" href="{{ route('heroes.index') }}">Direktori</a>
                    <a class="sans {{ request()->routeIs('map.*') ? 'active' : '' }}" href="{{ route('map.index') }}">Peta Situs</a>
                    <a class="sans {{ request()->routeIs('quiz.*') ? 'active' : '' }}" href="{{ route('quiz.index') }}">Kuis</a>
                </div>
            </div>

            <a class="site-logo" href="{{ route('home') }}">Pahlawan Sulsel</a>

            <div class="rw">
                <div class="hidden lg:flex site-nav-links">
                    <a class="sans {{ request()->routeIs('tp2gd.*') ? 'active' : '' }}" href="{{ route('tp2gd.index') }}">TP2GD</a>
                    <a class="sans {{ request()->routeIs('contributions.*') ? 'active' : '' }}" href="{{ route('contributions.create') }}">Kontribusi</a>
                    <a class="sans {{ request()->routeIs('glossary.*') ? 'active' : '' }}" href="{{ route('glossary.index') }}">Glosarium</a>
                    <a class="sans {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Tentang</a>
                </div>
                <button id="mu" type="button" title="Musik ambien & efek suara" aria-label="Musik dan suara interaktif">♪</button>
            </div>
        </nav>

        <div
            x-show="mobileNav"
            x-transition
            @click.outside="mobileNav = false"
            class="lg:hidden fixed top-[60px] left-0 right-0 z-30 bg-[#f6f3ea] border-b border-[#d6d3c5] px-6 py-4 shadow-md"
            style="display: none;"
        >
            <div class="grid grid-cols-2 gap-3">
                <a class="sans py-1.5" href="{{ route('home') }}">Beranda</a>
                <a class="sans py-1.5" href="{{ route('heroes.index') }}">Direktori Pahlawan</a>
                <a class="sans py-1.5" href="{{ route('map.index') }}">Peta Makam & Situs</a>
                <a class="sans py-1.5" href="{{ route('quiz.index') }}">Kuis Interaktif</a>
                <a class="sans py-1.5" href="{{ route('tp2gd.index') }}">Portal TP2GD</a>
                <a class="sans py-1.5" href="{{ route('contributions.create') }}">Kontribusi Arsip</a>
                <a class="sans py-1.5" href="{{ route('glossary.index') }}">Glosarium Daerah</a>
                <a class="sans py-1.5" href="{{ route('about') }}">Tentang Portal</a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>
