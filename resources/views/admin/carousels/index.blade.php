@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="{ openModal: false, editMode: false, currentCarousel: {} }">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Banner Carousel</h1>
            <p class="text-xs text-slate-500 font-medium mt-1">Kelola slider gambar utama yang tampil di bagian atas beranda.</p>
        </div>
        <button @click="openModal = true; editMode = false; currentCarousel = {}" class="inline-flex items-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs px-5 py-3 rounded-xl shadow-md transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Tambah Banner</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($carousels as $carousel)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="h-44 bg-slate-100 relative">
                        @if($carousel->image)
                            <img src="{{ image_url($carousel->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-xs font-bold text-slate-400">Tidak ada gambar</div>
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="font-extrabold text-slate-800 text-base mb-1">{{ $carousel->title }}</h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $carousel->description }}</p>
                    </div>
                </div>

                <div class="p-5 pt-0 flex justify-end gap-2 border-t border-slate-100/80 mt-2">
                    <button @click="openModal = true; editMode = true; currentCarousel = @js($carousel)" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition">
                        Edit
                    </button>
                    <form action="{{ route('admin.carousels.destroy', $carousel->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus banner ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-bold transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-slate-200/80 text-slate-400 font-medium text-xs">
                Belum ada banner carousel terdaftar.
            </div>
        @endforelse
    </div>

    <!-- Modal Form -->
    <div x-cloak x-show="openModal" class="fixed inset-0 z-[300] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
        <div @click.away="openModal = false" x-show="openModal" x-transition class="bg-white w-full max-w-lg rounded-3xl p-6 shadow-2xl relative border border-slate-100">
            <h2 class="text-xl font-extrabold text-slate-800 mb-4" x-text="editMode ? 'Edit Banner' : 'Tambah Banner Baru'"></h2>
            
            <form :action="editMode ? '{{ url('admin/carousels') }}/' + currentCarousel.id : '{{ route('admin.carousels.store') }}'" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Judul Banner</label>
                    <input type="text" name="title" :value="currentCarousel.title" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Deskripsi Singkat</label>
                    <textarea name="description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none" x-text="currentCarousel.description"></textarea>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">File Gambar Banner</label>
                    <input type="file" name="image" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" @click="openModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold transition" x-text="editMode ? 'Simpan Perubahan' : 'Upload Banner'"></button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection