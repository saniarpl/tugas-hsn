@extends('layouts.app')

@section('content')

{{-- ============ STYLE ANIMASI (hanya tampilan, tidak mengubah fungsi) ============ --}}
<style>
    @property --ang { syntax: '<angle>'; initial-value: 0deg; inherits: false; }

    /* ---------- Scroll reveal ---------- */
    .fx .reveal { opacity: 0; transform: translateY(40px) scale(.97); filter: blur(8px);
              transition: opacity .9s cubic-bezier(.22,1,.36,1), transform .9s cubic-bezier(.22,1,.36,1), filter .9s cubic-bezier(.22,1,.36,1);
              transition-delay: var(--d, 0ms); }
    .fx .reveal.in { opacity: 1; transform: none; filter: none; }

    /* ---------- Judul section: huruf muncul satu per satu + garis tergambar ---------- */
    .title-line { position: relative; }
    .title-line::after { content: ""; position: absolute; left: 0; bottom: 0; height: 3px; width: 100%;
                         background: linear-gradient(90deg, #10b981, #fbbf24); border-radius: 9999px;
                         transform: scaleX(0); transform-origin: left; transition: transform 1.2s cubic-bezier(.22,1,.36,1) .5s; }
    .title-line.in::after { transform: scaleX(1); }
    .w-nb { display: inline-block; white-space: nowrap; }
    .fx .ch { display: inline-block; opacity: 0; transform: translateY(70%) rotateX(-80deg); transform-origin: bottom; filter: blur(5px);
          transition: all .7s cubic-bezier(.22,1,.36,1); transition-delay: calc(var(--i) * 30ms); }
    .fx .in .ch, .fx .ch.in { opacity: 1; transform: none; filter: none; }

    /* ---------- Progress scroll & cursor glow ---------- */
    #scrollbar-fx { position: fixed; top: 0; left: 0; height: 3px; width: 100%; z-index: 999; pointer-events: none;
                    background: linear-gradient(90deg, #10b981, #fbbf24); transform-origin: left; transform: scaleX(0); }
    #cursor-glow { position: fixed; top: 0; left: 0; width: 520px; height: 520px; margin: -260px 0 0 -260px; z-index: 1; pointer-events: none;
                   background: radial-gradient(circle, rgba(16,185,129,.13), rgba(251,191,36,.06) 45%, transparent 70%);
                   opacity: 0; transition: opacity .5s; will-change: transform; }

    /* ---------- Carousel ---------- */
    @keyframes kenburns { from { transform: scale(1.02); } to { transform: scale(1.14) translate(-1.5%, -1%); } }
    .kb { animation: kenburns 9s ease-out forwards; }
    .par-img { transform: translate3d(calc(var(--px, 0) * -22px), calc(var(--py, 0) * -14px), 0) scale(1.1); transition: transform .35s ease-out; }
    .par-txt { transform: translate3d(calc(var(--px, 0) * 12px), calc(var(--py, 0) * 8px), 0); transition: transform .35s ease-out; }
    .word { display: inline-block; overflow: hidden; vertical-align: bottom; padding-bottom: .14em; margin-right: .28em; }
    .word > span { display: inline-block; transform: translateY(115%) rotate(5deg); animation: wordUp .95s cubic-bezier(.22,1,.36,1) forwards;
                   animation-delay: calc(.35s + var(--i) * 90ms); }
    @keyframes wordUp { to { transform: none; } }
    @keyframes slideUp { from { opacity: 0; transform: translateY(26px); filter: blur(6px); } to { opacity: 1; transform: none; filter: none; } }
    .s-up { opacity: 0; animation: slideUp .8s cubic-bezier(.22,1,.36,1) forwards; }
    .s-up.d1 { animation-delay: .15s; } .s-up.d3 { animation-delay: .9s; }
    @keyframes dotFill { from { transform: scaleX(0); } to { transform: scaleX(1); } }
    .dot-fill { transform-origin: left; animation: dotFill 5s linear forwards; }
    @keyframes barFill { from { transform: scaleX(0); } to { transform: scaleX(1); } }
    .aurora { position: absolute; border-radius: 9999px; filter: blur(80px); pointer-events: none; mix-blend-mode: screen; }
    @keyframes drift { 0%,100% { transform: translate(0,0) scale(1); } 50% { transform: translate(40px,-30px) scale(1.15); } }
    .aurora { animation: drift 9s ease-in-out infinite; }

    /* ---------- Card: tilt 3D + spotlight + kilau ---------- */
    .tilt { transition: transform .25s ease-out, box-shadow .5s, border-color .5s; will-change: transform; position: relative; }
    .tilt:hover { box-shadow: 0 35px 70px -25px rgba(6,78,59,.45); border-color: rgba(16,185,129,.55); }
    .tilt.leaving { transition: transform .7s cubic-bezier(.22,1,.36,1), box-shadow .5s, border-color .5s; }
    .spot::after { content: ""; position: absolute; inset: 0; z-index: 6; pointer-events: none; opacity: 0; transition: opacity .4s;
                   background: radial-gradient(420px circle at var(--mx, 50%) var(--my, 50%), rgba(16,185,129,.18), transparent 60%); }
    .spot:hover::after { opacity: 1; }
    .card-shine { position: relative; overflow: hidden; }
    .card-shine::before { content: ""; position: absolute; inset: 0; z-index: 5; pointer-events: none;
                          background: linear-gradient(115deg, transparent 35%, rgba(255,255,255,.4) 50%, transparent 65%);
                          transform: translateX(-120%); transition: transform 1s ease; }
    .tilt:hover .card-shine::before { transform: translateX(120%); }
    /* gambar terbuka dengan tirai hijau (aman: hanya aktif bila JS berjalan) */
    .img-reveal::after { content: ""; position: absolute; inset: 0; z-index: 7; pointer-events: none; background: linear-gradient(135deg, #064e3b, #10b981);
                         transform: scaleY(0); transform-origin: top; }
    .fx .img-reveal::after { transform: scaleY(1); transition: transform 1.1s cubic-bezier(.77,0,.18,1); transition-delay: calc(var(--d, 0ms) + 200ms); }
    .fx .in .img-reveal::after { transform: scaleY(0); transform-origin: bottom; }
    .fx .img-reveal img { scale: 1.35; transition: scale 1.6s cubic-bezier(.22,1,.36,1), transform .7s ease-out; transition-delay: calc(var(--d, 0ms) + 200ms), 0s; }
    .fx .in .img-reveal img { scale: 1; }
    .arrow-move { transition: transform .35s cubic-bezier(.22,1,.36,1); display: inline-block; }
    .btn-anim:hover .arrow-move { transform: translateX(6px); }

    /* ---------- Border berputar untuk kartu rekening ---------- */
    .glow-border { position: relative; border-radius: 2rem; padding: 2px;
                   background: conic-gradient(from var(--ang), transparent 0 55%, #fbbf24 78%, #34d399 90%, transparent 100%);
                   animation: spin 6s linear infinite; }
    @keyframes spin { to { --ang: 360deg; } }
    @keyframes floaty { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    .floaty { animation: floaty 7s ease-in-out infinite; }
    @keyframes pulseRing { 0% { box-shadow: 0 0 0 0 rgba(16,185,129,.6); } 100% { box-shadow: 0 0 0 10px rgba(16,185,129,0); } }
    .live-dot { animation: pulseRing 1.6s infinite; }

    /* ---------- Tombol: kilau + ripple ---------- */
    .btn-glow { position: relative; overflow: hidden; transition: transform .3s, box-shadow .3s; }
    .btn-glow:hover { transform: translateY(-2px); box-shadow: 0 14px 30px -10px rgba(4,120,87,.6); }
    .btn-glow:active { transform: scale(.98); }
    .btn-glow::after { content: ""; position: absolute; top: 0; left: -60%; width: 40%; height: 100%;
                       background: linear-gradient(90deg, transparent, rgba(255,255,255,.35), transparent); transform: skewX(-20deg); transition: left .7s; }
    .btn-glow:hover::after { left: 130%; }
    .ripple-el { position: absolute; border-radius: 9999px; background: rgba(255,255,255,.45); transform: scale(0); animation: rip .65s ease-out forwards; pointer-events: none; }
    @keyframes rip { to { transform: scale(4); opacity: 0; } }
    [data-magnetic] { transition: translate .25s ease-out; }

    /* ---------- Input ---------- */
    .field { transition: box-shadow .3s, background .3s, transform .3s; }
    .field:focus { transform: translateY(-1px); box-shadow: 0 8px 24px -10px rgba(16,185,129,.5); }

    .bg-orbs::before, .bg-orbs::after { content: ""; position: absolute; border-radius: 9999px; filter: blur(70px); pointer-events: none; }
    .bg-orbs::before { width: 280px; height: 280px; background: rgba(16,185,129,.35); top: -80px; right: -60px; }
    .bg-orbs::after { width: 240px; height: 240px; background: rgba(251,191,36,.25); bottom: -80px; left: -60px; }

    @media (prefers-reduced-motion: reduce) {
        .reveal, .ch, .word > span, .s-up { opacity: 1; transform: none; filter: none; transition: none; animation: none; }
        .img-reveal::after { display: none; }
        .fx .img-reveal img { scale: 1; transition: none; }
        .kb, .dot-fill, .floaty, .live-dot, .glow-border, .aurora { animation: none; }
        .tilt, .btn-glow, .field, .par-img, .par-txt { transition: none; }
    }
</style>

<div id="scrollbar-fx"></div>
<div id="cursor-glow"></div>

<div class="max-w-7xl mx-auto px-6 py-8 space-y-24">

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-2xl text-sm font-bold shadow-sm flex justify-between items-center"
             x-data="{ show: true }" x-show="show"
             x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 scale-95">
            {{ session('success') }}
            <button @click="show = false" class="text-emerald-600 hover:text-emerald-900 hover:rotate-90 transition duration-300">&times;</button>
        </div>
    @endif

    <!-- 1. Hero Carousel -->
    <section id="hero-carousel" class="relative rounded-[2rem] overflow-hidden shadow-2xl shadow-emerald-900/25 border border-slate-200/80 bg-slate-900 group"
             x-data="{ active: 0, total: {{ count($carousels ?? []) }} }"
             x-init="if(total > 1) setInterval(() => { active = (active + 1) % total }, 5000)">

        @if(isset($carousels) && count($carousels) > 0)
            <div class="relative h-[400px] sm:h-[540px] w-full">
                @foreach($carousels as $key => $carousel)
                    <div x-cloak x-show="active === {{ $key }}"
                         x-transition:enter="transition-opacity duration-1000 ease-out" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                         x-transition:leave="transition-opacity duration-1000 ease-in" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                         class="absolute inset-0 overflow-hidden">
                        <div class="par-img absolute inset-0">
                            <img src="{{ asset('storage/' . $carousel->image) }}" class="kb w-full h-full object-cover" alt="Banner">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/70 via-transparent to-transparent"></div>
                        <div class="aurora w-72 h-72 bg-emerald-400/30 -top-20 -left-10"></div>
                        <div class="aurora w-64 h-64 bg-amber-300/25 bottom-0 right-10" style="animation-delay: -4s"></div>
                        <div class="par-txt absolute bottom-0 left-0 p-8 sm:p-14 max-w-4xl">
                            <span class="s-up d1 bg-amber-400 text-slate-950 text-[10px] font-black px-3 py-1 rounded-full uppercase mb-5 inline-flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-950 live-dot"></span> INFORMASI
                            </span>
                            <h2 class="text-3xl sm:text-6xl font-extrabold text-white mb-4 leading-[1.08] drop-shadow-lg" aria-label="{{ $carousel->title }}">
                                @foreach(explode(' ', $carousel->title) as $i => $w)<span class="word" aria-hidden="true"><span style="--i: {{ $i }}">{{ $w }}</span></span>@endforeach
                            </h2>
                            <p class="s-up d3 text-xs sm:text-base text-slate-200 line-clamp-2 max-w-xl">{{ $carousel->description }}</p>
                        </div>
                    </div>
                @endforeach

                @if(count($carousels) > 1)
                    <button data-magnetic data-ripple @click="active = active === 0 ? total - 1 : active - 1" class="absolute left-5 top-1/2 -translate-y-1/2 bg-white/10 backdrop-blur-md border border-white/20 hover:bg-amber-400 hover:text-slate-950 text-white p-3.5 rounded-full opacity-0 -translate-x-4 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-500 z-20 hidden md:block overflow-hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button data-magnetic data-ripple @click="active = (active + 1) % total" class="absolute right-5 top-1/2 -translate-y-1/2 bg-white/10 backdrop-blur-md border border-white/20 hover:bg-amber-400 hover:text-slate-950 text-white p-3.5 rounded-full opacity-0 translate-x-4 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-500 z-20 hidden md:block overflow-hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                    <div class="absolute bottom-7 right-8 flex items-center gap-4 z-20">
                        <span class="text-white/80 text-xs font-bold tabular-nums hidden sm:block"><span class="text-amber-400 text-base" x-text="String(active + 1).padStart(2, '0')"></span> / <span x-text="String(total).padStart(2, '0')"></span></span>
                        <div class="flex items-center space-x-2">
                            @foreach($carousels as $key => $carousel)
                                <button @click="active = {{ $key }}" :class="active === {{ $key }} ? 'w-10 bg-white/30' : 'w-2.5 bg-white/50 hover:bg-white/80'" class="relative h-2.5 rounded-full overflow-hidden transition-all duration-500">
                                    <span x-show="active === {{ $key }}" class="dot-fill absolute inset-0 bg-amber-400 rounded-full"></span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </section>

    <!-- 2. Seksi Warta Berita -->
    <section id="berita" class="scroll-mt-28">
        <h2 data-reveal data-split class="split-title title-line text-3xl sm:text-4xl font-black text-slate-800 pb-3 mb-10 inline-block" style="perspective: 600px">Warta Berita NU</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($news ?? [] as $item)
                <article class="relative flex flex-col group">
                    <div data-reveal style="--d: {{ $loop->index * 140 }}ms; perspective: 1000px" class="reveal h-full">
                        <div data-tilt class="tilt spot bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-sm flex flex-col h-full">
                            <div class="h-52 overflow-hidden relative card-shine img-reveal">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" loading="lazy" class="w-full h-full object-cover transform group-hover:scale-110 group-hover:rotate-1 transition duration-700 ease-out">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-emerald-800 to-emerald-950 flex items-center justify-center text-white font-black text-3xl">NU</div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                                <span class="absolute bottom-3 left-3 text-[10px] text-white font-bold uppercase tracking-wider bg-emerald-700/70 backdrop-blur-md border border-white/20 px-2.5 py-1 rounded-full">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</span>
                            </div>
                            <div class="p-6 flex flex-col flex-grow">
                                <h3 class="font-extrabold text-slate-800 text-lg leading-snug mb-2 line-clamp-2 group-hover:text-emerald-700 transition-colors duration-300">{{ $item->title }}</h3>
                                <p class="text-xs text-slate-500 line-clamp-3 mb-4">{{ $item->content }}</p>
                                <div class="mt-auto pt-4 border-t border-slate-100">
                                    <a href="{{ route('news.show', $item->id) }}" data-ripple class="btn-anim relative overflow-hidden w-full bg-slate-50 hover:bg-emerald-600 hover:text-white text-emerald-700 font-bold text-xs py-3 rounded-xl transition-colors duration-300 flex justify-center items-center gap-2">
                                        Lihat Detail Berita <span class="arrow-move">&rarr;</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-8 text-slate-400 font-medium text-xs border border-dashed rounded-2xl">Belum ada warta berita terbaru.</div>
            @endforelse
        </div>
    </section>

    <!-- 3. Seksi Infaq Masjid & Riwayat -->
    <section id="infaq" class="scroll-mt-28">
        <h2 data-reveal data-split class="split-title title-line text-3xl sm:text-4xl font-black text-slate-800 pb-3 mb-10 inline-block" style="perspective: 600px">Infaq & Amal Jariyah</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
            <!-- Informasi Rekening -->
            <div data-reveal class="reveal glow-border shadow-2xl shadow-emerald-900/30">
                <div class="bg-orbs relative overflow-hidden bg-gradient-to-br from-emerald-900 to-emerald-950 rounded-[calc(2rem-2px)] p-8 sm:p-10 text-white">
                    <div class="relative z-10">
                        <span class="bg-amber-400 text-slate-950 text-[10px] font-black px-3 py-1 rounded-full uppercase mb-4 inline-block">KAS PEMBANGUNAN MASJID</span>
                        <h3 class="text-2xl sm:text-3xl font-extrabold mb-4 leading-tight">Salurkan Sedekah Terbaik Anda</h3>
                        <p class="text-xs sm:text-sm text-emerald-100 mb-8 leading-relaxed font-medium">Bantu operasional dakwah dan pembangunan sarana ibadah Ranting NU Desa Windunegara. Insya Allah pahala akan terus mengalir.</p>
                        <div class="floaty bg-white/10 p-6 rounded-2xl border border-white/20 text-center backdrop-blur-md hover:bg-white/15 transition-colors duration-300">
                            <p class="text-xs font-bold text-amber-300 mb-2 uppercase tracking-widest">Bank Rakyat Indonesia (BRI)</p>
                            <span class="text-2xl font-black tracking-widest text-white drop-shadow block mb-1">6823-01-029182-53-1</span>
                            <span class="text-xs font-medium text-emerald-200">a.n. Panitia Pembangunan / NU Windunegara</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Donasi -->
            <div data-reveal style="--d: 150ms" class="reveal bg-white rounded-[2rem] p-8 border border-slate-200 shadow-sm h-full">
                <div class="flex justify-between items-end mb-6 border-b border-slate-100 pb-4">
                    <h3 class="text-lg font-extrabold text-slate-800">Riwayat Donasi Terakhir</h3>
                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full inline-flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 live-dot"></span> Real-time
                    </span>
                </div>
                <ul class="space-y-3">
                    @forelse($donations as $donasi)
                        <li data-reveal style="--d: {{ 200 + $loop->index * 100 }}ms" class="reveal group/item flex justify-between items-center p-2 -mx-2 rounded-2xl hover:bg-emerald-50/60 transition-colors duration-300">
                            <div class="flex items-center gap-3">
                                <div class="bg-emerald-100 p-2.5 rounded-xl text-emerald-600 group-hover/item:bg-emerald-600 group-hover/item:text-white group-hover/item:rotate-12 transition duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-slate-800">{{ $donasi->name }}</p>
                                    <p class="text-[10px] font-medium text-slate-500">{{ \Carbon\Carbon::parse($donasi->date)->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span data-count="{{ (int) $donasi->amount }}" class="font-extrabold text-emerald-700 text-sm bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-100 group-hover/item:scale-105 transition duration-300 tabular-nums">
                                Rp {{ number_format($donasi->amount, 0, ',', '.') }}
                            </span>
                        </li>
                    @empty
                        <li class="text-xs text-slate-400 text-center">Belum ada data donasi.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </section>

    <!-- 4. Seksi Agenda Kegiatan -->
    <section id="kegiatan" class="scroll-mt-28">
        <h2 data-reveal data-split class="split-title title-line text-3xl sm:text-4xl font-black text-slate-800 pb-3 mb-10 inline-block" style="perspective: 600px">Agenda Kegiatan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($activities ?? [] as $activity)
                <div data-reveal style="--d: {{ $loop->index * 140 }}ms; perspective: 1000px" class="reveal group h-full">
                    <div data-tilt class="tilt spot bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-sm flex flex-col h-full">
                        <div class="h-52 overflow-hidden relative card-shine img-reveal">
                            @if($activity->image)
                                <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->title }}" loading="lazy" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 ease-out">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-emerald-800 to-emerald-950 flex items-center justify-center text-white font-black text-3xl">NU</div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent"></div>
                            <span class="absolute top-3 right-3 bg-amber-400 text-slate-950 text-[10px] font-black px-3 py-1 rounded-full shadow-md group-hover:scale-110 group-hover:-rotate-3 transition duration-300">{{ \Carbon\Carbon::parse($activity->date)->translatedFormat('d M Y') }}</span>
                        </div>
                        <div class="p-6 flex-grow relative">
                            <span class="absolute top-0 left-6 h-1 w-0 bg-gradient-to-r from-emerald-500 to-amber-400 rounded-full group-hover:w-16 transition-all duration-500"></span>
                            <h3 class="font-extrabold text-slate-800 text-lg mb-2 group-hover:text-emerald-700 transition-colors duration-300">{{ $activity->title }}</h3>
                            <p class="text-xs text-slate-500 line-clamp-3 mb-4">{{ $activity->description }}</p>
                            <a href="{{ route('activities.show', $activity->id) }}" class="inline-flex items-center gap-2 text-xs font-bold text-emerald-700 hover:text-emerald-800 hover:gap-3 transition-all">
                                Lihat Detail Kegiatan <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-8 text-slate-400 font-medium text-xs border border-dashed rounded-2xl">Belum ada agenda terdaftar.</div>
            @endforelse
        </div>
    </section>

    <!-- 5. Seksi Galeri Kegiatan -->
    <section id="galeri" class="scroll-mt-28" x-data="galeriSection()">
        <div class="flex flex-wrap items-end justify-between gap-4 mb-10">
            <h2 data-reveal data-split class="split-title title-line text-3xl sm:text-4xl font-black text-slate-800 pb-3 inline-block" style="perspective: 600px">Galeri Kegiatan</h2>
            @if(Route::has('gallery'))
                <a data-reveal style="--d: 150ms" href="{{ route('gallery') }}" class="reveal btn-anim inline-flex items-center gap-2 text-xs font-bold text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-100 px-4 py-2.5 rounded-xl transition">
                    Lihat Semua <span class="arrow-move">&rarr;</span>
                </a>
            @endif
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @forelse($galleries ?? [] as $gallery)
                <div data-reveal style="--d: {{ $loop->index * 120 }}ms; perspective: 1000px" class="reveal">
                    <button type="button" @click="show({{ $loop->index }})" data-tilt
                            data-full="{{ asset('storage/' . $gallery->image) }}"
                            data-title="{{ $gallery->title }}"
                            class="tilt spot group relative block w-full text-left bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-sm">
                        <span class="block h-40 sm:h-56 overflow-hidden relative card-shine img-reveal">
                            <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" loading="lazy" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 ease-out">
                            <span class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-slate-900/10 to-transparent"></span>
                            <span class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                <span class="bg-white/20 backdrop-blur-md border border-white/40 text-white p-3 rounded-full">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path></svg>
                                </span>
                            </span>
                            <span class="absolute bottom-0 left-0 right-0 p-3 sm:p-4">
                                <span class="block font-extrabold text-white text-xs sm:text-sm leading-snug line-clamp-2 drop-shadow">{{ $gallery->title }}</span>
                            </span>
                        </span>
                    </button>
                </div>
            @empty
                <div class="col-span-full text-center py-8 text-slate-400 font-medium text-xs border border-dashed rounded-2xl">Belum ada foto kegiatan.</div>
            @endforelse
        </div>

        <!-- Lightbox -->
        <div x-cloak x-show="open"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[500] flex items-center justify-center bg-slate-950/90 backdrop-blur-md p-4"
             @click.self="close()" @keydown.escape.window="close()"
             @keydown.arrow-right.window="if (open) next()" @keydown.arrow-left.window="if (open) prev()">
            <template x-if="images.length">
                <figure class="relative max-w-4xl w-full"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                    <button @click="close()" aria-label="Tutup" class="absolute -top-3 -right-3 sm:top-4 sm:right-4 z-10 bg-red-500 hover:bg-red-600 hover:rotate-90 text-white p-2 rounded-full shadow transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <img :src="images[index].src" :alt="images[index].title" class="w-full max-h-[75vh] object-contain rounded-2xl shadow-2xl bg-slate-900">
                    <figcaption class="flex items-center justify-between gap-4 mt-3 text-white">
                        <span class="text-xs sm:text-sm font-bold truncate" x-text="images[index].title"></span>
                        <span class="text-[11px] font-bold tabular-nums text-white/70 shrink-0"><span class="text-amber-400" x-text="index + 1"></span> / <span x-text="images.length"></span></span>
                    </figcaption>
                    <template x-if="images.length > 1">
                        <div>
                            <button @click.stop="prev()" aria-label="Sebelumnya" class="absolute left-2 sm:-left-6 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-amber-400 hover:text-slate-950 backdrop-blur-md border border-white/20 text-white p-2.5 sm:p-3 rounded-full transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </button>
                            <button @click.stop="next()" aria-label="Berikutnya" class="absolute right-2 sm:-right-6 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-amber-400 hover:text-slate-950 backdrop-blur-md border border-white/20 text-white p-2.5 sm:p-3 rounded-full transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    </template>
                </figure>
            </template>
        </div>
    </section>
    <script>
        function galeriSection() {
            return {
                open: false, index: 0, images: [],
                init: function () {
                    this.images = Array.from(this.$el.querySelectorAll('[data-full]')).map(function (el) {
                        return { src: el.getAttribute('data-full'), title: el.getAttribute('data-title') || '' };
                    });
                },
                show: function (i) { if (!this.images.length) return; this.index = i; this.open = true; document.body.style.overflow = 'hidden'; },
                close: function () { this.open = false; document.body.style.overflow = ''; },
                next: function () { this.index = (this.index + 1) % this.images.length; },
                prev: function () { this.index = (this.index - 1 + this.images.length) % this.images.length; }
            };
        }
    </script>

    <!-- 6. Seksi Saran & Kritik -->
    <section id="saran" class="scroll-mt-28 max-w-3xl mx-auto">
        <div data-reveal class="reveal bg-white rounded-[2rem] p-8 sm:p-12 border border-slate-200 shadow-xl shadow-emerald-900/5 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -z-0 floaty"></div>
            <div class="relative z-10 text-center mb-8">
                <span class="text-emerald-600 font-extrabold text-[10px] uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-full">Layanan Pengunjung</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-800 mt-4 mb-2">Saran & Kritik</h2>
                <p class="text-xs sm:text-sm text-slate-500">Sampaikan masukan Anda untuk kemajuan jam'iyyah NU Desa Windunegara.</p>
            </div>

            <form action="{{ route('feedback.store') }}" method="POST" class="space-y-5 relative z-10">
                @csrf
                {{-- Honeypot anti-spam: wajib kosong, jangan diisi --}}
                <div class="hidden" aria-hidden="true">
                    <label>Jangan isi kolom ini<input type="text" name="website" value="" tabindex="-1" autocomplete="off"></label>
                </div>
                @if($errors->any())
                    <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-xs text-red-700 font-bold" role="alert">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="saran-nama" class="block text-[11px] font-bold text-slate-700 mb-1.5 uppercase">Nama Lengkap</label>
                        <input id="saran-nama" type="text" name="name" value="{{ old('name') }}" required minlength="3" maxlength="100" autocomplete="name" placeholder="Contoh: Ahmad" class="field w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none @error('name') border-red-400 @enderror">
                        @error('name')<p class="mt-1 text-[11px] font-bold text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="saran-kontak" class="block text-[11px] font-bold text-slate-700 mb-1.5 uppercase">Nomor WhatsApp</label>
                        <input id="saran-kontak" type="text" name="contact" value="{{ old('contact') }}" maxlength="30" autocomplete="tel" placeholder="08xxxxxxxxxx" class="field w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none @error('contact') border-red-400 @enderror">
                        @error('contact')<p class="mt-1 text-[11px] font-bold text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label for="saran-pesan" class="block text-[11px] font-bold text-slate-700 mb-1.5 uppercase">Isi Masukan</label>
                    <textarea id="saran-pesan" name="message" rows="4" required minlength="10" maxlength="2000" placeholder="Tuliskan saran atau masukan Anda (min. 10 karakter)..." class="field w-full bg-slate-50 border border-slate-200 rounded-xl p-3.5 text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                    @error('message')<p class="mt-1 text-[11px] font-bold text-red-600">{{ $message }}</p>@enderror
                </div>
                <button type="submit" data-ripple data-magnetic class="btn-glow w-full bg-gradient-to-r from-emerald-700 to-emerald-600 text-white font-bold text-xs py-4 rounded-xl shadow-md">
                    Kirim Pesan
                </button>
            </form>
        </div>
    </section>

</div>

{{-- Mesin animasi (murni visual: tidak menyentuh data, form, atau Alpine) --}}
<script>
(function () {
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    document.documentElement.classList.add('fx');

    /* 1. Pecah judul jadi huruf */
    document.querySelectorAll('[data-split]').forEach(function (el) {
        var text = el.textContent.trim(), i = 0;
        el.setAttribute('aria-label', text);
        el.innerHTML = '';
        text.split(' ').forEach(function (word, wi, arr) {
            var w = document.createElement('span'); w.className = 'w-nb'; w.setAttribute('aria-hidden', 'true');
            word.split('').forEach(function (c) {
                var s = document.createElement('span'); s.className = 'ch'; s.style.setProperty('--i', i++); s.textContent = c; w.appendChild(s);
            });
            el.appendChild(w);
            if (wi < arr.length - 1) { el.appendChild(document.createTextNode(' ')); i++; }
        });
    });

    /* 2. Hitung naik angka donasi (bisa diulang) */
    function countUp(el) {
        var target = parseInt(el.getAttribute('data-count'), 10);
        if (isNaN(target) || reduce) return;
        cancelAnimationFrame(el._raf);
        var start = null, dur = 1400;
        el.textContent = 'Rp 0';
        (function step(t) {
            if (!start) start = t;
            var p = Math.min((t - start) / dur, 1), e = 1 - Math.pow(2, -10 * p);
            el.textContent = 'Rp ' + Math.round(target * e).toLocaleString('id-ID');
            if (p < 1) el._raf = requestAnimationFrame(step); else el.textContent = 'Rp ' + target.toLocaleString('id-ID');
        })(performance.now());
    }
    function resetCount(el) {
        var target = parseInt(el.getAttribute('data-count'), 10);
        cancelAnimationFrame(el._raf);
        if (!isNaN(target)) el.textContent = 'Rp ' + target.toLocaleString('id-ID');
    }

    /* 3. Reveal: animasi jalan setiap kali masuk layar (scroll ke bawah maupun ke atas) */
    var els = document.querySelectorAll('[data-reveal]');
    function show(t) {
        if (t.classList.contains('in')) return;
        t.classList.add('in'); t.querySelectorAll('[data-count]').forEach(countUp);
    }
    function hide(t) {
        if (!t.classList.contains('in')) return;
        t.classList.remove('in'); t.querySelectorAll('[data-count]').forEach(resetCount);
    }
    if (!('IntersectionObserver' in window)) { els.forEach(show); }
    else {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) { if (en.isIntersecting) show(en.target); else hide(en.target); });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
        els.forEach(function (e) { io.observe(e); });
    }

    /* 4. Progress bar scroll */
    var bar = document.getElementById('scrollbar-fx');
    function onScroll() {
        /* fallback: pastikan elemen yang sudah terlihat pasti muncul */
        els.forEach(function (el) {
            var r = el.getBoundingClientRect();
            if (r.top < window.innerHeight - 60 && r.bottom > 60) show(el);
        });
        var h = document.documentElement.scrollHeight - window.innerHeight;
        bar.style.transform = 'scaleX(' + (h > 0 ? window.scrollY / h : 0) + ')';
    }
    window.addEventListener('scroll', onScroll, { passive: true }); onScroll();
    setTimeout(onScroll, 1200); setTimeout(onScroll, 3000);

    /* 5. Ripple pada tombol */
    document.addEventListener('click', function (e) {
        var b = e.target.closest('[data-ripple]'); if (!b) return;
        var r = b.getBoundingClientRect(), size = Math.max(r.width, r.height) / 2;
        var s = document.createElement('span'); s.className = 'ripple-el';
        s.style.cssText = 'width:' + size + 'px;height:' + size + 'px;left:' + (e.clientX - r.left - size / 2) + 'px;top:' + (e.clientY - r.top - size / 2) + 'px';
        b.appendChild(s); setTimeout(function () { s.remove(); }, 700);
    });

    if (reduce || !fine) return; /* efek berikut hanya untuk mouse */

    /* 6. Cursor glow */
    var glow = document.getElementById('cursor-glow'), gx = 0, gy = 0, ticking = false;
    window.addEventListener('pointermove', function (e) {
        gx = e.clientX; gy = e.clientY; glow.style.opacity = 1;
        if (!ticking) { ticking = true; requestAnimationFrame(function () { glow.style.transform = 'translate(' + gx + 'px,' + gy + 'px)'; ticking = false; }); }
    });
    document.addEventListener('mouseleave', function () { glow.style.opacity = 0; });

    /* 7. Tilt 3D + spotlight pada card */
    document.querySelectorAll('[data-tilt]').forEach(function (card) {
        card.addEventListener('pointermove', function (e) {
            var r = card.getBoundingClientRect(), x = (e.clientX - r.left) / r.width, y = (e.clientY - r.top) / r.height;
            card.classList.remove('leaving');
            card.style.setProperty('--mx', (x * 100) + '%'); card.style.setProperty('--my', (y * 100) + '%');
            card.style.transform = 'rotateX(' + ((0.5 - y) * 9) + 'deg) rotateY(' + ((x - 0.5) * 11) + 'deg) translateY(-8px)';
        });
        card.addEventListener('pointerleave', function () { card.classList.add('leaving'); card.style.transform = ''; });
    });

    /* 8. Parallax carousel mengikuti mouse */
    var hero = document.getElementById('hero-carousel');
    if (hero) {
        hero.addEventListener('pointermove', function (e) {
            var r = hero.getBoundingClientRect();
            hero.style.setProperty('--px', ((e.clientX - r.left) / r.width - 0.5) * 2);
            hero.style.setProperty('--py', ((e.clientY - r.top) / r.height - 0.5) * 2);
        });
        hero.addEventListener('pointerleave', function () { hero.style.setProperty('--px', 0); hero.style.setProperty('--py', 0); });
    }

    /* 9. Tombol magnetis */
    document.querySelectorAll('[data-magnetic]').forEach(function (b) {
        b.addEventListener('pointermove', function (e) {
            var r = b.getBoundingClientRect();
            b.style.translate = ((e.clientX - (r.left + r.width / 2)) * 0.25) + 'px ' + ((e.clientY - (r.top + r.height / 2)) * 0.35) + 'px';
        });
        b.addEventListener('pointerleave', function () { b.style.translate = ''; });
    });
})();
</script>
@endsection