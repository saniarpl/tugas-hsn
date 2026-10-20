<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - WANUWIN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        .admin-bg {
            background-color: #eef4f1;
            background-image:
                radial-gradient(600px circle at 15% 0%, rgba(16,185,129,.10), transparent 60%),
                radial-gradient(500px circle at 95% 10%, rgba(251,191,36,.12), transparent 60%);
        }
        .side-link { position: relative; transition: all .25s cubic-bezier(.22,1,.36,1); }
        .side-link:hover { transform: translateX(3px); }
        .side-link.is-active {
            background: linear-gradient(135deg, #047857, #059669);
            color: #fff !important;
            box-shadow: 0 10px 24px -8px rgba(4,120,87,.6), inset 0 1px 0 rgba(255,255,255,.25);
        }
        .side-link.is-active svg { color: #fde68a; }
        @keyframes riseIn { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
        .rise { animation: riseIn .6s cubic-bezier(.22,1,.36,1) backwards; }
        .rise-1 { animation-delay: .05s } .rise-2 { animation-delay: .12s } .rise-3 { animation-delay: .19s }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 99px; }
        .main-scroll::-webkit-scrollbar { width: 8px; height: 8px; }
        .main-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
    </style>
</head>
<body class="admin-bg text-slate-800 antialiased min-h-screen" x-data="{ sidebarOpen: false }">

<div class="min-h-screen lg:flex lg:gap-5 lg:p-5">

    <!-- Overlay mobile -->
    <div x-cloak x-show="sidebarOpen" @click="sidebarOpen = false"
         x-transition.opacity
         class="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-sm lg:hidden"></div>

    <!-- Sidebar Admin -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-[110%]'"
           class="fixed lg:sticky top-0 z-50 h-screen w-[270px] shrink-0 flex flex-col transition-transform duration-500 ease-[cubic-bezier(.22,1,.36,1)] lg:translate-x-0 lg:h-[calc(100vh-2.5rem)] lg:rounded-3xl overflow-hidden bg-[#06281d] text-slate-300 border border-white/10 shadow-2xl shadow-emerald-950/40">
        <!-- Dekorasi -->
        <div class="absolute -top-24 -right-24 w-64 h-64 rounded-full bg-emerald-500/20 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-28 -left-20 w-64 h-64 rounded-full bg-amber-400/15 blur-3xl pointer-events-none"></div>

        <div class="relative p-5 border-b border-white/10 flex items-center justify-between gap-3">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                <div class="relative w-11 h-11 shrink-0">
                    <div class="absolute -inset-[2px] rounded-2xl bg-gradient-to-br from-amber-300 via-emerald-400 to-amber-300"></div>
                    <div class="absolute inset-0 rounded-[14px] bg-gradient-to-br from-[#0B7A54] to-[#04301F] flex items-center justify-center font-black text-white text-sm tracking-tighter shadow-inner group-hover:scale-105 transition">NU</div>
                </div>
                <div>
                    <span class="font-extrabold text-white text-lg tracking-tight block leading-none">WANUWIN</span>
                    <span class="inline-flex items-center gap-1.5 text-[9px] text-amber-300 font-bold uppercase tracking-widest mt-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Panel Admin
                    </span>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden w-9 h-9 grid place-items-center rounded-xl bg-white/10 hover:bg-white/20 text-white transition" aria-label="Tutup menu">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <nav class="relative p-4 space-y-1.5 text-xs font-bold flex-grow overflow-y-auto custom-scrollbar">
            <p class="px-4 pt-1 pb-2 text-[10px] font-extrabold uppercase tracking-[.2em] text-slate-500">Menu Utama</p>

            <a href="{{ route('admin.dashboard') }}" class="side-link flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                <svg class="w-[18px] h-[18px] text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.carousels.index') }}" class="side-link flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.carousels.*') ? 'is-active' : '' }}">
                <svg class="w-[18px] h-[18px] text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>Banner Carousel</span>
            </a>

            <a href="{{ route('admin.news.index') }}" class="side-link flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.news.*') ? 'is-active' : '' }}">
                <svg class="w-[18px] h-[18px] text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                <span>Warta &amp; Berita</span>
            </a>

            <a href="{{ route('admin.activities.index') }}" class="side-link flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.activities.*') ? 'is-active' : '' }}">
                <svg class="w-[18px] h-[18px] text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>Agenda Kegiatan</span>
            </a>

            @if(Route::has('admin.galleries.index'))
                <a href="{{ route('admin.galleries.index') }}" class="side-link flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.galleries.*') ? 'is-active' : '' }}">
                    <svg class="w-[18px] h-[18px] text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Galeri Foto</span>
                </a>
            @endif

            <a href="{{ route('admin.committees.index') }}" class="side-link flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.committees.*') ? 'is-active' : '' }}">
                <svg class="w-[18px] h-[18px] text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span>Pengurus &amp; Banom</span>
            </a>

            <p class="px-4 pt-5 pb-2 text-[10px] font-extrabold uppercase tracking-[.2em] text-slate-500">Data &amp; Layanan</p>

            @if(Route::has('admin.members.index'))
                <a href="{{ route('admin.members.index') }}" class="side-link flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.members.*') ? 'is-active' : '' }}">
                    <svg class="w-[18px] h-[18px] text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/></svg>
                    <span>Data Warga / Anggota</span>
                </a>
            @endif

            @if(Route::has('admin.donations.index'))
                <a href="{{ route('admin.donations.index') }}" class="side-link flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.donations.*') ? 'is-active' : '' }}">
                    <svg class="w-[18px] h-[18px] text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Data Infaq Masjid</span>
                </a>
            @endif

            @if(Route::has('admin.feedbacks.index'))
                <a href="{{ route('admin.feedbacks.index') }}" class="side-link flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.feedbacks.*') ? 'is-active' : '' }}">
                    <svg class="w-[18px] h-[18px] text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    <span>Saran &amp; Masukan</span>
                </a>
            @endif

            <div class="pt-4 mt-4 border-t border-white/10 space-y-2">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/10 text-emerald-300 hover:bg-white/15 hover:text-white transition">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Lihat Website</span>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-red-300 bg-red-500/10 border border-red-500/20 hover:bg-red-500/20 hover:text-red-200 transition text-left">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Keluar / Logout</span>
                    </button>
                </form>
            </div>
        </nav>

        <div class="relative p-4">
            <div class="rounded-2xl bg-gradient-to-br from-emerald-600 to-emerald-800 p-4 text-white overflow-hidden relative">
                <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-amber-400/30 blur-xl"></div>
                <p class="text-[11px] font-extrabold uppercase tracking-widest text-emerald-100">NU Windunegara</p>
                <p class="text-xs font-medium mt-1 text-emerald-50/90 leading-relaxed">Kelola portal dengan amanah &amp; istiqomah.</p>
            </div>
        </div>
    </aside>

    <!-- Kolom utama -->
    <div class="flex-1 min-w-0 flex flex-col gap-5">

        <!-- Topbar -->
        <header class="rise sticky top-3 sm:top-5 z-30 mx-3 sm:mx-0 mt-3 lg:mt-0 rounded-3xl bg-white/80 backdrop-blur-xl border border-white shadow-lg shadow-slate-900/5 px-4 sm:px-6 py-3.5 flex items-center gap-3">
            <button @click="sidebarOpen = true" class="lg:hidden w-10 h-10 grid place-items-center rounded-2xl bg-slate-900 text-white hover:bg-emerald-700 transition" aria-label="Buka menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div class="min-w-0">
                <p class="text-[10px] font-extrabold uppercase tracking-[.2em] text-emerald-700">WANUWIN &bull; Panel Admin</p>
                <h2 class="text-sm sm:text-base font-extrabold text-slate-800 truncate">{{ now()->translatedFormat('l, d F Y') }}</h2>
            </div>
            <div class="ml-auto flex items-center gap-2 sm:gap-3">
                <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-2 text-xs font-bold px-4 py-2.5 rounded-2xl bg-slate-900 text-white hover:bg-emerald-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Pratinjau Web
                </a>
                @auth
                <div class="flex items-center gap-2.5 pl-1 sm:pl-3 sm:border-l border-slate-200">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-emerald-600 to-emerald-900 text-white grid place-items-center font-black text-sm shadow-md">
                        {{ strtoupper(substr(auth()->user()->name ?? auth()->user()->email ?? 'A', 0, 1)) }}
                    </div>
                    <div class="hidden md:block leading-tight">
                        <p class="text-xs font-extrabold text-slate-800 max-w-[140px] truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                        <p class="text-[10px] font-medium text-slate-500 max-w-[140px] truncate">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                </div>
                @endauth
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow px-3 sm:px-0 pb-8 min-w-0">
            <div x-data="{ show: true }" x-cloak x-show="show" x-transition>
                @if(session('success'))
                    <div class="rise mb-5 flex items-start gap-3 p-4 bg-white border border-emerald-200 text-emerald-900 rounded-3xl text-xs font-bold shadow-lg shadow-emerald-900/5">
                        <span class="w-8 h-8 shrink-0 grid place-items-center rounded-2xl bg-emerald-600 text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <span class="pt-1.5 leading-relaxed">{{ session('success') }}</span>
                        <button @click="show = false" class="ml-auto w-7 h-7 grid place-items-center rounded-lg hover:bg-emerald-50 text-emerald-700" aria-label="Tutup notifikasi">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="rise mb-5 flex items-start gap-3 p-4 bg-white border border-red-200 text-red-800 rounded-3xl text-xs font-bold shadow-lg shadow-red-900/5" role="alert">
                        <span class="w-8 h-8 shrink-0 grid place-items-center rounded-2xl bg-red-500 text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                        </span>
                        <ul class="pt-1.5 leading-relaxed list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button @click="show = false" class="ml-auto w-7 h-7 grid place-items-center rounded-lg hover:bg-red-50 text-red-600 shrink-0" aria-label="Tutup notifikasi">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif
            </div>

            @yield('content')

            <p class="mt-8 text-center text-[10px] font-semibold text-slate-400">&copy; {{ date('Y') }} Ranting NU Windunegara &bull; Panel Admin WANUWIN</p>
        </main>
    </div>
</div>

</body>
</html>
