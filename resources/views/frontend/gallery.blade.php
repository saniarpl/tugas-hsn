@extends('layouts.app')

@section('content')

{{-- Kepala halaman --}}
<div class="border-b border-slate-200 bg-white">
    <div class="mx-auto max-w-7xl px-6 py-10">
        <nav aria-label="Breadcrumb" class="flex flex-wrap items-center gap-2 text-[11px] font-semibold text-slate-500">
            <a href="{{ route('home') }}" class="transition-colors hover:text-emerald-800">Beranda</a>
            <span class="text-slate-300" aria-hidden="true">/</span>
            <span class="text-slate-700">Galeri</span>
        </nav>
        <p class="mt-5 text-[11px] font-bold uppercase tracking-[0.18em] text-emerald-700">Dokumentasi</p>
        <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Galeri Kegiatan NU Windunegara</h1>
        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">Dokumentasi visual kegiatan jam'iyyah. Klik foto untuk melihat pratinjau yang lebih besar.</p>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6" x-data="galeriPage()">
    @if(count($galleries))
        @php
            $galleryGrid = count($galleries) <= 2 ? 'sm:grid-cols-2' : 'sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4';
        @endphp
        <div class="grid grid-cols-1 gap-5 {{ $galleryGrid }}">
            @foreach($galleries as $gallery)
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
            @endforeach
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

        <div class="mt-10">{{ $galleries->links() }}</div>
    @else
        <div class="rounded-lg border border-dashed border-slate-300 bg-white px-6 py-12 text-center text-sm text-slate-500">
            Belum ada foto yang diunggah.
        </div>
    @endif
</div>

<script>
    function galeriPage() {
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
