@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 max-w-2xl mx-auto">
    <h2 class="text-xl font-bold text-slate-800 mb-6">Tambah Pengurus Baru</h2>

    <form action="{{ route('admin.committees.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" required class="w-full border border-slate-200 rounded-lg p-2 text-sm focus:ring-emerald-500">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Jabatan</label>
            <input type="text" name="position" placeholder="Contoh: Ketua / Sekretaris" required class="w-full border border-slate-200 rounded-lg p-2 text-sm focus:ring-emerald-500">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Organisasi / Banom</label>
            <select name="organization" required class="w-full border border-slate-200 rounded-lg p-2 text-sm focus:ring-emerald-500">
                <option value="nu">Ranting NU (Nahdlatul Ulama)</option>
                <option value="ipnu">IPNU</option>
                <option value="ippnu">IPPNU</option>
                <option value="fatayat">Fatayat NU</option>
                <option value="muslimat">Muslimat NU</option>
                <option value="banser">Banser / Ansor</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Foto (Opsional)</label>
            <input type="file" name="photo" class="text-xs">
        </div>

        <div class="pt-4 flex justify-end gap-2">
            <a href="{{ route('admin.committees.index') }}" class="bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-xs font-bold">Batal</a>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-xs font-bold">Simpan</button>
        </div>
    </form>
</div>
@endsection