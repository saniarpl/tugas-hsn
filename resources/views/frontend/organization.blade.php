@extends('layouts.app')

@section('content')

{{-- Kepala halaman organisasi --}}
<section class="border-b border-emerald-900/20 bg-[#043D2B]">
    <div class="mx-auto max-w-7xl px-6 py-12 sm:py-16">
        <nav aria-label="Breadcrumb" class="flex flex-wrap items-center gap-2 text-[11px] font-semibold text-emerald-100/60">
            <a href="{{ route('home') }}" class="transition-colors hover:text-white">Beranda</a>
            <span aria-hidden="true">/</span>
            <span>Badan Otonom</span>
            <span aria-hidden="true">/</span>
            <span class="text-emerald-50">{{ $org['title'] }}</span>
        </nav>

        <p class="mt-6 text-[11px] font-bold uppercase tracking-[0.18em] text-amber-300">Badan Otonom NU</p>
        <h1 class="mt-2 max-w-4xl text-3xl font-bold leading-tight text-white sm:text-5xl">{{ $org['title'] }}</h1>
        <p class="mt-4 max-w-3xl text-sm leading-7 text-emerald-50/80 sm:text-base">{{ $org['description'] }}</p>
    </div>
</section>

<div class="mx-auto max-w-7xl space-y-12 px-6 py-12">

    {{-- Profil dan program kerja --}}
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-lg border border-slate-200 bg-white p-7 shadow-sm sm:p-9 lg:col-span-2">
            <h2 class="text-xl font-bold text-slate-900">Profil Organisasi</h2>
            <div class="mt-2 h-0.5 w-12 bg-amber-400" aria-hidden="true"></div>
            <p class="mt-4 text-sm leading-7 text-slate-600">{{ $org['about'] }}</p>
        </div>

        <aside class="rounded-lg border border-emerald-900/10 bg-[#F0F7F3] p-7 shadow-sm sm:p-8">
            <h2 class="text-lg font-bold text-emerald-950">Program Kerja Utama</h2>
            <ul class="mt-4 space-y-3 text-sm text-emerald-900/85">
                @foreach($org['proker'] as $proker)
                    <li class="flex items-start gap-2.5">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>{{ $proker }}</span>
                    </li>
                @endforeach
            </ul>
        </aside>
    </div>

    {{-- Daftar pengurus --}}
    <div>
        <div class="mb-8 border-b border-slate-200 pb-4">
            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-emerald-700">Struktur Organisasi</p>
            <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Pengurus {{ $org['title'] }}</h2>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @forelse($committees as $committee)
                <div class="rounded-lg border border-slate-200 bg-white p-6 text-center shadow-sm transition-colors hover:border-emerald-300">
                    @if($committee->image)
                        <img src="{{ asset('storage/' . $committee->image) }}" alt="{{ $committee->name }}"
                             loading="lazy"
                             class="mx-auto h-24 w-24 rounded-full object-cover ring-1 ring-slate-200">
                    @else
                        <div class="mx-auto grid h-24 w-24 place-items-center rounded-full bg-emerald-50 text-2xl font-bold text-emerald-800">
                            {{ strtoupper(substr($committee->name, 0, 1)) }}
                        </div>
                    @endif
                    <h3 class="mt-4 text-sm font-bold text-slate-900">{{ $committee->name }}</h3>
                    <p class="mt-1 text-xs font-semibold text-emerald-700">{{ $committee->position }}</p>
                    @if($committee->period)
                        <p class="mt-1 text-[11px] font-medium text-slate-400">Periode {{ $committee->period }}</p>
                    @endif
                </div>
            @empty
                <div class="col-span-full rounded-lg border border-dashed border-slate-300 bg-white px-6 py-10 text-center text-sm text-slate-500">
                    Belum ada pengurus terdaftar.
                </div>
            @endforelse
        </div>
    </div>

    <div class="border-t border-slate-200 pt-6">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-bold text-emerald-700 transition-colors hover:text-emerald-900">
            <span aria-hidden="true">&larr;</span> Kembali ke Beranda
        </a>
    </div>
</div>

@endsection
