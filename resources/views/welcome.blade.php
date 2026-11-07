@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 space-y-16">

    <!-- 1. Hero Carousel / Banner Informasi Terkini -->
    <section class="relative rounded-3xl overflow-hidden shadow-xl border border-slate-200/80 bg-slate-900">
        @if(isset($carousels) && $carousels->count() > 0)
            <div class="relative h-[380px] sm:h-[450px] w-full">
                @foreach($carousels as $key => $carousel)
                    <div class="absolute inset-0 transition-opacity duration-700 ease-in-out {{ $key === 0 ? 'opacity-100' : 'opacity-0' }}">
                        @if($carousel->image)
                            <img src="{{ image_url($carousel->image) }}" class="w-full h-full object-cover object-center" alt="{{ $carousel->title }}">
                        @else
                            <div class="w-full h-full bg-gradient-to-r from-emerald-900 via-emerald-800 to-green-950 flex items-center justify-center"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8 sm:p-12 max-w-3xl">
                            <span class="bg-amber-400 text-slate-950 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider mb-3 inline-block shadow">INFORMASI TERKINI</span>
                            <h2 class="text-2xl sm:text-4xl font-extrabold text-white leading-tight drop-shadow-md mb-2">{{ $carousel->title }}</h2>
                            <p class="text-xs sm:text-sm text-slate-200 font-medium line-clamp-2 leading-relaxed opacity-90">{{ $carousel->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Default Hero Banner jika carousel kosong -->
            <div class="relative h-[320px] sm:h-[400px] w-full header-bg flex items-center p-8 sm:p-12">
                <div class="max-w-2xl text-white relative z-10">
                    <span class="bg-amber-400 text-slate-900 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider mb-3 inline-block shadow">PORTAL RESMI WANUWIN</span>
                    <h2 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight mb-3">Selamat Datang di Portal NU Windunegara</h2>
                    <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed font-medium">Pusat keterbukaan informasi, warta kegiatan keagamaan, serta dokumentasi gerakan Nahdlatul Ulama Desa Windunegara.</p>
                </div>
            </div>
        @endif
    </section>

    <!-- 2. Seksi Warta & Berita Desa -->
    <section id="berita" class="scroll-mt-24 space-y-6">
        <div class="flex justify-between items-end border-b border-slate-200 pb-4">
            <div>
                <span class="text-emerald-700 font-extrabold text-xs uppercase tracking-wider">WARTA & KABAR DESA</span>
                <h2 class="text-2xl font-black text-slate-800 mt-1">Berita NU Windunegara</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($news ?? [] as $item)
                <article class="bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        @if($item->image)
                            <div class="h-48 overflow-hidden relative">
                                <img src="{{ image_url($item->image) }}" class="w-full h-full object-cover transform hover:scale-105 transition duration-500" alt="{{ $item->title }}">
                            </div>
                        @else
                            <div class="h-48 bg-emerald-100 flex items-center justify-center text-emerald-800 font-bold text-xs">
                                WANUWIN MEDIA
                            </div>
                        @endif
                        <div class="p-6">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-2">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</span>
                            <h3 class="font-extrabold text-slate-800 text-lg leading-snug hover:text-emerald-700 transition mb-3 line-clamp-2">{{ $item->title }}</h3>
                            <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">{{ $item->content }}</p>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 bg-white rounded-2xl p-8 text-center border border-slate-200/80">
                    <p class="text-xs text-slate-400 font-medium">Belum ada warta atau berita yang diterbitkan.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- 3. Seksi Infaq & Donasi Pembangunan Masjid -->
    <section id="donasi" class="scroll-mt-24 bg-gradient-to-br from-emerald-900 to-green-950 rounded-3xl p-8 sm:p-12 text-white shadow-xl relative overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center relative z-10">
            <div class="md:col-span-2 space-y-4">
                <span class="bg-amber-400 text-slate-900 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider inline-block">AMAL JARIYAH</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold leading-tight">Infaq & Sedekah Pembangunan Masjid / Kas NU</h2>
                <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed font-medium max-w-xl">
                    Salurkan infaq dan sedekah terbaik Anda untuk mendukung operasional dakwah, pembangunan sarana ibadah, dan kegiatan sosial keagamaan Ranting NU Desa Windunegara.
                </p>
            </div>
            <div class="flex flex-col items-center justify-center bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 text-center">
                <p class="text-xs font-bold text-amber-300 mb-2">REKENING RESMI DONASI</p>
                <span class="text-lg font-black tracking-wider text-white">Bank BRI</span>
                <span class="text-xl font-extrabold text-amber-400 my-1">6823-01-029182-53-1</span>
                <span class="text-[11px] text-emerald-200">a.n. Panitia Pembangunan / NU Windunegara</span>
            </div>
        </div>
    </section>

    <!-- 4. Seksi Agenda Kegiatan Mandiri -->
    <section id="kegiatan" class="scroll-mt-24 space-y-6">
        <div class="border-b border-slate-200 pb-4">
            <span class="text-emerald-700 font-extrabold text-xs uppercase tracking-wider">AGENDA DAN DOKUMENTASI</span>
            <h2 class="text-2xl font-black text-slate-800 mt-1">Kegiatan Jam'iyyah NU</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($activities ?? [] as $activity)
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="flex justify-between items-start gap-4">
                            <h3 class="font-bold text-slate-800 text-base leading-snug">{{ $activity->title }}</h3>
                            <span class="bg-emerald-50 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-full whitespace-nowrap border border-emerald-100">
                                {{ \Carbon\Carbon::parse($activity->date)->translatedFormat('d M Y') }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">{{ $activity->description }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-2 bg-white rounded-2xl p-8 text-center border border-slate-200/80">
                    <p class="text-xs text-slate-400 font-medium">Belum ada agenda kegiatan terbaru yang dijadwalkan.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- 5. Seksi Form Saran & Kritik Warga -->
    <section id="saran-kritik" class="scroll-mt-24 bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/80 shadow-sm max-w-3xl mx-auto">
        <div class="text-center mb-8 space-y-2">
            <span class="text-emerald-700 font-extrabold text-xs uppercase tracking-wider">Layanan Keterbukaan Informasi</span>
            <h2 class="text-2xl font-black text-slate-800">Saran & Kritik Pengunjung</h2>
            <p class="text-xs text-slate-500 max-w-md mx-auto">Sampaikan masukan, gagasan, atau tanggapan Anda demi kemajuan jam'iyyah NU Desa Windunegara.</p>
        </div>

        <form action="{{ route('feedback.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Contoh: Ahmad" class="w-full border border-slate-200 rounded-xl p-3 text-xs focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp / Kontak</label>
                    <input type="text" name="contact" placeholder="08xxxxxxxxxx" class="w-full border border-slate-200 rounded-xl p-3 text-xs focus:ring-emerald-500 focus:border-emerald-500">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Isi Masukan / Saran</label>
                <textarea name="message" rows="4" required placeholder="Tuliskan saran atau masukan Anda di sini..." class="w-full border border-slate-200 rounded-xl p-3 text-xs focus:ring-emerald-500 focus:border-emerald-500"></textarea>
            </div>
            <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs py-3.5 rounded-xl shadow-md transition">
                Kirim Saran & Masukan
            </button>
        </form>
    </section>

</div>
@endsection