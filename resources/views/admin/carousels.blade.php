@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-sm space-y-6">
    <h2 class="text-xl font-bold text-slate-800">Manajemen Pengurus & Banom</h2>

    <!-- Form Tambah Pengurus -->
    <form action="{{ route('admin.committees.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-slate-50 p-6 rounded-xl border border-slate-200">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" required class="w-full border border-slate-200 rounded-xl p-2.5 text-xs focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: Kyai Ahmad">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Jabatan / Posisi</label>
                <input type="text" name="position" required class="w-full border border-slate-200 rounded-xl p-2.5 text-xs focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: Ketua Ranting">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Organisasi / Banom</label>
                <select name="organization" required class="w-full border border-slate-200 rounded-xl p-2.5 text-xs focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                    <option value="nu">Ranting NU Windunegara</option>
                    <option value="ipnu">IPNU</option>
                    <option value="ippnu">IPPNU</option>
                    <option value="fatayat">Fatayat NU</option>
                    <option value="muslimat">Muslimat NU</option>
                    <option value="banser">Banser</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Foto Pengurus</label>
                <input type="file" name="image" accept="image/*" class="w-full border border-slate-200 rounded-xl p-2 text-xs bg-white">
            </div>
        </div>

        <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition">
            Simpan Data Pengurus
        </button>
    </form>

    <!-- Tabel Daftar Pengurus -->
    <div class="overflow-x-auto">
        <table class="w-full text-xs text-left border-collapse">
            <thead>
                <tr class="bg-slate-100 text-slate-700 border-b">
                    <th class="p-3">Foto</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Jabatan</th>
                    <th class="p-3">Organisasi</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($committees as $committee)
                    <tr class="border-b hover:bg-slate-50">
                        <td class="p-3">
                            @if($committee->image)
                                <img src="{{ asset('storage/' . $committee->image) }}" class="w-10 h-10 object-cover rounded-full border border-slate-200" alt="Foto">
                            @else
                                <div class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center text-slate-500 font-bold">NU</div>
                            @endif
                        </td>
                        <td class="p-3 font-bold text-slate-800">{{ $committee->name }}</td>
                        <td class="p-3 text-slate-600">{{ $committee->position }}</td>
                        <td class="p-3">
                            <span class="uppercase bg-emerald-50 text-emerald-800 px-2.5 py-1 rounded-full text-[10px] font-bold border border-emerald-200">
                                {{ $committee->organization }}
                            </span>
                        </td>
                        <td class="p-3 text-center">
                            <form action="{{ route('admin.committees.destroy', $committee->id) }}" method="POST" onsubmit="return confirm('Hapus data pengurus ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-[11px] font-bold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-slate-400">Belum ada data pengurus.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection