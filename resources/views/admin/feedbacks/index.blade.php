@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Saran & Kritik Pengunjung</h1>
            <p class="text-xs text-slate-500 font-medium mt-1">Daftar masukan yang dikirim melalui form di halaman utama website.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($feedbacks as $feedback)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 relative flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start mb-4 border-b border-slate-100 pb-4">
                        <div>
                            <h3 class="font-extrabold text-slate-800 text-base">{{ $feedback->name }}</h3>
                            <p class="text-[10px] font-bold text-emerald-600 mt-0.5 uppercase tracking-wide">{{ $feedback->contact ?? 'Tidak ada kontak' }}</p>
                        </div>
                        <span class="text-[10px] text-slate-400 font-bold bg-slate-50 px-2 py-1 rounded-md">{{ \Carbon\Carbon::parse($feedback->created_at)->diffForHumans() }}</span>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed font-medium mb-6">"{{ $feedback->message }}"</p>
                </div>
                <div class="text-right">
                    <form action="{{ route('admin.feedbacks.destroy', $feedback->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-bold transition">Hapus Pesan</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-slate-200/80 text-slate-400 font-medium text-xs">
                Belum ada saran atau masukan baru dari pengunjung.
            </div>
        @endforelse
    </div>
</div>
@endsection