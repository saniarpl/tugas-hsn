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

<div class="max-w-4xl mx-auto px-6 py-8">
    {{-- Breadcrumb --}}
    <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-[11px] font-bold text-slate-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-emerald-700 transition">Beranda</a>
        <span aria-hidden="true" class="text-slate-300">/</span>
        <a href="{{ route('home') }}#berita" class="hover:text-emerald-700 transition">Berita</a>
        <span aria-hidden="true" class="text-slate-300">/</span>
        <span class="text-slate-800 truncate max-w-[200px] sm:max-w-md">{{ $item->title }}</span>
    </nav>

    <article class="bg-white rounded-[2rem] overflow-hidden border border-slate-200 shadow-xl shadow-emerald-900/5">
        @if($item->image)
            <div class="relative h-64 sm:h-96 overflow-hidden">
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>
                <span class="absolute bottom-4 left-4 sm:left-6 text-[10px] text-white font-bold uppercase tracking-wider bg-emerald-700/80 backdrop-blur-md border border-white/20 px-3 py-1.5 rounded-full">
                    {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                </span>
            </div>
        @endif

        <div class="p-6 sm:p-10">
            <h1 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight">{{ $item->title }}</h1>
            <p class="mt-3 text-xs font-semibold text-slate-500">
                Dipublikasikan {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}
                &bull; {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
            </p>

            <div class="mt-6 text-sm sm:text-base text-slate-700 leading-relaxed font-medium whitespace-pre-line">{!! nl2br(e($item->content)) !!}</div>

            {{-- Bagikan --}}
            <div class="mt-10 pt-6 border-t border-slate-100">
                <p class="text-[11px] font-extrabold uppercase tracking-widest text-slate-500 mb-3">Bagikan berita ini</p>
                <div class="flex flex-wrap gap-2.5">
                    <a href="https://wa.me/?text={{ rawurlencode($shareText . ' ' . $shareUrl) }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 text-xs font-bold px-4 py-2.5 rounded-xl bg-[#25D366] text-white hover:brightness-95 transition active:scale-95">
                        WhatsApp
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode($shareUrl) }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 text-xs font-bold px-4 py-2.5 rounded-xl bg-[#1877F2] text-white hover:brightness-95 transition active:scale-95">
                        Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ rawurlencode($shareText) }}&url={{ rawurlencode($shareUrl) }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 text-xs font-bold px-4 py-2.5 rounded-xl bg-slate-900 text-white hover:bg-slate-700 transition active:scale-95">
                        X / Twitter
                    </a>
                    <a href="https://t.me/share/url?url={{ rawurlencode($shareUrl) }}&text={{ rawurlencode($shareText) }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 text-xs font-bold px-4 py-2.5 rounded-xl bg-[#229ED9] text-white hover:brightness-95 transition active:scale-95">
                        Telegram
                    </a>
                    <button type="button" onclick="salinTautan(this)" data-link="{{ $shareUrl }}"
                       class="inline-flex items-center gap-2 text-xs font-bold px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 border border-slate-200 transition active:scale-95">
                        Salin Tautan
                    </button>
                </div>
                <p id="salin-notif" class="hidden mt-2 text-[11px] font-bold text-emerald-700">Tautan berhasil disalin!</p>
            </div>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('home') }}#berita" class="inline-flex items-center gap-2 text-xs font-bold px-5 py-3 rounded-xl bg-slate-900 text-white hover:bg-emerald-700 transition">
                    &larr; Kembali ke Berita
                </a>
            </div>
        </div>
    </article>

    {{-- Berita terkait --}}
    @if(isset($related) && count($related))
        <div class="mt-12">
            <h2 class="text-xl sm:text-2xl font-black text-slate-800 mb-6">Berita Terkait</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                @foreach($related as $rel)
                    <a href="{{ route('news.show', $rel->id) }}" class="group bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        @if($rel->image)
                            <div class="h-36 overflow-hidden">
                                <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            </div>
                        @else
                            <div class="h-36 bg-gradient-to-br from-emerald-800 to-emerald-950 flex items-center justify-center text-white font-black text-2xl">NU</div>
                        @endif
                        <div class="p-4">
                            <p class="text-[10px] font-bold text-emerald-700 uppercase">{{ \Carbon\Carbon::parse($rel->created_at)->translatedFormat('d M Y') }}</p>
                            <h3 class="mt-1 font-extrabold text-slate-800 text-sm leading-snug line-clamp-2 group-hover:text-emerald-700 transition">{{ $rel->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
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
