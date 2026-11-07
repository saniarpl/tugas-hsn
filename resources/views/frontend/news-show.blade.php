@extends('layouts.app')

@section('title', $item->title . ' - WANUWIN')
@section('meta_description', \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($item->content))), 160, ''))
@section('canonical', route('news.show', $item->id))
@section('og_type', 'article')
@section('og_title', $item->title . ' - WANUWIN')
@section('og_description', \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($item->content))), 160, ''))
@section('og_image', $item->image ? asset('storage/' . $item->image) : asset('favicon.ico'))
@section('meta')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'NewsArticle',
    'headline' => $item->title,
    'image' => $item->image ? [asset('storage/' . $item->image)] : [],
    'datePublished' => optional($item->created_at)->toIso8601String(),
    'dateModified' => optional($item->updated_at)->toIso8601String(),
    'author' => [['@type' => 'Organization', 'name' => 'WANUWIN - NU Windunegara']],
    'publisher' => ['@type' => 'Organization', 'name' => 'WANUWIN', 'logo' => ['@type' => 'ImageObject', 'url' => asset('favicon.ico')]],
    'description' => \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($item->content))), 160, ''),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}
</script>
@endsection

@section('content')
@php
    $shareUrl = route('news.show', $item->id);
    $shareText = $item->title;
@endphp

<div class="mx-auto max-w-4xl px-4 py-8 sm:px-6">
    <nav aria-label="Breadcrumb" class="mb-6 flex flex-wrap items-center gap-2 text-[11px] font-semibold text-slate-500">
        <a href="{{ route('home') }}" class="transition-colors hover:text-emerald-800">Beranda</a>
        <span class="text-slate-300" aria-hidden="true">/</span>
        <a href="{{ route('home') }}#berita" class="transition-colors hover:text-emerald-800">Berita</a>
        <span class="text-slate-300" aria-hidden="true">/</span>
        <span class="max-w-[220px] truncate text-slate-700 sm:max-w-md">{{ $item->title }}</span>
    </nav>

    <article class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        @if($item->image)
            <div class="aspect-[16/9] w-full overflow-hidden bg-slate-100">
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="h-full w-full object-cover">
            </div>
        @endif

        <div class="p-6 sm:p-10">
            <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-emerald-700">Warta Berita</p>
            <h1 class="mt-2 text-2xl font-bold leading-tight tracking-tight text-slate-900 sm:text-4xl">{{ $item->title }}</h1>

            <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2 border-b border-slate-200 pb-5 text-xs font-medium text-slate-500">
                <span class="inline-flex items-center gap-1.5">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('d F Y') }}
                </span>
                @if(!empty($item->author))
                    <span class="inline-flex items-center gap-1.5">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        {{ $item->author }}
                    </span>
                @endif
            </div>

            <div class="article-body mt-6 whitespace-pre-line text-[15px] text-slate-700">{!! nl2br(e($item->content)) !!}</div>

            {{-- Bagikan --}}
            <div class="mt-10 border-t border-slate-200 pt-6">
                <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">Bagikan berita ini</p>
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
                    <a href="https://t.me/share/url?url={{ rawurlencode($shareUrl) }}&text={{ rawurlencode($shareText) }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 rounded-md border border-slate-300 bg-white px-4 py-2.5 text-xs font-bold text-slate-700 transition-colors hover:border-emerald-300 hover:text-emerald-800">
                        Telegram
                    </a>
                    <button type="button" onclick="salinTautan(this)" data-link="{{ $shareUrl }}"
                            class="inline-flex items-center gap-2 rounded-md border border-slate-300 bg-slate-50 px-4 py-2.5 text-xs font-bold text-slate-700 transition-colors hover:border-emerald-300 hover:text-emerald-800">
                        Salin Tautan
                    </button>
                </div>
                <p id="salin-notif" class="mt-2 hidden text-[11px] font-bold text-emerald-700">Tautan berhasil disalin!</p>
            </div>

            <div class="mt-8">
                <a href="{{ route('home') }}#berita" class="inline-flex items-center gap-2 rounded-md bg-[#065F46] px-5 py-3 text-xs font-bold text-white transition-colors hover:bg-[#054F3A]">
                    <span aria-hidden="true">&larr;</span> Kembali ke Berita
                </a>
            </div>
        </div>
    </article>

    {{-- Berita terkait --}}
    @if(isset($related) && count($related))
        <section class="mt-12">
            <div class="mb-6 border-b border-slate-200 pb-4">
                <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-emerald-700">Arsip</p>
                <h2 class="mt-1 text-xl font-bold text-slate-900 sm:text-2xl">Berita Terkait</h2>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                @foreach($related as $rel)
                    <a href="{{ route('news.show', $rel->id) }}" class="group flex flex-col overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition-colors hover:border-emerald-300">
                        @if($rel->image)
                            <div class="aspect-[16/10] overflow-hidden bg-slate-100">
                                <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->title }}" loading="lazy"
                                     class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-[1.03]">
                            </div>
                        @else
                            <div class="flex aspect-[16/10] items-center justify-center bg-[#064E3B] text-2xl font-extrabold text-white/80">NU</div>
                        @endif
                        <div class="p-4">
                            <p class="text-[10px] font-bold uppercase tracking-wide text-emerald-700">{{ \Carbon\Carbon::parse($rel->created_at)->locale('id')->translatedFormat('d M Y') }}</p>
                            <h3 class="mt-1 text-sm font-bold leading-snug text-slate-900 line-clamp-2 transition-colors group-hover:text-emerald-800">{{ $rel->title }}</h3>
                        </div>
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
