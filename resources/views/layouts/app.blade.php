<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'WANUWIN - Portal Resmi NU Desa Windunegara')</title>
    <meta name="description" content="@yield('meta_description', 'Portal Resmi Informasi & Warta Kegiatan Ranting Nahdlatul Ulama Desa Windunegara: berita, agenda, galeri, infaq masjid, dan banom.')">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="WANUWIN">
    <meta property="og:title" content="@yield('og_title', 'WANUWIN - Portal Resmi NU Desa Windunegara')">
    <meta property="og:description" content="@yield('og_description', 'Warta berita, agenda kegiatan, galeri, dan infaq Masjid NU Desa Windunegara.')">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset('favicon.ico'))">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'WANUWIN - Portal Resmi NU Desa Windunegara')">
    <meta name="twitter:description" content="@yield('og_description', 'Warta berita, agenda kegiatan, galeri, dan infaq Masjid NU Desa Windunegara.')">
    <meta name="twitter:image" content="@yield('og_image', asset('favicon.ico'))">
    @yield('meta')

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
        [x-cloak] { display: none !important; }
        :focus-visible { outline: 2px solid #047857; outline-offset: 2px; }
        .article-body { line-height: 1.9; }
        .article-body p { margin-bottom: 1rem; }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-700 antialiased">

    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[100] focus:rounded-md focus:bg-emerald-700 focus:px-4 focus:py-2 focus:text-sm focus:font-bold focus:text-white">
        Lewati ke konten utama
    </a>

    {{-- Bilah identitas resmi --}}
    <div class="bg-[#043D2B] text-emerald-50">
        <div class="mx-auto flex h-9 max-w-7xl items-center justify-between gap-4 px-4 text-[11px] sm:px-6">
            <p class="flex min-w-0 items-center gap-2 font-medium">
                <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-amber-400" aria-hidden="true"></span>
                <span class="truncate">Portal Resmi Ranting NU Desa Windunegara</span>
            </p>
            <div class="hidden items-center gap-4 text-emerald-100/80 sm:flex">
                <span>Kec. Wangon, Kab. Banyumas</span>
            </div>
        </div>
    </div>

    {{-- Kepala halaman --}}
    <header x-data="{ mobileOpen: false }" class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="flex h-16 items-center justify-between gap-4 sm:h-20">

                <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-3" aria-label="WANUWIN Windunegara - Beranda">
                    <span class="grid h-11 w-11 place-items-center rounded-md bg-[#065F46] text-base font-extrabold tracking-tight text-white" aria-hidden="true">NU</span>
                    <span class="flex flex-col">
                        <span class="text-lg font-extrabold leading-none tracking-tight text-slate-900">WANUWIN</span>
                        <span class="mt-1 text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-500">Ranting NU Windunegara</span>
                    </span>
                </a>

                <nav class="hidden items-center gap-0.5 lg:flex" aria-label="Navigasi utama">
                    <a href="{{ route('home') }}" class="rounded-md px-3 py-2 text-[13px] font-semibold text-slate-600 transition-colors hover:bg-emerald-50 hover:text-emerald-800">Beranda</a>
                    <a href="{{ route('home') }}#berita" class="rounded-md px-3 py-2 text-[13px] font-semibold text-slate-600 transition-colors hover:bg-emerald-50 hover:text-emerald-800">Berita</a>
                    <a href="{{ route('home') }}#kegiatan" class="rounded-md px-3 py-2 text-[13px] font-semibold text-slate-600 transition-colors hover:bg-emerald-50 hover:text-emerald-800">Kegiatan</a>
                    <a href="{{ route('home') }}#galeri" class="rounded-md px-3 py-2 text-[13px] font-semibold text-slate-600 transition-colors hover:bg-emerald-50 hover:text-emerald-800">Galeri</a>
                    <a href="{{ route('home') }}#infaq" class="rounded-md px-3 py-2 text-[13px] font-semibold text-slate-600 transition-colors hover:bg-emerald-50 hover:text-emerald-800">Infaq Masjid</a>
                    <a href="{{ route('home') }}#saran" class="rounded-md px-3 py-2 text-[13px] font-semibold text-slate-600 transition-colors hover:bg-emerald-50 hover:text-emerald-800">Saran &amp; Kritik</a>

                    <div x-data="{ open: false }" class="relative" @click.outside="open = false" @keydown.escape.window="open = false">
                        <button type="button" @click="open = !open" :aria-expanded="open" class="flex items-center gap-1.5 rounded-md px-3 py-2 text-[13px] font-semibold text-slate-600 transition-colors hover:bg-emerald-50 hover:text-emerald-800">
                            Banom NU
                            <svg class="h-3.5 w-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-cloak x-show="open" x-transition.opacity.duration.150ms
                             class="absolute left-0 top-full z-50 mt-2 w-56 rounded-lg border border-slate-200 bg-white p-2 shadow-lg">
                            <p class="px-3 pb-2 pt-1 text-[10px] font-bold uppercase tracking-widest text-slate-400">Badan Otonom</p>
                            <a href="{{ route('organization.detail', 'ipnu') }}" class="block rounded-md px-3 py-2 text-[13px] font-semibold text-slate-700 transition-colors hover:bg-emerald-50 hover:text-emerald-800">IPNU</a>
                            <a href="{{ route('organization.detail', 'ippnu') }}" class="block rounded-md px-3 py-2 text-[13px] font-semibold text-slate-700 transition-colors hover:bg-emerald-50 hover:text-emerald-800">IPPNU</a>
                            <a href="{{ route('organization.detail', 'fatayat') }}" class="block rounded-md px-3 py-2 text-[13px] font-semibold text-slate-700 transition-colors hover:bg-emerald-50 hover:text-emerald-800">Fatayat</a>
                            <a href="{{ route('organization.detail', 'muslimat') }}" class="block rounded-md px-3 py-2 text-[13px] font-semibold text-slate-700 transition-colors hover:bg-emerald-50 hover:text-emerald-800">Muslimat</a>
                            <a href="{{ route('organization.detail', 'banser') }}" class="block rounded-md px-3 py-2 text-[13px] font-semibold text-slate-700 transition-colors hover:bg-emerald-50 hover:text-emerald-800">Banser</a>
                        </div>
                    </div>
                </nav>

                <div class="hidden lg:block">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 rounded-md bg-[#065F46] px-4 py-2.5 text-xs font-bold text-white transition-colors hover:bg-[#054F3A]">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-md bg-[#065F46] px-4 py-2.5 text-xs font-bold text-white transition-colors hover:bg-[#054F3A]">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Akses Admin
                        </a>
                    @endauth
                </div>

                <button type="button" @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen" aria-controls="mobile-menu"
                        class="grid h-10 w-10 place-items-center rounded-md border border-slate-200 text-slate-700 transition-colors hover:bg-slate-100 lg:hidden" aria-label="Buka menu navigasi">
                    <svg x-show="!mobileOpen" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-cloak x-show="mobileOpen" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        {{-- Menu seluler --}}
        <div id="mobile-menu" x-cloak x-show="mobileOpen" class="border-t border-slate-200 bg-white lg:hidden">
            <nav class="mx-auto max-w-7xl px-4 py-2 sm:px-6" aria-label="Navigasi seluler">
                <a href="{{ route('home') }}" @click="mobileOpen = false" class="block border-b border-slate-100 py-3 text-sm font-semibold text-slate-700">Beranda</a>
                <a href="{{ route('home') }}#berita" @click="mobileOpen = false" class="block border-b border-slate-100 py-3 text-sm font-semibold text-slate-700">Berita</a>
                <a href="{{ route('home') }}#kegiatan" @click="mobileOpen = false" class="block border-b border-slate-100 py-3 text-sm font-semibold text-slate-700">Kegiatan</a>
                <a href="{{ route('home') }}#galeri" @click="mobileOpen = false" class="block border-b border-slate-100 py-3 text-sm font-semibold text-slate-700">Galeri</a>
                <a href="{{ route('home') }}#infaq" @click="mobileOpen = false" class="block border-b border-slate-100 py-3 text-sm font-semibold text-slate-700">Infaq Masjid</a>
                <a href="{{ route('home') }}#saran" @click="mobileOpen = false" class="block border-b border-slate-100 py-3 text-sm font-semibold text-slate-700">Saran &amp; Kritik</a>

                <div x-data="{ open: false }" class="border-b border-slate-100">
                    <button type="button" @click="open = !open" :aria-expanded="open" class="flex w-full items-center justify-between py-3 text-sm font-semibold text-slate-700">
                        Banom NU
                        <svg class="h-4 w-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-cloak x-show="open" class="pb-3 pl-4">
                        <a href="{{ route('organization.detail', 'ipnu') }}" class="block py-2 text-sm text-slate-600">IPNU</a>
                        <a href="{{ route('organization.detail', 'ippnu') }}" class="block py-2 text-sm text-slate-600">IPPNU</a>
                        <a href="{{ route('organization.detail', 'fatayat') }}" class="block py-2 text-sm text-slate-600">Fatayat</a>
                        <a href="{{ route('organization.detail', 'muslimat') }}" class="block py-2 text-sm text-slate-600">Muslimat</a>
                        <a href="{{ route('organization.detail', 'banser') }}" class="block py-2 text-sm text-slate-600">Banser</a>
                    </div>
                </div>

                <div class="py-4">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="block rounded-md bg-[#065F46] px-4 py-3 text-center text-xs font-bold text-white">Dashboard Admin</a>
                    @else
                        <a href="{{ route('login') }}" class="block rounded-md bg-[#065F46] px-4 py-3 text-center text-xs font-bold text-white">Akses Admin</a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    <main id="main-content" class="flex-grow">
        @yield('content')
    </main>

    {{-- Kaki halaman --}}
    <footer class="mt-20 border-t-4 border-amber-400 bg-[#052E21] text-emerald-100/70">
        <div class="mx-auto grid max-w-7xl gap-10 px-6 py-12 md:grid-cols-12">
            <div class="md:col-span-5">
                <div class="flex items-center gap-3">
                    <span class="grid h-11 w-11 place-items-center rounded-md bg-white/10 text-base font-extrabold text-white" aria-hidden="true">NU</span>
                    <div>
                        <p class="text-lg font-extrabold leading-none text-white">WANUWIN</p>
                        <p class="mt-1 text-[10px] font-semibold uppercase tracking-[0.14em] text-amber-300">Ranting NU Windunegara</p>
                    </div>
                </div>
                <p class="mt-5 max-w-sm text-sm leading-6">Portal resmi informasi dan warta kegiatan Ranting Nahdlatul Ulama Desa Windunegara, Kecamatan Wangon, Kabupaten Banyumas.</p>
                <div class="mt-5 space-y-2 text-sm">
                    <p class="flex items-start gap-2.5">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Jl. Raya Windunegara No. 123, Desa Windunegara, Kec. Wangon, Kab. Banyumas</span>
                    </p>
                    <p class="flex items-center gap-2.5">
                        <svg class="h-4 w-4 shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <a href="tel:08123456789" class="transition-colors hover:text-white">0812-3456-789</a>
                    </p>
                </div>
            </div>

            <div class="md:col-span-3">
                <h2 class="text-xs font-bold uppercase tracking-[0.16em] text-white">Navigasi</h2>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a href="{{ route('home') }}" class="transition-colors hover:text-white">Beranda</a></li>
                    <li><a href="{{ route('home') }}#berita" class="transition-colors hover:text-white">Warta Berita</a></li>
                    <li><a href="{{ route('home') }}#kegiatan" class="transition-colors hover:text-white">Agenda Kegiatan</a></li>
                    <li><a href="{{ route('home') }}#galeri" class="transition-colors hover:text-white">Galeri Foto</a></li>
                    <li><a href="{{ route('home') }}#infaq" class="transition-colors hover:text-white">Infaq Masjid</a></li>
                    <li><a href="{{ route('home') }}#saran" class="transition-colors hover:text-white">Saran &amp; Kritik</a></li>
                </ul>
            </div>

            <div class="md:col-span-4">
                <h2 class="text-xs font-bold uppercase tracking-[0.16em] text-white">Badan Otonom</h2>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a href="{{ route('organization.detail', 'ipnu') }}" class="transition-colors hover:text-white">IPNU Windunegara</a></li>
                    <li><a href="{{ route('organization.detail', 'ippnu') }}" class="transition-colors hover:text-white">IPPNU Windunegara</a></li>
                    <li><a href="{{ route('organization.detail', 'fatayat') }}" class="transition-colors hover:text-white">Fatayat NU</a></li>
                    <li><a href="{{ route('organization.detail', 'muslimat') }}" class="transition-colors hover:text-white">Muslimat NU</a></li>
                    <li><a href="{{ route('organization.detail', 'banser') }}" class="transition-colors hover:text-white">Banser</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10">
            <div class="mx-auto flex max-w-7xl flex-col justify-between gap-2 px-6 py-5 text-xs sm:flex-row">
                <p>&copy; {{ date('Y') }} Ranting NU Desa Windunegara. Seluruh hak cipta dilindungi.</p>
                <p class="text-emerald-100/50">Dikelola secara resmi melalui portal WANUWIN.</p>
            </div>
        </div>
    </footer>

</body>
</html>
