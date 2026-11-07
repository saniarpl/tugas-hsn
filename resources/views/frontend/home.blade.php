@extends('layouts.app')

@section('content')

@php
    $newsItems = $news ?? collect();
    $newsGrid = $newsItems->count() === 4 ? 'sm:grid-cols-2 xl:grid-cols-4' : 'sm:grid-cols-2 lg:grid-cols-3';
    $activityGrid = ($activities ?? collect())->count() === 3 ? 'lg:grid-cols-3' : 'md:grid-cols-2';
    $galleryGrid = ($galleries ?? collect())->count() <= 2 ? 'sm:grid-cols-2' : 'sm:grid-cols-2 lg:grid-cols-3';
    $cleanText = fn ($text) => trim(preg_replace('/[\x{1F000}-\x{1FAFF}\x{2600}-\x{27BF}\x{FE0F}\x{200D}]/u', '', (string) $text));
@endphp

<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-10">

    {{-- Sorotan utama --}}
    <section id="hero-carousel"
             class="relative overflow-hidden rounded-lg border border-slate-200 bg-[#043D2B] shadow-sm"
             x-data="{
                 active: 0,
                 total: {{ count($carousels ?? []) }},
                 paused: false,
                 init() {
                     if (this.total < 2) return;
                     setInterval(() => {
                         if (!this.paused) this.active = (this.active + 1) % this.total;
                     }, 7000);
                 },
                 next() { this.active = (this.active + 1) % this.total; },
                 prev() { this.active = (this.active - 1 + this.total) % this.total; }
             }"
             @mouseenter="paused = true"
             @mouseleave="paused = false">

        @if(isset($carousels) && count($carousels) > 0)
            <div class="relative h-[360px] sm:h-[440px] lg:h-[500px]">
                @foreach($carousels as $key => $carousel)
                    <div x-cloak x-show="active === {{ $key }}" class="absolute inset-0">
                        <img src="{{ asset('storage/' . $carousel->image) }}" alt="{{ $carousel->title }}" class="absolute inset-0 h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#022c22]/90 via-[#022c22]/60 to-[#022c22]/20"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-[#022c22]/50 via-transparent to-transparent"></div>

                        <div class="relative z-10 flex h-full items-end p-6 pb-14 sm:p-10 sm:pb-16 lg:p-12">
                            <div class="max-w-3xl">
                                <span class="inline-flex items-center gap-2 rounded border border-amber-300/40 bg-amber-300/10 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-amber-300">
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-300" aria-hidden="true"></span>
                                    Informasi Resmi
                                </span>

                                @if($key === 0)
                                    <h1 class="mt-4 text-2xl font-bold leading-tight text-white sm:text-4xl lg:text-5xl">{{ $carousel->title }}</h1>
                                @else
                                    <h2 class="mt-4 text-2xl font-bold leading-tight text-white sm:text-4xl lg:text-5xl">{{ $carousel->title }}</h2>
                                @endif

                                @if($carousel->description)
                                    <p class="mt-3 max-w-2xl text-sm leading-6 text-emerald-50/85 line-clamp-2 sm:text-base">{{ $cleanText($carousel->description) }}</p>
                                @endif

                                <a href="#berita" class="mt-5 inline-flex items-center gap-2 rounded-md bg-white px-4 py-2.5 text-xs font-bold text-emerald-900 transition-colors hover:bg-emerald-50">
                                    Lihat Warta Berita
                                    <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if(count($carousels) > 1)
                    <div class="absolute right-4 top-4 z-20 flex items-center gap-2 sm:right-6 sm:top-6">
                        <span class="rounded bg-black/25 px-2.5 py-1.5 text-[11px] font-semibold tabular-nums text-white/85">
                            <span x-text="String(active + 1).padStart(2, '0')"></span> / <span x-text="String(total).padStart(2, '0')"></span>
                        </span>
                        <button type="button" @click="prev()" aria-label="Banner sebelumnya"
                                class="grid h-9 w-9 place-items-center rounded border border-white/25 bg-black/25 text-white transition-colors hover:bg-white hover:text-emerald-900">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button type="button" @click="next()" aria-label="Banner berikutnya"
                                class="grid h-9 w-9 place-items-center rounded border border-white/25 bg-black/25 text-white transition-colors hover:bg-white hover:text-emerald-900">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>

                    <div class="absolute bottom-4 right-5 z-20 flex items-center gap-1.5 sm:bottom-5 sm:right-8">
                        @foreach($carousels as $key => $carousel)
                            <button type="button" @click="active = {{ $key }}" :aria-label="'Tampilkan banner ' + {{ $key + 1 }}"
                                    :class="active === {{ $key }} ? 'w-6 bg-amber-400' : 'w-2 bg-white/50 hover:bg-white/80'"
                                    class="h-2 rounded-full transition-all duration-200"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="px-6 py-14 sm:px-12 sm:py-20">
                <span class="inline-flex items-center gap-2 rounded border border-amber-300/40 bg-amber-300/10 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-amber-300">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-300" aria-hidden="true"></span>
                    Portal Resmi
                </span>
                <h1 class="mt-4 max-w-3xl text-3xl font-bold leading-tight text-white sm:text-5xl">Ranting Nahdlatul Ulama Desa Windunegara</h1>
                <p class="mt-4 max-w-2xl text-sm leading-7 text-emerald-50/80 sm:text-base">Menyajikan warta kegiatan, agenda jam'iyyah, dokumentasi, dan layanan infaq Masjid NU Desa Windunegara.</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="#berita" class="rounded-md bg-white px-4 py-2.5 text-xs font-bold text-emerald-900 transition-colors hover:bg-emerald-50">Lihat Warta</a>
                    <a href="#infaq" class="rounded-md border border-white/25 px-4 py-2.5 text-xs font-bold text-white transition-colors hover:bg-white/10">Infaq Masjid</a>
                </div>
            </div>
        @endif
    </section>

    {{-- Akses cepat --}}
    <div class="mt-5 grid gap-4 sm:grid-cols-3">
        <a href="#berita" class="group flex items-start gap-4 rounded-lg border border-slate-200 bg-white p-5 transition-colors hover:border-emerald-300">
            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-md bg-emerald-50 text-emerald-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            </span>
            <span>
                <span class="block text-sm font-bold text-slate-900">Warta Berita</span>
                <span class="mt-1 block text-xs leading-5 text-slate-500">Informasi terbaru seputar kegiatan jam'iyyah.</span>
            </span>
        </a>
        <a href="#kegiatan" class="group flex items-start gap-4 rounded-lg border border-slate-200 bg-white p-5 transition-colors hover:border-emerald-300">
            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-md bg-emerald-50 text-emerald-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </span>
            <span>
                <span class="block text-sm font-bold text-slate-900">Agenda Kegiatan</span>
                <span class="mt-1 block text-xs leading-5 text-slate-500">Jadwal pengajian, majelis, dan kegiatan warga.</span>
            </span>
        </a>
        <a href="#infaq" class="group flex items-start gap-4 rounded-lg border border-slate-200 bg-white p-5 transition-colors hover:border-emerald-300">
            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-md bg-emerald-50 text-emerald-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </span>
            <span>
                <span class="block text-sm font-bold text-slate-900">Infaq Masjid</span>
                <span class="mt-1 block text-xs leading-5 text-slate-500">Dukung pembangunan dan operasional masjid.</span>
            </span>
        </a>
    </div>

    <div class="mt-14 space-y-16 sm:mt-16 sm:space-y-20">

        {{-- Warta berita --}}
        <section id="berita" class="scroll-mt-24">
            <x-section-heading eyebrow="Publikasi" title="Warta Berita NU" />

            <div class="grid gap-6 {{ $newsGrid }}">
                @forelse($newsItems as $item)
                    <article class="group flex flex-col overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition-colors hover:border-emerald-300">
                        <a href="{{ route('news.show', $item->id) }}" class="block aspect-[16/10] overflow-hidden bg-emerald-900" aria-label="{{ $item->title }}">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" loading="lazy"
                                     class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-[1.03]">
                            @else
                                <span class="flex h-full w-full items-center justify-center bg-[#064E3B] text-3xl font-extrabold text-white/80">NU</span>
                            @endif
                        </a>

                        <div class="flex flex-1 flex-col p-5">
                            <time datetime="{{ optional($item->created_at)->toDateString() }}" class="text-[11px] font-bold uppercase tracking-wide text-emerald-700">
                                {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('d F Y') }}
                            </time>
                            <h3 class="mt-2 text-base font-bold leading-snug text-slate-900">
                                <a href="{{ route('news.show', $item->id) }}" class="transition-colors hover:text-emerald-800">{{ $item->title }}</a>
                            </h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600 line-clamp-3">
                                {{ \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($item->content))), 150) }}
                            </p>
                            <a href="{{ route('news.show', $item->id) }}" class="mt-auto inline-flex items-center gap-1.5 pt-4 text-xs font-bold text-emerald-700 transition-colors hover:text-emerald-900">
                                Selengkapnya
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-lg border border-dashed border-slate-300 bg-white px-6 py-10 text-center text-sm text-slate-500">
                        Belum ada warta berita terbaru.
                    </div>
                @endforelse
            </div>
        </section>

        {{-- Infaq masjid --}}
        <section id="infaq" class="scroll-mt-24">
            <x-section-heading eyebrow="Kepedulian" title="Infaq & Amal Jariyah" />

            <div class="grid items-start gap-6 lg:grid-cols-2">
                <div class="rounded-lg bg-[#064E3B] p-7 text-white sm:p-9">
                    <span class="inline-block rounded border border-amber-400/40 bg-amber-400/10 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.14em] text-amber-300">
                        Kas Pembangunan Masjid
                    </span>
                    <h3 class="mt-4 text-xl font-bold leading-snug sm:text-2xl">Salurkan Sedekah Terbaik Anda</h3>
                    <p class="mt-3 text-sm leading-6 text-emerald-50/80">
                        Bantu operasional dakwah dan pembangunan sarana ibadah Ranting NU Desa Windunegara. Insya Allah pahala akan terus mengalir.
                    </p>

                    <div class="mt-7 rounded-lg border border-white/15 bg-white/5 p-5">
                        <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-amber-300">Bank Rakyat Indonesia (BRI)</p>
                        <p class="mt-2 break-all font-mono text-xl font-bold tracking-wider text-white sm:text-2xl">6823-01-029182-53-1</p>
                        <p class="mt-2 text-xs text-emerald-100/70">a.n. Panitia Pembangunan / NU Windunegara</p>
                    </div>

                    <p class="mt-4 text-[11px] leading-5 text-emerald-100/60">Mohon cantumkan keterangan "Infaq Masjid" pada berita transfer.</p>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex items-center justify-between gap-4 border-b border-slate-200 pb-4">
                        <h3 class="text-base font-bold text-slate-900">Riwayat Donasi Terakhir</h3>
                        <span class="rounded border border-emerald-100 bg-emerald-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-emerald-700">Terbaru</span>
                    </div>

                    <ul class="divide-y divide-slate-100">
                        @forelse($donations as $donasi)
                            <li class="flex items-center justify-between gap-4 py-4">
                                <div class="flex min-w-0 items-center gap-3">
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-emerald-50 text-sm font-bold text-emerald-800">
                                        {{ strtoupper(substr($donasi->name, 0, 1)) }}
                                    </span>
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-slate-800">{{ $donasi->name }}</p>
                                        <p class="mt-0.5 text-[11px] text-slate-500">
                                            {{ \Carbon\Carbon::parse($donasi->date)->locale('id')->translatedFormat('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                                <span class="shrink-0 text-sm font-bold tabular-nums text-emerald-800">
                                    Rp {{ number_format($donasi->amount, 0, ',', '.') }}
                                </span>
                            </li>
                        @empty
                            <li class="py-8 text-center text-sm text-slate-500">Belum ada data donasi.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </section>

        {{-- Agenda kegiatan --}}
        <section id="kegiatan" class="scroll-mt-24">
            <x-section-heading eyebrow="Kalender Jam'iyyah" title="Agenda Kegiatan" />

            <div class="grid gap-5 {{ $activityGrid }}">
                @forelse($activities ?? [] as $activity)
                    <article class="group flex gap-4 rounded-lg border border-slate-200 bg-white p-5 shadow-sm transition-colors hover:border-emerald-300 sm:p-6">
                        <div class="flex h-16 w-14 shrink-0 flex-col items-center justify-center rounded-md border border-emerald-100 bg-emerald-50">
                            <span class="text-[10px] font-bold uppercase tracking-wide text-emerald-700">
                                {{ \Carbon\Carbon::parse($activity->date)->locale('id')->translatedFormat('M') }}
                            </span>
                            <span class="text-xl font-extrabold leading-tight text-emerald-900">
                                {{ \Carbon\Carbon::parse($activity->date)->locale('id')->translatedFormat('d') }}
                            </span>
                        </div>

                        <div class="min-w-0">
                            <h3 class="text-base font-bold leading-snug text-slate-900">
                                <a href="{{ route('activities.show', $activity->id) }}" class="transition-colors hover:text-emerald-800">{{ $activity->title }}</a>
                            </h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600 line-clamp-2">{{ $activity->description }}</p>

                            <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-1 text-[11px] font-medium text-slate-500">
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ \Carbon\Carbon::parse($activity->date)->locale('id')->translatedFormat('d F Y') }}
                                </span>
                                @if($activity->location)
                                    <span class="inline-flex items-center gap-1.5">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ $activity->location }}
                                    </span>
                                @endif
                            </div>

                            <a href="{{ route('activities.show', $activity->id) }}" class="mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 transition-colors hover:text-emerald-900">
                                Detail agenda
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-lg border border-dashed border-slate-300 bg-white px-6 py-10 text-center text-sm text-slate-500">
                        Belum ada agenda terdaftar.
                    </div>
                @endforelse
            </div>
        </section>

        {{-- Galeri kegiatan --}}
        <section id="galeri" class="scroll-mt-24" x-data="galeriSection()">
            <x-section-heading eyebrow="Dokumentasi" title="Galeri Kegiatan">
                <x-slot:action>
                    @if(Route::has('gallery'))
                        <a href="{{ route('gallery') }}" class="inline-flex items-center gap-1.5 rounded-md border border-slate-300 bg-white px-3.5 py-2 text-xs font-bold text-slate-700 transition-colors hover:border-emerald-300 hover:text-emerald-800">
                            Lihat Semua Galeri
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    @endif
                </x-slot:action>
            </x-section-heading>

            <div class="grid grid-cols-1 gap-5 {{ $galleryGrid }}">
                @forelse($galleries ?? [] as $gallery)
                    <button type="button" @click="show({{ $loop->index }})"
                            data-full="{{ asset('storage/' . $gallery->image) }}"
                            data-title="{{ $gallery->title }}"
                            class="group overflow-hidden rounded-lg border border-slate-200 bg-white text-left shadow-sm transition-colors hover:border-emerald-300">
                        <span class="block aspect-[4/3] overflow-hidden bg-slate-100">
                            <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" loading="lazy"
                                 class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-[1.03]">
                        </span>
                        <span class="block p-4">
                            <span class="block text-sm font-semibold leading-snug text-slate-800 line-clamp-2">{{ $gallery->title }}</span>
                            <span class="mt-1 block text-[11px] font-medium text-emerald-700">Lihat foto</span>
                        </span>
                    </button>
                @empty
                    <div class="col-span-full rounded-lg border border-dashed border-slate-300 bg-white px-6 py-10 text-center text-sm text-slate-500">
                        Belum ada foto kegiatan.
                    </div>
                @endforelse
            </div>

            {{-- Pratinjau foto --}}
            <div x-cloak x-show="open" x-transition.opacity.duration.200ms
                 class="fixed inset-0 z-[80] flex items-center justify-center bg-slate-950/90 p-4"
                 role="dialog" aria-modal="true" aria-label="Pratinjau foto"
                 @click.self="close()" @keydown.escape.window="close()"
                 @keydown.arrow-right.window="if (open) next()" @keydown.arrow-left.window="if (open) prev()">
                <template x-if="images.length">
                    <figure class="relative w-full max-w-5xl">
                        <button type="button" @click="close()" aria-label="Tutup pratinjau"
                                class="absolute -top-3 right-0 z-10 grid h-9 w-9 place-items-center rounded-md bg-white text-slate-800 shadow sm:-right-3">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>

                        <img :src="images[index].src" :alt="images[index].title"
                             class="max-h-[78vh] w-full rounded-lg bg-slate-900 object-contain shadow-2xl">

                        <figcaption class="mt-3 flex items-center justify-between gap-4 text-white">
                            <span class="truncate text-sm font-semibold" x-text="images[index].title"></span>
                            <span class="shrink-0 text-xs font-semibold tabular-nums text-white/70">
                                <span class="text-amber-300" x-text="index + 1"></span> / <span x-text="images.length"></span>
                            </span>
                        </figcaption>

                        <template x-if="images.length > 1">
                            <div>
                                <button type="button" @click.stop="prev()" aria-label="Foto sebelumnya"
                                        class="absolute left-2 top-1/2 grid h-10 w-10 -translate-y-1/2 place-items-center rounded-md border border-white/20 bg-black/40 text-white transition-colors hover:bg-white hover:text-slate-900 sm:-left-14">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                </button>
                                <button type="button" @click.stop="next()" aria-label="Foto berikutnya"
                                        class="absolute right-2 top-1/2 grid h-10 w-10 -translate-y-1/2 place-items-center rounded-md border border-white/20 bg-black/40 text-white transition-colors hover:bg-white hover:text-slate-900 sm:-right-14">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </div>
                        </template>
                    </figure>
                </template>
            </div>
        </section>

        {{-- Saran dan kritik --}}
        <section id="saran" class="scroll-mt-24">

            @if(session('success'))
                <div class="mb-5 flex items-start justify-between gap-4 rounded-lg border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-900"
                     x-data="{ show: true }" x-show="show">
                    <p class="flex items-start gap-2.5">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>{{ session('success') }}</span>
                    </p>
                    <button type="button" @click="show = false" class="text-emerald-700 hover:text-emerald-900" aria-label="Tutup pesan">&times;</button>
                </div>
            @endif

            <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
                <div class="grid lg:grid-cols-5">
                    <div class="bg-[#064E3B] p-7 text-white sm:p-9 lg:col-span-2">
                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-amber-300">Layanan Pengunjung</p>
                        <h2 class="mt-2 text-2xl font-bold">Saran &amp; Kritik</h2>
                        <p class="mt-3 text-sm leading-6 text-emerald-50/80">
                            Sampaikan masukan Anda untuk kemajuan jam'iyyah NU Desa Windunegara. Setiap pesan akan ditinjau oleh pengurus.
                        </p>

                        <div class="mt-8 space-y-4 border-t border-white/15 pt-6 text-sm">
                            <p class="flex items-start gap-3">
                                <svg class="mt-0.5 h-4 w-4 shrink-0 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="text-emerald-50/80">Sekretariat Ranting NU Windunegara, Kec. Wangon, Kab. Banyumas.</span>
                            </p>
                            <p class="flex items-center gap-3">
                                <svg class="h-4 w-4 shrink-0 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <a href="tel:08123456789" class="transition-colors hover:text-white">0812-3456-789</a>
                            </p>
                        </div>
                    </div>

                    <div class="p-6 sm:p-9 lg:col-span-3">
                        <form action="{{ route('feedback.store') }}" method="POST" class="space-y-5">
                            @csrf
                            {{-- Honeypot anti-spam: wajib kosong --}}
                            <div class="hidden" aria-hidden="true">
                                <label>Jangan isi kolom ini<input type="text" name="website" value="" tabindex="-1" autocomplete="off"></label>
                            </div>

                            @if($errors->any())
                                <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-xs font-semibold text-red-700" role="alert">
                                    <ul class="list-inside list-disc space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="saran-nama" class="mb-1.5 block text-xs font-bold text-slate-700">Nama Lengkap</label>
                                    <input id="saran-nama" type="text" name="name" value="{{ old('name') }}" required minlength="3" maxlength="100" autocomplete="name" placeholder="Contoh: Ahmad"
                                           class="w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-800 outline-none transition-colors focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 @error('name') border-red-400 @enderror">
                                    @error('name')<p class="mt-1 text-[11px] font-semibold text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="saran-kontak" class="mb-1.5 block text-xs font-bold text-slate-700">Nomor WhatsApp</label>
                                    <input id="saran-kontak" type="text" name="contact" value="{{ old('contact') }}" maxlength="30" autocomplete="tel" placeholder="08xxxxxxxxxx"
                                           class="w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-800 outline-none transition-colors focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 @error('contact') border-red-400 @enderror">
                                    @error('contact')<p class="mt-1 text-[11px] font-semibold text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div>
                                <label for="saran-pesan" class="mb-1.5 block text-xs font-bold text-slate-700">Isi Masukan</label>
                                <textarea id="saran-pesan" name="message" rows="5" required minlength="10" maxlength="2000" placeholder="Tuliskan saran atau masukan Anda (minimal 10 karakter)..."
                                          class="w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-800 outline-none transition-colors focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                                @error('message')<p class="mt-1 text-[11px] font-semibold text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-md bg-[#065F46] px-5 py-3 text-sm font-bold text-white transition-colors hover:bg-[#054F3A]">
                                Kirim Pesan
                                <span aria-hidden="true">&rarr;</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

<script>
    function galeriSection() {
        return {
            open: false,
            index: 0,
            images: [],
            init: function () {
                this.images = Array.from(this.$el.querySelectorAll('[data-full]')).map(function (el) {
                    return { src: el.getAttribute('data-full'), title: el.getAttribute('data-title') || '' };
                });
            },
            show: function (i) {
                if (!this.images.length) return;
                this.index = i;
                this.open = true;
                document.body.style.overflow = 'hidden';
            },
            close: function () {
                this.open = false;
                document.body.style.overflow = '';
            },
            next: function () {
                this.index = (this.index + 1) % this.images.length;
            },
            prev: function () {
                this.index = (this.index - 1 + this.images.length) % this.images.length;
            }
        };
    }
</script>

@endsection
