@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12" x-data="galeriPage()">
    <h1 class="text-3xl font-black text-slate-800 mb-2 text-center">Galeri Kegiatan NU Windunegara</h1>
    <p class="text-xs text-slate-500 text-center mb-8">Dokumentasi visual kegiatan jam'iyyah. Klik foto untuk memperbesar.</p>

    @if(count($galleries))
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($galleries as $gallery)
                <button type="button" @click="show({{ $loop->index }})"
                        data-full="{{ asset('storage/' . $gallery->image) }}"
                        data-title="{{ $gallery->title }}"
                        class="group overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm hover:shadow-xl transition text-left">
                    <span class="block h-40 sm:h-48 overflow-hidden relative">
                        <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></span>
                    </span>
                    <span class="block p-4">
                        <span class="block font-extrabold text-slate-800 text-xs line-clamp-2">{{ $gallery->title }}</span>
                    </span>
                </button>
            @endforeach
        </div>

        <!-- Modal Lightbox -->
        <div x-cloak x-show="open"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[500] flex items-center justify-center bg-slate-950/90 backdrop-blur-md p-4"
             @click.self="close()" @keydown.escape.window="close()"
             @keydown.arrow-right.window="if (open) next()" @keydown.arrow-left.window="if (open) prev()">
            <template x-if="images.length">
                <figure class="relative max-w-4xl w-full">
                    <button @click="close()" aria-label="Tutup" class="absolute -top-3 -right-3 sm:top-4 sm:right-4 z-10 bg-red-500 hover:bg-red-600 text-white p-2 rounded-full shadow transition">
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
    @else
        <div class="bg-white rounded-3xl p-12 text-center text-slate-400 font-medium text-xs border border-dashed">
            Belum ada foto yang diunggah.
        </div>
    @endif

    <div class="mt-8">{{ $galleries->links() }}</div>
</div>

<script>
    function galeriPage() {
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
@endsection
