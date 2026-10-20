@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="{ openModal: false }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Galeri Foto</h1>
            <p class="text-xs text-slate-500 font-medium mt-1">Kelola dokumentasi visual kegiatan NU Windunegara.</p>
        </div>
        <button @click="openModal = true" class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs px-5 py-3 rounded-xl shadow-md transition">
            + Upload Foto Baru
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse($galleries as $gallery)
            <div class="bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-sm flex flex-col">
                <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-48 object-cover">
                <div class="p-4 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 text-xs truncate mr-2">{{ $gallery->title }}</h3>
                    <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini?')">
                        @csrf @method('DELETE')
                        <button class="bg-rose-50 text-rose-600 px-3 py-1.5 rounded-lg text-[10px] font-bold hover:bg-rose-100">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-3xl p-12 text-center text-slate-400 font-medium text-xs border border-dashed">
                Belum ada foto yang diunggah.
            </div>
        @endforelse
    </div>

    <!-- Modal Upload -->
    <div x-cloak x-show="openModal" class="fixed inset-0 z-[300] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
        <div @click.away="openModal = false" class="bg-white w-full max-w-md rounded-3xl p-6 shadow-2xl">
            <h2 class="text-xl font-extrabold text-slate-800 mb-4">Upload Foto Baru</h2>
            <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Judul / Keterangan</label>
                    <input type="text" name="title" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Pilih File Foto</label>
                    <input type="file" name="image" required accept="image/*" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>
                <div class="flex gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="openModal = false" class="flex-1 bg-slate-100 text-slate-700 py-3 rounded-xl text-xs font-bold hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="flex-1 bg-emerald-700 text-white py-3 rounded-xl text-xs font-bold hover:bg-emerald-800 transition">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection