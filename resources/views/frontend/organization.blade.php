@extends('layouts.app')

@section('content')

{{-- ============ STYLE ANIMASI (hanya tampilan, tidak mengubah fungsi) ============ --}}
<style>
    @property --ang { syntax: '<angle>'; initial-value: 0deg; inherits: false; }

    /* Reveal berulang saat scroll (aman: hanya aktif bila JS jalan -> html.fx) */
    .fx .reveal { opacity: 0; transform: translateY(40px) scale(.97); filter: blur(8px);
                  transition: opacity .9s cubic-bezier(.22,1,.36,1), transform .9s cubic-bezier(.22,1,.36,1), filter .9s cubic-bezier(.22,1,.36,1);
                  transition-delay: var(--d, 0ms); }
    .fx .reveal.in { opacity: 1; transform: none; filter: none; }
    .fx .reveal-x { opacity: 0; transform: translateX(-28px); filter: blur(6px);
                    transition: opacity .7s cubic-bezier(.22,1,.36,1), transform .7s cubic-bezier(.22,1,.36,1), filter .7s; transition-delay: var(--d, 0ms); }
    .fx .reveal-x.in { opacity: 1; transform: none; filter: none; }

    /* Judul: huruf per huruf + garis tergambar */
    .title-line { position: relative; }
    .title-line::after { content: ""; position: absolute; left: 0; bottom: 0; height: 3px; width: 100%;
                         background: linear-gradient(90deg, #10b981, #fbbf24, transparent); border-radius: 9999px;
                         transform: scaleX(0); transform-origin: left; transition: transform 1.2s cubic-bezier(.22,1,.36,1) .4s; }
    .title-line.in::after { transform: scaleX(1); }
    .w-nb { display: inline-block; white-space: nowrap; }
    .fx .ch { display: inline-block; opacity: 0; transform: translateY(70%) rotateX(-80deg); transform-origin: bottom; filter: blur(5px);
              transition: all .7s cubic-bezier(.22,1,.36,1); transition-delay: calc(var(--i) * 30ms); }
    .fx .in .ch, .fx .ch.in { opacity: 1; transform: none; filter: none; }

    /* Progress scroll & cursor glow */
    #scrollbar-fx { position: fixed; top: 0; left: 0; height: 3px; width: 100%; z-index: 999; pointer-events: none;
                    background: linear-gradient(90deg, #10b981, #fbbf24); transform-origin: left; transform: scaleX(0); }
    #cursor-glow { position: fixed; top: 0; left: 0; width: 520px; height: 520px; margin: -260px 0 0 -260px; z-index: 1; pointer-events: none;
                   background: radial-gradient(circle, rgba(16,185,129,.13), rgba(251,191,36,.06) 45%, transparent 70%);
                   opacity: 0; transition: opacity .5s; will-change: transform; }

    /* Hero */
    .word { display: inline-block; overflow: hidden; vertical-align: bottom; padding-bottom: .14em; margin-right: .28em; }
    .word > span { display: inline-block; transform: translateY(115%) rotate(5deg); animation: wordUp .95s cubic-bezier(.22,1,.36,1) forwards;
                   animation-delay: calc(.3s + var(--i) * 90ms); }
    @keyframes wordUp { to { transform: none; } }
    @keyframes slideUp { from { opacity: 0; transform: translateY(24px); filter: blur(6px); } to { opacity: 1; transform: none; filter: none; } }
    .s-up { opacity: 0; animation: slideUp .8s cubic-bezier(.22,1,.36,1) forwards; }
    .s-up.d1 { animation-delay: .1s; } .s-up.d3 { animation-delay: .8s; }
    .aurora { position: absolute; border-radius: 9999px; filter: blur(80px); pointer-events: none; mix-blend-mode: screen;
              animation: drift 9s ease-in-out infinite; }
    @keyframes drift { 0%,100% { transform: translate(0,0) scale(1); } 50% { transform: translate(40px,-30px) scale(1.15); } }
    .par-a { translate: calc(var(--px, 0) * 30px) calc(var(--py, 0) * 20px); transition: translate .4s ease-out; }
    .par-b { translate: calc(var(--px, 0) * -45px) calc(var(--py, 0) * -30px); transition: translate .4s ease-out; }
    .ring-deco { position: absolute; border-radius: 9999px; border: 1.5px dashed rgba(255,255,255,.22); pointer-events: none; animation: rot 40s linear infinite; }
    @keyframes rot { to { transform: rotate(360deg); } }
    .grid-deco { position: absolute; inset: 0; pointer-events: none; opacity: .12;
                 background-image: linear-gradient(rgba(255,255,255,.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.5) 1px, transparent 1px);
                 background-size: 46px 46px; mask-image: radial-gradient(ellipse at 30% 50%, #000, transparent 70%); -webkit-mask-image: radial-gradient(ellipse at 30% 50%, #000, transparent 70%); }
    @keyframes pulseRing { 0% { box-shadow: 0 0 0 0 rgba(251,191,36,.7); } 100% { box-shadow: 0 0 0 10px rgba(251,191,36,0); } }
    .live-dot { animation: pulseRing 1.6s infinite; }

    /* Card: tilt + spotlight */
    .tilt { transition: transform .25s ease-out, box-shadow .5s, border-color .5s; will-change: transform; position: relative; overflow: hidden; }
    .tilt:hover { box-shadow: 0 35px 70px -25px rgba(6,78,59,.45); border-color: rgba(16,185,129,.55); }
    .tilt.leaving { transition: transform .7s cubic-bezier(.22,1,.36,1), box-shadow .5s, border-color .5s; }
    .spot::after { content: ""; position: absolute; inset: 0; z-index: 6; pointer-events: none; opacity: 0; transition: opacity .4s;
                   background: radial-gradient(420px circle at var(--mx, 50%) var(--my, 50%), rgba(16,185,129,.16), transparent 60%); }
    .spot:hover::after { opacity: 1; }
    .spot-dark::after { background: radial-gradient(420px circle at var(--mx, 50%) var(--my, 50%), rgba(251,191,36,.22), transparent 60%); }

    /* Kartu proker: border berputar */
    .glow-border { position: relative; border-radius: 1.5rem; padding: 2px;
                   background: conic-gradient(from var(--ang), transparent 0 55%, #fbbf24 78%, #34d399 90%, transparent 100%);
                   animation: spin 6s linear infinite; }
    @keyframes spin { to { --ang: 360deg; } }
    .check-pop { display: inline-block; transition: transform .6s cubic-bezier(.34,1.56,.64,1); }
    .fx .reveal-x:not(.in) .check-pop { transform: scale(0) rotate(-90deg); }
    li:hover .check-pop { transform: scale(1.3) rotate(10deg); }

    /* Avatar pengurus */
    .avatar-ring { display: inline-block; border-radius: 9999px; padding: 3px;
                   background: conic-gradient(from var(--ang), #10b981, #fbbf24, #10b981); animation: spin 5s linear infinite; }
    .avatar-ring > * { display: block; border: 3px solid #fff; }
    .fx .avatar-pop { opacity: 0; transform: scale(.4) rotate(-25deg); transition: all .9s cubic-bezier(.34,1.56,.64,1); transition-delay: calc(var(--d, 0ms) + 250ms); }
    .fx .in .avatar-pop { opacity: 1; transform: none; }
    .group:hover .avatar-ring { animation-duration: 1.6s; }
    .group:hover .avatar-ring > * { transform: scale(1.06); }
    .avatar-ring > * { transition: transform .5s cubic-bezier(.34,1.56,.64,1); }

    @media (prefers-reduced-motion: reduce) {
        .fx .reveal, .fx .reveal-x, .fx .ch, .word > span, .s-up, .fx .avatar-pop { opacity: 1; transform: none; filter: none; transition: none; animation: none; }
        .aurora, .ring-deco, .glow-border, .avatar-ring, .live-dot { animation: none; }
        .tilt, .par-a, .par-b { transition: none; }
    }
</style>

<div id="scrollbar-fx"></div>
<div id="cursor-glow"></div>

<section id="hero-org" class="bg-gradient-to-r {{ $org['color'] ?? 'from-emerald-900 to-green-950' }} text-white py-16 sm:py-24 px-6 relative overflow-hidden">
    <div class="grid-deco"></div>
    <div class="aurora par-a w-80 h-80 bg-emerald-400/30 -top-24 -left-16"></div>
    <div class="aurora par-b w-72 h-72 bg-amber-300/25 -bottom-24 right-10" style="animation-delay: -4s"></div>
    <div class="ring-deco par-b w-[420px] h-[420px] -right-24 -top-24 hidden sm:block"></div>
    <div class="ring-deco par-a w-[260px] h-[260px] right-32 bottom-0 hidden sm:block" style="animation-direction: reverse"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        <span class="s-up d1 bg-amber-400 text-slate-950 text-[10px] font-black px-3 py-1 rounded-full uppercase mb-4 inline-flex items-center gap-2">
            <span class="w-1.5 h-1.5 rounded-full bg-slate-950 live-dot"></span> BADAN OTONOM NU
        </span>
        <h1 class="text-4xl sm:text-6xl font-black tracking-tight mb-4 leading-[1.08]" aria-label="{{ $org['title'] }}">
            @foreach(explode(' ', $org['title']) as $i => $w)<span class="word" aria-hidden="true"><span style="--i: {{ $i }}">{{ $w }}</span></span>@endforeach
        </h1>
        <p class="s-up d3 text-xs sm:text-base text-emerald-100 font-medium max-w-2xl">{{ $org['description'] }}</p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-6 py-12 space-y-16">
    <!-- Profil & Proker -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div data-reveal class="reveal md:col-span-2" style="perspective: 1000px">
            <div data-tilt class="tilt spot bg-white rounded-3xl p-8 border border-slate-200 shadow-sm h-full">
                <h2 class="text-2xl font-black text-slate-800 mb-4 relative inline-block">Profil Organisasi
                    <span class="absolute -bottom-1 left-0 h-1 w-1/2 bg-gradient-to-r from-emerald-500 to-amber-400 rounded-full"></span>
                </h2>
                <p class="text-sm text-slate-600 leading-relaxed font-medium">{{ $org['about'] }}</p>
            </div>
        </div>
        <div data-reveal style="--d: 150ms" class="reveal glow-border shadow-xl shadow-emerald-900/20">
            <div class="bg-emerald-900 rounded-[calc(1.5rem-2px)] p-8 text-white h-full">
                <h3 class="text-xl font-extrabold mb-4 border-b border-emerald-700 pb-2">Program Kerja Utama</h3>
                <ul class="space-y-3 text-xs text-emerald-100 font-medium">
                    @foreach($org['proker'] as $proker)
                        <li data-reveal style="--d: {{ 250 + $loop->index * 110 }}ms" class="reveal-x flex items-start gap-2 hover:translate-x-1 transition-transform duration-300"><span class="check-pop text-amber-400">&#10004;</span><span>{{ $proker }}</span></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Daftar Pengurus -->
    <div>
        <h2 data-reveal data-split class="title-line block text-2xl sm:text-3xl font-black text-slate-800 pb-3 mb-8" style="perspective: 600px">Pengurus {{ $org['title'] }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($committees as $committee)
                <div data-reveal style="--d: {{ ($loop->index % 4) * 120 }}ms; perspective: 1000px" class="reveal group h-full">
                    <div data-tilt class="tilt spot bg-white rounded-2xl p-6 border border-slate-200 shadow-sm text-center h-full">
                        <div class="avatar-pop flex justify-center mb-4" style="--d: {{ ($loop->index % 4) * 120 }}ms">
                            <span class="avatar-ring">
                                <img src="{{ asset('storage/' . $committee->image) }}" class="w-24 h-24 object-cover rounded-full mx-auto" onerror="this.outerHTML='<div class=\'w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-800 font-bold text-2xl mx-auto\'>{{ strtoupper(substr($committee->name,0,1)) }}</div>'">
                            </span>
                        </div>
                        <h3 class="font-extrabold text-slate-800 text-base mb-1 group-hover:text-emerald-700 transition-colors duration-300">{{ $committee->name }}</h3>
                        <p class="text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100 inline-block group-hover:bg-emerald-600 group-hover:text-white group-hover:border-emerald-600 transition-colors duration-300">{{ $committee->position }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8 text-slate-400 font-medium text-xs border border-dashed rounded-2xl">Belum ada pengurus terdaftar.</div>
            @endforelse
        </div>
    </div>
</div>

{{-- Mesin animasi (murni visual: tidak menyentuh data atau fungsi) --}}
<script>
(function () {
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    document.documentElement.classList.add('fx');

    /* Pecah judul jadi huruf */
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

    /* Reveal berulang: jalan saat scroll ke bawah maupun ke atas */
    var els = document.querySelectorAll('[data-reveal]');
    function show(t) { t.classList.add('in'); }
    function hide(t) { t.classList.remove('in'); }
    if (!('IntersectionObserver' in window)) { els.forEach(show); }
    else {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) { if (en.isIntersecting) show(en.target); else hide(en.target); });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
        els.forEach(function (e) { io.observe(e); });
    }

    /* Progress scroll + fallback anti-hilang */
    var bar = document.getElementById('scrollbar-fx');
    function onScroll() {
        els.forEach(function (el) {
            if (el.classList.contains('in')) return;
            var r = el.getBoundingClientRect();
            if (r.top < window.innerHeight - 60 && r.bottom > 60) show(el);
        });
        var h = document.documentElement.scrollHeight - window.innerHeight;
        bar.style.transform = 'scaleX(' + (h > 0 ? window.scrollY / h : 0) + ')';
    }
    window.addEventListener('scroll', onScroll, { passive: true }); onScroll();
    setTimeout(onScroll, 1200); setTimeout(onScroll, 3000);

    if (reduce || !fine) return; /* efek mouse hanya untuk desktop */

    /* Cursor glow */
    var glow = document.getElementById('cursor-glow'), gx = 0, gy = 0, ticking = false;
    window.addEventListener('pointermove', function (e) {
        gx = e.clientX; gy = e.clientY; glow.style.opacity = 1;
        if (!ticking) { ticking = true; requestAnimationFrame(function () { glow.style.transform = 'translate(' + gx + 'px,' + gy + 'px)'; ticking = false; }); }
    });
    document.addEventListener('mouseleave', function () { glow.style.opacity = 0; });

    /* Tilt 3D + spotlight */
    document.querySelectorAll('[data-tilt]').forEach(function (card) {
        card.addEventListener('pointermove', function (e) {
            var r = card.getBoundingClientRect(), x = (e.clientX - r.left) / r.width, y = (e.clientY - r.top) / r.height;
            card.classList.remove('leaving');
            card.style.setProperty('--mx', (x * 100) + '%'); card.style.setProperty('--my', (y * 100) + '%');
            card.style.transform = 'rotateX(' + ((0.5 - y) * 8) + 'deg) rotateY(' + ((x - 0.5) * 10) + 'deg) translateY(-8px)';
        });
        card.addEventListener('pointerleave', function () { card.classList.add('leaving'); card.style.transform = ''; });
    });

    /* Parallax hero mengikuti mouse */
    var hero = document.getElementById('hero-org');
    if (hero) {
        hero.addEventListener('pointermove', function (e) {
            var r = hero.getBoundingClientRect();
            hero.style.setProperty('--px', ((e.clientX - r.left) / r.width - 0.5) * 2);
            hero.style.setProperty('--py', ((e.clientY - r.top) / r.height - 0.5) * 2);
        });
        hero.addEventListener('pointerleave', function () { hero.style.setProperty('--px', 0); hero.style.setProperty('--py', 0); });
    }
})();
</script>
@endsection