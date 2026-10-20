<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'WANUWIN - Portal Resmi NU Desa Windunegara')</title>
    <meta name="description" content="@yield('meta_description', 'Portal Resmi Informasi & Warta Kegiatan Ranting Nahdlatul Ulama Desa Windunegara: berita, agenda, galeri, infaq masjid, dan banom.')}">
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
    <script>
        /* State navbar (didefinisikan sebelum Alpine berjalan) */
        function navState() {
            return {
                mobileMenuOpen: false, scrolled: false, navHidden: false, lastY: 0,
                onScroll: function () {
                    var y = window.scrollY;
                    this.scrolled = y > 20;
                    if (this.mobileMenuOpen || y <= 240 || y < this.lastY - 6) this.navHidden = false;
                    else if (y > this.lastY + 6) this.navHidden = true;
                    this.lastY = y;
                }
            };
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        @property --ang { syntax: '<angle>'; initial-value: 0deg; inherits: false; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8faf9; }
        [x-cloak] { display: none !important; }
        @keyframes spin { to { --ang: 360deg; } }
        @keyframes rot { to { transform: rotate(360deg); } }
        @keyframes lineMove { from { background-position: 0% 0; } to { background-position: 200% 0; } }

        /* Progress scroll sekarang ada di dalam navbar */
        #scrollbar-fx { display: none !important; }

        /* ================= NAVBAR (hanya tampilan) ================= */
        @keyframes navDrop { from { transform: translateY(-100%); opacity: 0; } to { transform: none; opacity: 1; } }
        .nav-drop { animation: navDrop .9s cubic-bezier(.22,1,.36,1) backwards; }
        @keyframes navIn { from { opacity: 0; transform: translateY(-14px); filter: blur(4px); } to { opacity: 1; transform: none; filter: none; } }
        .nav-item { animation: navIn .7s cubic-bezier(.22,1,.36,1) backwards; animation-delay: calc(var(--i, 0) * 70ms + 250ms); }
        @keyframes navShift { 0%,100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
        .nav-bg { background-size: 200% 200%; animation: navShift 14s ease infinite; }

        /* Sorotan cahaya yang mengikuti kursor di navbar */
        .nav-spot { position: absolute; inset: 0; border-radius: 1.25rem; pointer-events: none; opacity: 0; transition: opacity .5s;
                    background: radial-gradient(380px circle at var(--nx, 50%) 50%, rgba(232,184,75,.14), transparent 70%); }
        #main-nav:hover .nav-spot { opacity: 1; }
        #main-nav { overflow: visible; }
        .nav-bg, .nav-glass { border-radius: 1.25rem; }

        /* Progress scroll di garis bawah navbar */
        .nav-progress { background: linear-gradient(90deg, #10b981, #fbbf24); transform: scaleX(0); transform-origin: left; box-shadow: 0 0 14px rgba(251,191,36,.75); }

        /* ---------- Logo baru: monogram squircle ---------- */
        .logo-ring { background: conic-gradient(from var(--ang), #fbbf24, #34d399 30%, transparent 55%, #fbbf24); animation: spin 6s linear infinite; }
        .group:hover .logo-ring { animation-duration: 1.4s; }
        .logo-face { background: linear-gradient(145deg, #0B7A54, #04301F 75%); box-shadow: inset 0 1px 0 rgba(255,255,255,.35), inset 0 -8px 16px rgba(0,0,0,.25);
                     transition: transform .55s cubic-bezier(.34,1.56,.64,1); }
        .group:hover .logo-face { transform: rotate(-6deg) scale(1.07); }
        .logo-text { background: linear-gradient(180deg, #ffffff, #fde68a); -webkit-background-clip: text; background-clip: text; color: transparent; display: flex; }
        .logo-text > span { display: inline-block; transition: transform .45s cubic-bezier(.34,1.56,.64,1); transition-delay: calc(var(--i) * 50ms); }
        .group:hover .logo-text > span { transform: translateY(-3px); }
        .logo-gloss { position: absolute; top: 0; left: -80%; width: 50%; height: 100%; transform: skewX(-20deg);
                      background: linear-gradient(90deg, transparent, rgba(255,255,255,.55), transparent); animation: logoShine 5s ease-in-out infinite; }
        @keyframes logoShine { 0%,70% { left: -80%; } 100% { left: 160%; } }
        .logo-star { animation: rot 14s linear infinite; filter: drop-shadow(0 0 4px rgba(251,191,36,.8)); transition: transform .4s; }
        .group:hover .logo-star { scale: 1.35; }

        /* Tulisan WANUWIN: huruf masuk bergantian, melompat saat hover */
        @keyframes wmIn { from { opacity: 0; transform: translateY(70%); filter: blur(4px); } to { opacity: 1; transform: none; filter: none; } }
        .wm-l { display: inline-block; animation: wmIn .8s cubic-bezier(.22,1,.36,1) backwards; animation-delay: calc(var(--i) * 60ms + 450ms);
                transition: transform .4s cubic-bezier(.34,1.56,.64,1), color .3s; transition-delay: calc(var(--i) * 30ms); }
        .group:hover .wm-l { transform: translateY(-3px); color: #fde68a; }

        /* Efek teks menu berputar (roll) */
        .roll { display: inline-block; overflow: hidden; height: 1.4em; line-height: 1.4em; vertical-align: middle; }
        .roll > span { display: block; transition: transform .5s cubic-bezier(.22,1,.36,1); }
        .roll > span::after { content: attr(data-t); display: block; color: #fde68a; }
        @media (hover: hover) { .nav-link:hover .roll > span { transform: translateY(-1.4em); } }

        /* Pill penunjuk yang bergeser */
        #nav-pill { position: absolute; top: 0; left: 0; z-index: 0; margin: 0 !important; border-radius: .75rem; opacity: 0; pointer-events: none;
                    background: linear-gradient(135deg, rgba(16,185,129,.35), rgba(251,191,36,.18)); border: 1px solid rgba(110,231,183,.25);
                    box-shadow: 0 6px 20px -6px rgba(16,185,129,.5);
                    transition: transform .45s cubic-bezier(.22,1,.36,1), width .45s cubic-bezier(.22,1,.36,1), height .45s cubic-bezier(.22,1,.36,1), opacity .3s; }
        .nav-link { position: relative; z-index: 1; }
        .nav-link.is-active { color: #fff; }

        /* Hamburger */
        .bar { position: absolute; left: 0; height: 2px; width: 20px; border-radius: 2px; background: currentColor; transition: all .4s cubic-bezier(.22,1,.36,1); }

        /* Panel menu HP */
        @keyframes menuIn { from { opacity: 0; transform: translateY(-16px) scale(.98); } to { opacity: 1; transform: none; } }
        @media (max-width: 1023px) { .menu-panel { animation: menuIn .5s cubic-bezier(.22,1,.36,1); } }

        /* Dropdown Banom */
        .dd-enter { transition: opacity .25s ease, transform .55s cubic-bezier(.34,1.56,.64,1); }
        .dd-leave { transition: opacity .18s ease, transform .18s ease; }
        @media (min-width: 1024px) {
            .dd-panel::before { content: ""; position: absolute; top: -6px; left: 26px; width: 12px; height: 12px; background: #fff; transform: rotate(45deg); border-radius: 2px; }
        }
        @keyframes ddItem { from { opacity: 0; transform: translateX(-18px); } to { opacity: 1; transform: none; } }
        .dd-item { position: relative; animation: ddItem .5s cubic-bezier(.22,1,.36,1) backwards; animation-delay: calc(var(--i, 0) * 60ms + 80ms);
                   transition: transform .3s cubic-bezier(.22,1,.36,1), background-color .3s, padding .3s; }
        .dd-item::before { content: ""; position: absolute; left: 6px; top: 50%; width: 3px; height: 0; border-radius: 3px; background: #10b981; transform: translateY(-50%); transition: height .3s cubic-bezier(.34,1.56,.64,1); }
        .dd-item:hover { transform: translateX(4px); padding-left: 1.4rem; }
        .dd-item:hover::before { height: 55%; }

        /* Tombol admin: border cahaya berputar + kilau */
        .btn-orbit { --bg: #047857; --bgh: #059669; position: relative; overflow: hidden; border: 1.5px solid transparent; animation: spin 4s linear infinite;
                     background: linear-gradient(var(--bg), var(--bg)) padding-box, conic-gradient(from var(--ang), rgba(255,255,255,.12) 0 45%, #fbbf24 70%, #34d399 85%, rgba(255,255,255,.12)) border-box;
                     transition: transform .3s, box-shadow .3s; }
        .btn-orbit:hover { background: linear-gradient(var(--bgh), var(--bgh)) padding-box, conic-gradient(from var(--ang), rgba(255,255,255,.12) 0 45%, #fbbf24 70%, #34d399 85%, rgba(255,255,255,.12)) border-box;
                           box-shadow: 0 12px 28px -8px rgba(16,185,129,.7); }
        .btn-orbit.amber { --bg: #f59e0b; --bgh: #fbbf24; }
        .btn-orbit::after { content: ""; position: absolute; top: 0; left: -70%; width: 40%; height: 100%; transform: skewX(-20deg);
                            background: linear-gradient(90deg, transparent, rgba(255,255,255,.4), transparent); transition: left .7s; }
        .btn-orbit:hover::after { left: 140%; }
        [data-magnetic] { transition: translate .25s ease-out, box-shadow .3s; }

        /* ================= FOOTER ================= */
        .lfx .f-rev { opacity: 0; transform: translateY(30px); filter: blur(6px); transition: all .9s cubic-bezier(.22,1,.36,1); transition-delay: var(--d, 0ms); }
        .lfx .f-rev.in { opacity: 1; transform: none; filter: none; }
        @keyframes textShine { to { background-position: 200% center; } }
        .f-title { background: linear-gradient(90deg, #fff 0%, #fbbf24 25%, #34d399 50%, #fff 75%); background-size: 200% auto;
                   -webkit-background-clip: text; background-clip: text; color: transparent; animation: textShine 6s linear infinite; }
        .f-link { position: relative; display: inline-block; transition: color .3s, transform .3s; }
        .f-link::after { content: ""; position: absolute; left: 0; bottom: -3px; height: 2px; width: 100%; background: linear-gradient(90deg, #34d399, #fbbf24);
                         transform: scaleX(0); transform-origin: right; transition: transform .4s cubic-bezier(.22,1,.36,1); }
        .f-link:hover { transform: translateY(-2px); }
        .f-link:hover::after { transform: scaleX(1); transform-origin: left; }
        .f-aurora { position: absolute; border-radius: 9999px; filter: blur(90px); pointer-events: none; animation: fDrift 10s ease-in-out infinite; }
        @keyframes fDrift { 0%,100% { transform: translate(0,0); } 50% { transform: translate(40px,-20px); } }
        .f-top { position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: linear-gradient(90deg, #f59e0b, #fde68a, #f59e0b); background-size: 200% 100%; animation: lineMove 5s linear infinite; }

        @media (prefers-reduced-motion: reduce) {
            .nav-drop, .nav-item, .nav-bg, .logo-ring, .logo-gloss, .logo-star, .wm-l, .dd-item, .menu-panel, .btn-orbit, .f-title, .f-aurora, .f-top { animation: none !important; }
            .lfx .f-rev { opacity: 1; transform: none; filter: none; transition: none; }
            #nav-pill, .dd-item, .bar, .roll > span, .logo-face { transition: none; }
        }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen flex flex-col relative selection:bg-emerald-500 selection:text-white">

    <!-- Navigation Bar Mengambang -->
    <nav id="main-nav"
         class="nav-drop sticky top-3 sm:top-4 z-[100] mx-auto w-[calc(100%-1.5rem)] sm:w-[calc(100%-2.5rem)] max-w-6xl rounded-[1.25rem] border transition-all duration-500"
         :class="[scrolled ? 'border-amber-200/25 shadow-2xl shadow-black/40 backdrop-blur-xl' : 'border-white/15 shadow-xl shadow-black/20 backdrop-blur-xl', navHidden ? '-translate-y-[160%] opacity-0 pointer-events-none' : 'translate-y-0 opacity-100']"
         x-data="navState()"
         @scroll.window.passive="onScroll()"
         @focusin="navHidden = false">

        <!-- Lapisan latar: gradasi (atas) -> kaca (saat scroll) -->
        <div class="nav-bg absolute inset-0 bg-gradient-to-r from-[#052E21] via-[#0A4D33] to-[#071A13] transition-opacity duration-500" :class="scrolled ? 'opacity-0' : 'opacity-100'"></div>
        <div class="nav-glass absolute inset-0 bg-[#052A1E]/85 transition-opacity duration-500" :class="scrolled ? 'opacity-100' : 'opacity-0'"></div>
        <div class="nav-spot"></div>
        <!-- Progress scroll -->
        <div class="absolute bottom-0 left-4 right-4 h-[2px] rounded-full bg-white/5 pointer-events-none overflow-hidden">
            <div id="nav-progress" class="nav-progress h-full w-full rounded-full"></div>
        </div>

        <div class="mx-auto px-4 sm:px-6 flex justify-between items-center relative z-[101] transition-all duration-500" :class="scrolled ? 'h-16' : 'h-20'">

            <!-- Logo Modern -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group origin-left transition-transform duration-500" :class="scrolled ? 'scale-90' : ''" aria-label="WANUWIN Windunegara - Beranda">
                <span class="relative block w-11 h-11 shrink-0">
                    <span class="logo-ring absolute -inset-[2px] rounded-[15px]"></span>
                    <span class="logo-face absolute inset-0 rounded-[13px] flex items-center justify-center overflow-hidden">
                        <span class="logo-gloss"></span>
                        <span class="logo-text relative z-[1] font-black text-[17px] tracking-tighter leading-none"><span style="--i:0">N</span><span style="--i:1">U</span></span>
                    </span>
                    <svg class="logo-star absolute -top-2 -right-2 w-4 h-4 text-amber-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.9 6.6 7.1.7-5.4 4.7 1.6 7L12 17.3 5.8 21l1.6-7L2 9.3l7.1-.7z"/></svg>
                </span>
                <span class="flex flex-col">
                    <span class="flex font-extrabold text-xl tracking-tight text-white leading-none" aria-hidden="true"><span class="wm-l" style="--i:0">W</span><span class="wm-l" style="--i:1">A</span><span class="wm-l" style="--i:2">N</span><span class="wm-l" style="--i:3">U</span><span class="wm-l" style="--i:4">W</span><span class="wm-l" style="--i:5">I</span><span class="wm-l" style="--i:6">N</span></span>
                    <span class="text-[9px] font-medium text-amber-300 uppercase tracking-widest mt-1 group-hover:tracking-[.35em] transition-all duration-500">Windunegara</span>
                </span>
            </a>

            <!-- Tombol Hamburger HP Elegan (animasi berubah jadi X) -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" :aria-expanded="mobileMenuOpen" class="lg:hidden flex items-center justify-center w-10 h-10 bg-white/10 hover:bg-amber-400/20 border border-white/20 text-amber-200 rounded-full transition focus:outline-none active:scale-90" aria-label="Menu">
                <span class="relative block w-5 h-4">
                    <span class="bar top-0" :class="mobileMenuOpen ? 'translate-y-[7px] rotate-45' : ''"></span>
                    <span class="bar top-[7px]" :class="mobileMenuOpen ? 'opacity-0 scale-x-0' : ''"></span>
                    <span class="bar top-[14px]" :class="mobileMenuOpen ? '-translate-y-[7px] -rotate-45' : ''"></span>
                </span>
            </button>

            <!-- Menu Desktop & Mobile -->
            <div id="nav-menu" :class="mobileMenuOpen ? 'flex' : 'hidden'" class="menu-panel lg:flex flex-col lg:flex-row absolute lg:relative top-[calc(100%+12px)] lg:top-0 left-0 right-0 lg:right-auto w-auto lg:w-auto max-lg:max-h-[calc(100vh-8rem)] max-lg:overflow-y-auto bg-[#052A1E]/95 backdrop-blur-xl lg:backdrop-blur-none lg:bg-transparent shadow-2xl lg:shadow-none rounded-2xl lg:rounded-none p-6 lg:p-0 space-y-3 lg:space-y-0 lg:space-x-1 text-xs font-bold text-[#D9EFE3] items-stretch lg:items-center z-[102] border border-white/10 lg:border-none">

                <a data-nav data-home="1" style="--i:0" href="{{ route('home') }}" @click="mobileMenuOpen = false" class="nav-item nav-link block px-4 py-3 lg:py-2 rounded-xl hover:text-white hover:bg-white/10 lg:hover:bg-transparent transition"><span class="roll"><span data-t="Beranda">Beranda</span></span></a>
                <a data-nav style="--i:1" href="{{ route('home') }}#berita" @click="mobileMenuOpen = false" class="nav-item nav-link block px-4 py-3 lg:py-2 rounded-xl hover:text-white hover:bg-white/10 lg:hover:bg-transparent transition"><span class="roll"><span data-t="Berita">Berita</span></span></a>
                <a data-nav style="--i:2" href="{{ route('home') }}#kegiatan" @click="mobileMenuOpen = false" class="nav-item nav-link block px-4 py-3 lg:py-2 rounded-xl hover:text-white hover:bg-white/10 lg:hover:bg-transparent transition"><span class="roll"><span data-t="Kegiatan">Kegiatan</span></span></a>
                <a data-nav style="--i:3" href="{{ route('home') }}#galeri" @click="mobileMenuOpen = false" class="nav-item nav-link block px-4 py-3 lg:py-2 rounded-xl hover:text-white hover:bg-white/10 lg:hover:bg-transparent transition"><span class="roll"><span data-t="Galeri">Galeri</span></span></a>
                <a data-nav style="--i:4" href="{{ route('home') }}#infaq" @click="mobileMenuOpen = false" class="nav-item nav-link block px-4 py-3 lg:py-2 rounded-xl hover:text-white hover:bg-white/10 lg:hover:bg-transparent transition"><span class="roll"><span data-t="Infaq Masjid">Infaq Masjid</span></span></a>
                <a data-nav style="--i:5" href="{{ route('home') }}#saran" @click="mobileMenuOpen = false" class="nav-item nav-link block px-4 py-3 lg:py-2 rounded-xl hover:text-white hover:bg-white/10 lg:hover:bg-transparent transition"><span class="roll"><span data-t="Saran &amp; Kritik">Saran & Kritik</span></span></a>

                <!-- Dropdown Banom -->
                <div style="--i:6" class="nav-item relative pt-2 lg:pt-0 border-t border-white/10 lg:border-none" x-data="{ banomOpen: false }" @click.away="banomOpen = false" @keydown.escape.window="banomOpen = false">
                    <button data-nav @click="banomOpen = !banomOpen" :aria-expanded="banomOpen" class="nav-link flex items-center justify-between w-full lg:w-auto px-4 lg:px-3 py-3 lg:py-2 rounded-xl hover:text-white hover:bg-white/10 lg:hover:bg-transparent transition focus:outline-none">
                        <span class="roll"><span data-t="Banom NU">Banom NU</span></span>
                        <svg class="w-4 h-4 transform transition duration-500" :class="banomOpen ? 'rotate-180 text-amber-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <!-- Isi Dropdown Banom (Warna Terang Agar Terbaca) -->
                    <div x-cloak x-show="banomOpen"
                         x-transition:enter="dd-enter" x-transition:enter-start="opacity-0 scale-90 -translate-y-3" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="dd-leave" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                         class="dd-panel origin-top-left lg:absolute lg:top-full lg:left-0 lg:mt-3 lg:w-48 bg-white lg:shadow-2xl lg:shadow-emerald-950/30 lg:border border-slate-100 rounded-2xl p-2 flex flex-col gap-1 z-[110]">
                        <a style="--i:0" href="{{ route('organization.detail', 'ipnu') }}" @click="mobileMenuOpen = false" class="dd-item px-4 py-2.5 rounded-xl hover:bg-emerald-50 text-emerald-900">IPNU</a>
                        <a style="--i:1" href="{{ route('organization.detail', 'ippnu') }}" @click="mobileMenuOpen = false" class="dd-item px-4 py-2.5 rounded-xl hover:bg-emerald-50 text-emerald-900">IPPNU</a>
                        <a style="--i:2" href="{{ route('organization.detail', 'fatayat') }}" @click="mobileMenuOpen = false" class="dd-item px-4 py-2.5 rounded-xl hover:bg-emerald-50 text-emerald-900">Fatayat</a>
                        <a style="--i:3" href="{{ route('organization.detail', 'muslimat') }}" @click="mobileMenuOpen = false" class="dd-item px-4 py-2.5 rounded-xl hover:bg-emerald-50 text-emerald-900">Muslimat</a>
                        <a style="--i:4" href="{{ route('organization.detail', 'banser') }}" @click="mobileMenuOpen = false" class="dd-item px-4 py-2.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-200/50">Banser</a>
                    </div>
                </div>

                <!-- Tombol Akses Admin -->
                <div style="--i:7" class="nav-item pt-4 lg:pt-0 lg:ml-2 border-t border-white/10 lg:border-none w-full lg:w-auto">
                    @auth
                        <a data-magnetic href="{{ route('admin.dashboard') }}" class="btn-orbit amber block text-center text-slate-950 px-5 py-3 lg:py-2.5 rounded-xl shadow-md active:scale-95">Dashboard</a>
                    @else
                        <a data-magnetic href="{{ route('login') }}" class="btn-orbit block text-center text-white px-5 py-3 lg:py-2.5 rounded-xl shadow-md active:scale-95">Akses Admin</a>
                    @endauth
                </div>

                <!-- Pill penunjuk (desktop) -->
                <span id="nav-pill" class="hidden lg:block" aria-hidden="true"></span>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-[#04150E] text-slate-400 py-14 mt-16 border-t-4 border-[#E8B84B] relative overflow-hidden">
        <div class="f-top"></div>
        <div class="f-aurora w-72 h-72 bg-emerald-500/25 -bottom-24 -left-10"></div>
        <div class="f-aurora w-64 h-64 bg-amber-400/15 -top-20 right-10" style="animation-delay: -5s"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-10 text-left">
            <div data-f class="f-rev">
                <h3 class="f-title font-extrabold text-2xl mb-3 inline-block">WANUWIN</h3>
                <p class="text-xs max-w-xs leading-relaxed">Portal Resmi Informasi & Warta Kegiatan Ranting Nahdlatul Ulama Desa Windunegara.</p>
            </div>
            <div data-f style="--d:120ms" class="f-rev">
                <h4 class="text-white text-xs font-extrabold uppercase tracking-widest mb-4">Navigasi</h4>
                <ul class="grid grid-cols-2 gap-x-4 gap-y-2.5 text-[11px] font-bold">
                    <li><a href="{{ route('home') }}" class="f-link hover:text-emerald-400">Beranda</a></li>
                    <li><a href="{{ route('home') }}#berita" class="f-link hover:text-emerald-400">Berita</a></li>
                    <li><a href="{{ route('home') }}#kegiatan" class="f-link hover:text-emerald-400">Kegiatan</a></li>
                    <li><a href="{{ route('home') }}#galeri" class="f-link hover:text-emerald-400">Galeri</a></li>
                    <li><a href="{{ route('home') }}#infaq" class="f-link hover:text-emerald-400">Donasi</a></li>
                    <li><a href="{{ route('home') }}#saran" class="f-link hover:text-emerald-400">Kirim Saran</a></li>
                </ul>
            </div>
            <div data-f style="--d:240ms" class="f-rev">
                <h4 class="text-white text-xs font-extrabold uppercase tracking-widest mb-4">Kontak Kami</h4>
                <ul class="space-y-2.5 text-[11px] font-medium leading-relaxed">
                    <li>08123456789</li>
                    <li>Jl. Raya Windunegara No. 123, Desa Windunegara, Kecamatan Wangon, Kabupaten Banyumas.</li>
                </ul>
            </div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-6">
            <p data-f style="--d:360ms" class="f-rev text-[10px] text-slate-600 border-t border-white/10 mt-10 pt-6 text-center">&copy; {{ date('Y') }} Ranting NU Windunegara. All rights reserved.</p>
        </div>
    </footer>

    {{-- Mesin animasi layout (murni visual: tidak menyentuh menu, route, atau login) --}}
    <script>
    (function () {
        var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
        document.documentElement.classList.add('lfx');

        /* Footer muncul saat terlihat (berulang naik/turun) */
        var fs = document.querySelectorAll('[data-f]');
        if ('IntersectionObserver' in window) {
            var fio = new IntersectionObserver(function (es) {
                es.forEach(function (e) { e.target.classList.toggle('in', e.isIntersecting); });
            }, { threshold: 0.2 });
            fs.forEach(function (el) { fio.observe(el); });
        } else { fs.forEach(function (el) { el.classList.add('in'); }); }

        /* Progress scroll di navbar */
        var prog = document.getElementById('nav-progress'), pTick = false;
        function progress() {
            var h = document.documentElement.scrollHeight - window.innerHeight;
            if (prog) prog.style.transform = 'scaleX(' + (h > 0 ? Math.min(window.scrollY / h, 1) : 0) + ')';
            pTick = false;
        }
        window.addEventListener('scroll', function () { if (!pTick) { pTick = true; requestAnimationFrame(progress); } }, { passive: true });
        progress();

        /* Pill navbar + scroll-spy */
        var menu = document.getElementById('nav-menu'), pill = document.getElementById('nav-pill');
        if (!menu || !pill) return;
        var links = Array.prototype.slice.call(menu.querySelectorAll('[data-nav]'));
        var homeLink = menu.querySelector('[data-home]');
        var map = {}, active = null, hovering = false;
        links.forEach(function (l) {
            var h = l.getAttribute('href') || '';
            if (h.indexOf('#') > -1) map[h.split('#')[1]] = l;
        });
        var onHome = homeLink && homeLink.pathname === location.pathname;

        function place(el) {
            if (!el || window.innerWidth < 1024) { pill.style.opacity = 0; return; }
            var c = menu.getBoundingClientRect(), r = el.getBoundingClientRect();
            if (pill.style.opacity !== '1') { pill.style.transition = 'none'; }
            pill.style.width = r.width + 'px'; pill.style.height = r.height + 'px';
            pill.style.transform = 'translate(' + (r.left - c.left) + 'px,' + (r.top - c.top) + 'px)';
            void pill.offsetWidth; pill.style.transition = ''; pill.style.opacity = 1;
        }
        function setActive(el) {
            if (el === active) return;
            active = el;
            links.forEach(function (l) { l.classList.toggle('is-active', l === el); });
            if (!hovering) place(active);
        }
        links.forEach(function (l) {
            l.addEventListener('pointerenter', function (e) { if (e.pointerType && e.pointerType !== 'mouse') return; hovering = true; place(l); });
            l.addEventListener('focus', function () { place(l); });
        });
        menu.addEventListener('pointerleave', function () { hovering = false; place(active); });
        window.addEventListener('resize', function () { place(active); });

        var spyTick = false;
        function spy() {
            var cur = null;
            ['berita', 'infaq', 'kegiatan', 'galeri', 'saran'].forEach(function (id) {
                var el = document.getElementById(id);
                if (!el || !map[id]) return;
                var r = el.getBoundingClientRect();
                if (r.top <= window.innerHeight * 0.35 && r.bottom > window.innerHeight * 0.2) cur = map[id];
            });
            setActive(cur || (onHome ? homeLink : null));
            spyTick = false;
        }
        window.addEventListener('scroll', function () { if (!spyTick) { spyTick = true; requestAnimationFrame(spy); } }, { passive: true });
        setTimeout(spy, 900); /* tunggu animasi masuk navbar selesai */

        if (reduce || !fine) return;

        /* Cahaya navbar mengikuti kursor */
        var nav = document.getElementById('main-nav');
        nav.addEventListener('pointermove', function (e) {
            nav.style.setProperty('--nx', (e.clientX - nav.getBoundingClientRect().left) + 'px');
        });

        /* Tombol magnetis */
        document.querySelectorAll('[data-magnetic]').forEach(function (b) {
            b.addEventListener('pointermove', function (e) {
                var r = b.getBoundingClientRect();
                b.style.translate = ((e.clientX - (r.left + r.width / 2)) * 0.2) + 'px ' + ((e.clientY - (r.top + r.height / 2)) * 0.3) + 'px';
            });
            b.addEventListener('pointerleave', function () { b.style.translate = ''; });
        });
    })();
    </script>
</body>
</html>