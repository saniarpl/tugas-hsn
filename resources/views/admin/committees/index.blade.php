@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="{ openModal: false, editMode: false, currentCommittee: {} }">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Pengurus & Banom</h1>
            <p class="text-xs text-slate-500 font-medium mt-1">Kelola susunan pengurus IPNU, IPPNU, Fatayat, Muslimat, dan Banser.</p>
        </div>
        <button @click="openModal = true; editMode = false; currentCommittee = { organization: 'ipnu', type: 'Syuriyah' }" class="inline-flex items-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs px-5 py-3 rounded-xl shadow-md transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Tambah Pengurus</span>
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                        <th class="py-4 px-6">Foto</th>
                        <th class="py-4 px-6">Nama Pengurus</th>
                        <th class="py-4 px-6">Jabatan</th>
                        <th class="py-4 px-6">Organisasi / Banom</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($committees as $committee)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3 px-6">
                                @if($committee->image)
                                    <img src="{{ image_url($committee->image) }}" class="w-10 h-10 rounded-full object-cover border border-slate-200">
                                @else
                                    <div class="w-10 h-10 bg-emerald-100 text-emerald-800 font-extrabold rounded-full flex items-center justify-center text-xs">
                                        {{ strtoupper(substr($committee->name, 0, 1)) }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-800">{{ $committee->name }}</td>
                            <td class="py-4 px-6 text-slate-600">{{ $committee->position }}</td>
                            <td class="py-4 px-6">
                                <span class="bg-emerald-50 text-emerald-800 font-bold px-3 py-1 rounded-full text-[10px] uppercase border border-emerald-100">
                                    {{ $committee->organization }}
                                </span>
                                <p class="text-[10px] text-slate-400 font-semibold mt-1">
                                    {{ $committee->period ?: '-' }}{{ $committee->type ? ' · '.$committee->type : '' }}
                                </p>
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <button @click="openModal = true; editMode = true; currentCommittee = @js($committee)" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition">
                                    Edit
                                </button>
                                <form action="{{ route('admin.committees.destroy', $committee->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus data pengurus ini?')">
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
                            <td colspan="5" class="py-12 text-center text-slate-400 font-medium">Belum ada pengurus terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form -->
    <div x-cloak x-show="openModal" class="fixed inset-0 z-[300] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
        <div @click.away="openModal = false" x-show="openModal" x-transition class="bg-white w-full max-w-lg rounded-3xl p-6 shadow-2xl relative border border-slate-100">
            <h2 class="text-xl font-extrabold text-slate-800 mb-4" x-text="editMode ? 'Edit Pengurus' : 'Tambah Pengurus Baru'"></h2>
            
            <form :action="editMode ? '{{ url('admin/committees') }}/' + currentCommittee.id : '{{ route('admin.committees.store') }}'" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="name" x-model="currentCommittee.name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Jabatan</label>
                    <input type="text" name="position" x-model="currentCommittee.position" required placeholder="Contoh: Ketua, Sekretaris, Bendahara" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Banom / Organisasi</label>
                    <select name="organization" x-model="currentCommittee.organization" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none">
                        <option value="nu">NU (Ranting)</option>
                        <option value="ipnu">IPNU</option>
                        <option value="ippnu">IPPNU</option>
                        <option value="fatayat">Fatayat</option>
                        <option value="muslimat">Muslimat</option>
                        <option value="banser">Banser</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Periode</label>
                        <input type="text" name="period" x-model="currentCommittee.period" required placeholder="Contoh: 2025-2028" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Jenis Kepengurusan</label>
                        <select name="type" x-model="currentCommittee.type" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none">
                            <option value="">- Pilih -</option>
                            <option value="Syuriyah">Syuriyah</option>
                            <option value="Tanfidziyah">Tanfidziyah</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Foto Pengurus</label>
                    <input type="file" name="image" accept="image/*" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs focus:ring-2 focus:ring-emerald-500 outline-none">
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" @click="openModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold transition" x-text="editMode ? 'Simpan Perubahan' : 'Tambah Pengurus'"></button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection