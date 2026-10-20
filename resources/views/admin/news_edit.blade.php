@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-[#22c55e]">Edit / Detail Data Berita</h1>
    <a href="{{ route('admin.news.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded font-bold hover:bg-gray-600 transition">Kembali</a>
</div>

<form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow border border-green-200 space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block font-bold mb-1 text-green-900">Judul Berita</label>
        <input type="text" name="title" value="{{ $news->title }}" required class="w-full border border-green-300 p-2 rounded focus:outline-none focus:border-[#22c55e]">
    </div>
    <div>
        <label class="block font-bold mb-1 text-green-900">Kategori</label>
        <select name="category" class="w-full border border-green-300 p-2 rounded focus:outline-none focus:border-[#22c55e]" required>
            <option value="NU Desa" {{ $news->category == 'NU Desa' ? 'selected' : '' }}>NU Desa</option>
            <option value="IPNU" {{ $news->category == 'IPNU' ? 'selected' : '' }}>IPNU</option>
            <option value="IPPNU" {{ $news->category == 'IPPNU' ? 'selected' : '' }}>IPPNU</option>
            <option value="Fatayat" {{ $news->category == 'Fatayat' ? 'selected' : '' }}>Fatayat</option>
            <option value="Muslimat" {{ $news->category == 'Muslimat' ? 'selected' : '' }}>Muslimat</option>
            <option value="Banser" {{ $news->category == 'Banser' ? 'selected' : '' }}>Banser</option>
        </select>
    </div>
    <div>
        <label class="block font-bold mb-1 text-green-900">Penulis</label>
        <input type="text" name="author" value="{{ $news->author }}" required class="w-full border border-green-300 p-2 rounded focus:outline-none focus:border-[#22c55e]">
    </div>
    <div>
        <label class="block font-bold mb-1 text-green-900">Isi Berita Lengkap</label>
        <textarea name="content" required class="w-full border border-green-300 p-2 rounded h-40 focus:outline-none focus:border-[#22c55e]">{{ $news->content }}</textarea>
    </div>
    <div>
        <label class="block font-bold mb-1 text-green-900">Status Publikasi</label>
        <select name="status" class="w-full border border-green-300 p-2 rounded focus:outline-none focus:border-[#22c55e]" required>
            <option value="published" {{ $news->status == 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft" {{ $news->status == 'draft' ? 'selected' : '' }}>Draft</option>
        </select>
    </div>
    <div>
        <label class="block font-bold mb-1 text-green-900">Gambar Utama Saat Ini</label>
        @if($news->image)
            <img src="{{ asset('storage/'.$news->image) }}" class="w-40 h-24 object-cover rounded mb-2 border border-green-200 shadow-sm">
        @endif
        <input type="file" name="image" class="w-full border border-green-300 p-2 rounded">
        <small class="text-gray-500">Biarkan kosong jika tidak ingin mengubah gambar.</small>
    </div>
    <button type="submit" class="bg-[#22c55e] text-white px-6 py-2 rounded font-bold hover:bg-green-600 transition">Simpan Perubahan</button>
</form>
@endsection