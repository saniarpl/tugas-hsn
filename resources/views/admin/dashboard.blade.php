@extends('layouts.admin')
@section('content')
<div class="space-y-6">

    {{-- Hero sambutan --}}
    <div class="rise relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#04301F] via-[#0A4D33] to-[#047857] text-white p-6 sm:p-8 shadow-2xl shadow-emerald-950/30 border border-white/10">
        <div class="absolute -top-20 -right-16 w-72 h-72 rounded-full bg-amber-400/25 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 left-1/4 w-72 h-72 rounded-full bg-emerald-400/20 blur-3xl pointer-events-none"></div>
        <div class="absolute inset-0 opacity-[.12] pointer-events-none" style="background-image: radial-gradient(rgba(255,255,255,.7) 1px, transparent 1px); background-size: 22px 22px;"></div>
        <div class="relative flex flex-col lg:flex-row lg:items-center gap-6">
            <div class="min-w-0">
                <p class="inline-flex items-center gap-2 text-[10px] font-extrabold uppercase tracking-[.22em] bg-white/10 border border-white/15 rounded-full px-3.5 py-1.5 text-amber-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                    Assalamu'alaikum &bull; {{ now()->translatedFormat('d F Y') }}
                </p>
                <h1 class="mt-3 text-2xl sm:text-3xl font-black tracking-tight leading-tight">Dashboard Admin <span class="text-amber-300">WANUWIN</span></h1>
                <p class="mt-2 text-xs sm:text-sm font-medium text-emerald-50/85 max-w-xl leading-relaxed">Pantau seluruh konten portal NU Desa Windunegara — berita, warga, pengurus, kegiatan, dan galeri — dari satu tempat.</p>
                <div class="mt-5 flex flex-wrap gap-2.5">
                    <a href="{{ route('admin.news.index') }}" class="inline-flex items-center gap-2 bg-amber-400 hover:bg-amber-300 text-slate-950 font-extrabold text-xs px-5 py-3 rounded-2xl shadow-lg transition active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Kelola Berita
                    </a>
                    <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs px-5 py-3 rounded-2xl transition active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Lihat Website
                    </a>
                </div>
            </div>
            <div class="lg:ml-auto shrink-0 grid grid-cols-2 gap-3 w-full lg:w-auto">
                <div class="rounded-2xl bg-white/10 border border-white/15 backdrop-blur px-5 py-4">
                    <p class="text-[10px] font-extrabold uppercase tracking-widest text-emerald-100/80">Total Data</p>
                    <p class="text-2xl font-black mt-1">{{ array_sum($data) }}</p>
                </div>
                <div class="rounded-2xl bg-amber-400 text-slate-950 px-5 py-4 shadow-lg">
                    <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-800/70">Menu Aktif</p>
                    <p class="text-2xl font-black mt-1">8</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Kartu statistik --}}
    @php
        $stats = [
            ['label' => 'Berita', 'val' => $data['news'], 'desc' => 'Warta terpublikasi', 'route' => 'admin.news.index',
             'iconBg' => 'from-emerald-500 to-emerald-700', 'softBg' => 'bg-emerald-50', 'bar' => 'from-emerald-500 to-teal-400',
             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>'],
            ['label' => 'Warga NU', 'val' => $data['members'], 'desc' => 'Anggota terdata', 'route' => 'admin.members.index',
             'iconBg' => 'from-teal-500 to-emerald-800', 'softBg' => 'bg-teal-50', 'bar' => 'from-teal-500 to-emerald-400',
             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/>'],
            ['label' => 'Pengurus', 'val' => $data['committees'], 'desc' => 'Struktur & Banom', 'route' => 'admin.committees.index',
             'iconBg' => 'from-amber-400 to-amber-600', 'softBg' => 'bg-amber-50', 'bar' => 'from-amber-400 to-orange-400',
             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>'],
            ['label' => 'Kegiatan', 'val' => $data['activities'], 'desc' => 'Agenda & acara', 'route' => 'admin.activities.index',
             'iconBg' => 'from-lime-500 to-emerald-700', 'softBg' => 'bg-lime-50', 'bar' => 'from-lime-500 to-emerald-400',
             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
            ['label' => 'Galeri Foto', 'val' => $data['galleries'], 'desc' => 'Dokumentasi', 'route' => 'admin.galleries.index',
             'iconBg' => 'from-slate-700 to-slate-950', 'softBg' => 'bg-slate-100', 'bar' => 'from-slate-500 to-emerald-400',
             'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
        ];
    @endphp

    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4">
        @foreach($stats as $i => $s)
        <a href="{{ Route::has($s['route']) ? route($s['route']) : '#' }}" class="rise rise-{{ min($i, 3) }} group relative bg-white rounded-3xl border border-slate-200/70 shadow-lg shadow-slate-900/5 p-5 overflow-hidden hover:-translate-y-1.5 hover:shadow-xl hover:shadow-emerald-900/10 transition-all duration-300">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r {{ $s['bar'] }}"></div>
            <div class="flex items-start justify-between gap-3">
                <span class="w-11 h-11 rounded-2xl bg-gradient-to-br {{ $s['iconBg'] }} text-white grid place-items-center shadow-md group-hover:scale-110 group-hover:rotate-3 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $s['icon'] !!}</svg>
                </span>
                <span class="text-[10px] font-extrabold uppercase tracking-widest px-2.5 py-1.5 rounded-full {{ $s['softBg'] }} text-slate-600">{{ $s['label'] }}</span>
            </div>
            <p class="mt-4 text-4xl font-black text-slate-900 tracking-tight tabular-nums">{{ $s['val'] }}</p>
            <p class="mt-1 text-[11px] font-semibold text-slate-500">{{ $s['desc'] }}</p>
            <p class="mt-3 inline-flex items-center gap-1 text-[11px] font-extrabold text-emerald-700 group-hover:gap-2 transition-all">Kelola <span aria-hidden="true">&rarr;</span></p>
        </a>
        @endforeach
    </div>

    {{-- Aksi cepat + tips --}}
    <div class="grid lg:grid-cols-3 gap-4">
        <div class="rise rise-1 lg:col-span-2 bg-white rounded-3xl border border-slate-200/70 shadow-lg shadow-slate-900/5 p-6">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h3 class="font-extrabold text-slate-800 tracking-tight">Aksi Cepat</h3>
                    <p class="text-[11px] font-medium text-slate-500 mt-0.5">Pintasan menuju halaman kelola yang paling sering dipakai.</p>
                </div>
                <span class="hidden sm:inline-flex text-[10px] font-extrabold uppercase tracking-widest bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-full px-3 py-1.5">8 Modul</span>
            </div>
            <div class="mt-4 grid sm:grid-cols-2 gap-2.5 text-xs font-bold">
                <a href="{{ route('admin.carousels.index') }}" class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-100 bg-slate-50/60 hover:bg-emerald-50 hover:border-emerald-200 hover:text-emerald-900 transition group">
                    <span class="w-9 h-9 grid place-items-center rounded-xl bg-slate-900 text-white group-hover:bg-emerald-700 transition">1</span> Atur Banner Carousel
                </a>
                <a href="{{ route('admin.news.index') }}" class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-100 bg-slate-50/60 hover:bg-emerald-50 hover:border-emerald-200 hover:text-emerald-900 transition group">
                    <span class="w-9 h-9 grid place-items-center rounded-xl bg-slate-900 text-white group-hover:bg-emerald-700 transition">2</span> Terbitkan Warta Baru
                </a>
                <a href="{{ route('admin.activities.index') }}" class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-100 bg-slate-50/60 hover:bg-emerald-50 hover:border-emerald-200 hover:text-emerald-900 transition group">
                    <span class="w-9 h-9 grid place-items-center rounded-xl bg-slate-900 text-white group-hover:bg-emerald-700 transition">3</span> Tambah Agenda Kegiatan
                </a>
                @if(Route::has('admin.members.index'))
                <a href="{{ route('admin.members.index') }}" class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-100 bg-slate-50/60 hover:bg-emerald-50 hover:border-emerald-200 hover:text-emerald-900 transition group">
                    <span class="w-9 h-9 grid place-items-center rounded-xl bg-slate-900 text-white group-hover:bg-emerald-700 transition">4</span> Input Data Warga
                </a>
                @endif
            </div>
        </div>
        <div class="rise rise-2 relative overflow-hidden rounded-3xl bg-slate-950 text-white p-6 border border-white/10 shadow-xl">
            <div class="absolute -top-16 -right-16 w-48 h-48 rounded-full bg-emerald-500/30 blur-3xl"></div>
            <h3 class="relative font-extrabold tracking-tight">Tips Admin</h3>
            <ul class="relative mt-3 space-y-2.5 text-[11px] font-medium text-slate-300 leading-relaxed">
                <li class="flex gap-2"><span class="text-amber-300 font-black">&bull;</span> Unggah gambar landscape agar banner &amp; berita tampil tajam.</li>
                <li class="flex gap-2"><span class="text-amber-300 font-black">&bull;</span> Periksa Saran &amp; Masukan secara berkala untuk aspirasi warga.</li>
                <li class="flex gap-2"><span class="text-amber-300 font-black">&bull;</span> Selalu klik <span class="text-white font-bold">Pratinjau Web</span> setelah mengubah konten.</li>
            </ul>
            @if(Route::has('admin.feedbacks.index'))
            <a href="{{ route('admin.feedbacks.index') }}" class="relative mt-5 inline-flex items-center gap-2 text-[11px] font-extrabold bg-white/10 hover:bg-white/20 border border-white/15 rounded-2xl px-4 py-2.5 transition">Cek Saran Masuk <span aria-hidden="true">&rarr;</span></a>
            @endif
        </div>
    </div>

</div>
@endsection
