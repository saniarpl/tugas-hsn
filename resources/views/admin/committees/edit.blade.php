@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 max-w-2xl mx-auto">
    <h2 class="text-xl font-bold text-slate-800 mb-6">Edit Data Pengurus</h2>

    <form action="{{ route('admin.committees.update', $committee->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf @method('PUT')
        
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ $committee->name }}" required class="w-full border border-slate-200 rounded-lg p-2 text-sm focus:ring-emerald-500">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Jabatan</label>
            <input type="text" name="position" value="{{ $committee->position }}" required class="w-full border border-slate-200 rounded-lg p-2 text-sm focus:ring-emerald-500">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Organisasi / Banom</label>
            <select name="organization" required class="w-full border border-slate-200 rounded-lg p-2 text-sm focus:ring-emerald-500">
                <option value="nu" {{ $committee->organization == 'nu' ? 'selected' : '' }}>Ranting NU</option>
                <option value="ipnu" {{ $committee->organization == 'ipnu' ? 'selected' : '' }}>IPNU</option>
                <option value="ippnu" {{ $committee->organization == 'ippnu' ? 'selected' : '' }}>IPPNU</option>
                <option value="fatayat" {{ $committee->organization == 'fatayat' ? 'selected' : '' }}>Fatayat NU</option>
                <option value="muslimat" {{ $committee->organization == 'muslimat' ? 'selected' : '' }}>Muslimat NU</option>
                <option value="banser" {{ $committee->organization == 'banser' ? 'selected' : '' }}>Banser</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Foto Baru (Opsional)</label>
            <input type="file" name="image" class="text-xs">
        </div>

        <div class="pt-4 flex justify-end gap-2">
            <a href="{{ route('admin.committees.index') }}" class="bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-xs font-bold">Batal</a>
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-xs font-bold">Update Data</button>
        </div>
    </form>
</div>
@endsection