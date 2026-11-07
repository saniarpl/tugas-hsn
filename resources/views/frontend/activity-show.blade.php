@extends('layouts.app')

@section('title', $item->title . ' - Agenda Kegiatan WANUWIN')
@section('meta_description', \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($item->description ?? ''))), 160, ''))
@section('canonical', route('activities.show', $item->id))
@section('og_type', 'article')
@section('og_title', $item->title . ' - WANUWIN')
@section('og_description', \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($item->description ?? ''))), 160, ''))
@section('og_image', $item->image ? image_url($item->image) : asset('favicon.ico'))

@section('content')
@php
    $shareUrl = route('activities.show', $item->id);
    $shareText = $item->title;
@endphp

<div class="mx-auto max-w-4xl px-4 py-8 sm:px-6">
    <nav aria-label="Breadcrumb" class="mb-6 flex flex-wrap items-center gap-2 text-[11px] font-semibold text-slate-500">
        <a href="{{ route('home') }}" class="transition-colors hover:text-emerald-800">Beranda</a>
        <span class="text-slate-300" aria-hidden="true">/</span>
        <a href="{{ route('home') }}#kegiatan" class="transition-colors hover:text-emerald-800">Kegiatan</a>
        <span class="text-slate-300" aria-hidden="true">/</span>
        <span class="max-w-[220px] truncate text-slate-700 sm:max-w-md">{{ $item->title }}</span>
    </nav>

    <article class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        @if($item->image)
            <div class="aspect-[16/9] w-full overflow-hidden bg-slate-100">
                <img src="{{ image_url($item->image) }}" alt="{{ $item->title }}" class="h-full w-full object-cover">
            </div>
        @endif

        <div class="p-6 sm:p-10">
            <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-emerald-700">Agenda Kegiatan</p>
            <h1 class="mt-2 text-2xl font-bold leading-tight tracking-tight text-slate-900 sm:text-4xl">{{ $item->title }}</h1>

            <div class="mt-4 flex flex-wrap items-center gap-2 border-b border-slate-200 pb-5 text-[11px] font-bold text-slate-600">
                @if($item->date)
                    <span class="inline-flex items-center gap-1.5 rounded border border-emerald-100 bg-emerald-50 px-3 py-1.5 text-emerald-800">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($item->date)->locale('id')->translatedFormat('d F Y') }}
                    </span>
                @endif
                @if($item->location)
                    <span class="inline-flex items-center gap-1.5 rounded border border-amber-200 bg-amber-50 px-3 py-1.5 text-amber-900">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $item->location }}
                    </span>
                @endif
            </div>

            <div class="article-body mt-6 whitespace-pre-line text-[15px] text-slate-700">{!! nl2br(e($item->description)) !!}</div>

            <div class="mt-10 border-t border-slate-200 pt-6">
                <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Bagikan kegiatan ini</p>
                <div class="mt-3 flex flex-wrap gap-2.5">
                    <a href="https://wa.me/?text={{ rawurlencode($shareText . ' ' . $shareUrl) }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 rounded-md border border-slate-300 bg-white px-4 py-2.5 text-xs font-bold text-slate-700 transition-colors hover:border-emerald-300 hover:text-emerald-800">
                        WhatsApp
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode($shareUrl) }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 rounded-md border border-slate-300 bg-white px-4 py-2.5 text-xs font-bold text-slate-700 transition-colors hover:border-emerald-300 hover:text-emerald-800">
                        Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ rawurlencode($shareText) }}&url={{ rawurlencode($shareUrl) }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 rounded-md border border-slate-300 bg-white px-4 py-2.5 text-xs font-bold text-slate-700 transition-colors hover:border-emerald-300 hover:text-emerald-800">
                        X / Twitter
                    </a>
                    <button type="button" onclick="salinTautan(this)" data-link="{{ $shareUrl }}"
                            class="inline-flex items-center gap-2 rounded-md border border-slate-300 bg-slate-50 px-4 py-2.5 text-xs font-bold text-slate-700 transition-colors hover:border-emerald-300 hover:text-emerald-800">
                        Salin Tautan
                    </button>
                </div>
                <p id="salin-notif" class="mt-2 hidden text-[11px] font-bold text-emerald-700">Tautan berhasil disalin!</p>
            </div>

            <div class="mt-8">
                <a href="{{ route('home') }}#kegiatan" class="inline-flex items-center gap-2 rounded-md bg-[#065F46] px-5 py-3 text-xs font-bold text-white transition-colors hover:bg-[#054F3A]">
                    <span aria-hidden="true">&larr;</span> Kembali ke Kegiatan
                </a>
            </div>
        </div>
    </article>

    @if(isset($related) && count($related))
        <section class="mt-12">
            <div class="mb-6 border-b border-slate-200 pb-4">
                <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-emerald-700">Kalender</p>
                <h2 class="mt-1 text-xl font-bold text-slate-900 sm:text-2xl">Kegiatan Lainnya</h2>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                @foreach($related as $rel)
                    <a href="{{ route('activities.show', $rel->id) }}" class="group rounded-lg border border-slate-200 bg-white p-5 shadow-sm transition-colors hover:border-emerald-300">
                        <h3 class="text-sm font-bold leading-snug text-slate-900 transition-colors group-hover:text-emerald-800">{{ $rel->title }}</h3>
                        <p class="mt-1 text-xs leading-5 text-slate-500 line-clamp-2">{{ $rel->description }}</p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>

<script>
function salinTautan(btn) {
    var link = btn.getAttribute('data-link');
    var notif = document.getElementById('salin-notif');
    function done() { if (notif) notif.classList.remove('hidden'); btn.textContent = 'Tersalin!'; }
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(link).then(done).catch(function () { fallback(); });
    } else { fallback(); }
    function fallback() {
        var ta = document.createElement('textarea');
        ta.value = link; document.body.appendChild(ta); ta.select();
        try { document.execCommand('copy'); done(); } catch (e) {}
        document.body.removeChild(ta);
    }
}
</script>
@endsection
