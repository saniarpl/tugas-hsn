@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="{ openModal: false, editMode: false, currentNews: {} }">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Warta & Berita</h1>
            <p class="text-xs text-slate-500 font-medium mt-1">Kelola warta artikel dan berita seputar NU Desa Windunegara.</p>
        </div>
        <button @click="openModal = true; editMode = false; currentNews = {}" class="inline-flex items-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs px-5 py-3 rounded-xl shadow-md transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Tambah Berita</span>
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                        <th class="py-4 px-6">Gambar</th>
                        <th class="py-4 px-6">Judul Berita</th>
                        <th class="py-4 px-6">Tanggal Rilis</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($news as $item)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3 px-6">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" class="w-16 h-10 rounded-lg object-cover border border-slate-200">
                                @else
                                    <div class="w-16 h-10 bg-slate-100 rounded-lg flex items-center justify-center text-[10px] text-slate-400 font-bold">No Img</div>
                                @endif
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-800 max-w-md truncate">{{ $item->title }}</td>
                            <td class="py-4 px-6 text-slate-500">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <button @click="openModal = true; editMode = true; currentNews = {{ json_encode($item) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition">
                                    Edit
                                </button>
                                <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-bold transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-400 font-medium">Belum ada berita terpublikasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form -->
    <div x-cloak x-show="openModal" class="fixed inset-0 z-[300] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
        <div @click.away="openModal = false" x-show="openModal" x-transition class="bg-white w-full max-w-lg rounded-3xl p-6 shadow-2xl relative border border-slate-100 max-h-[90vh] overflow-y-auto">
            <h2 class="text-xl font-extrabold text-slate-800 mb-4" x-text="editMode ? 'Edit Berita' : 'Tambah Berita Baru'"></h2>
            
            <form :action="editMode ? '{{ url('admin/news') }}/' + currentNews.id : '{{ route('admin.news.store') }}'" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Judul Berita</label>
                    <input type="text" name="title" :value="currentNews.title" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Isi Berita Lengkap</label>
                    <textarea name="content" rows="6" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none" x-text="currentNews.content"></textarea>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Gambar Utama</label>
                    <input type="file" name="image" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" @click="openModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold transition" x-text="editMode ? 'Simpan Perubahan' : 'Terbitkan Berita'"></button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection