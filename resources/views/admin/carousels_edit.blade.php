@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-[#22c55e]">Edit / Detail Data Carousel</h1>
    <a href="{{ route('admin.carousels.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded font-bold hover:bg-gray-600">Kembali</a>
</div>

<form action="{{ route('admin.carousels.update', $carousel->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow border border-green-200 space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block font-bold mb-1 text-green-900">Judul Banner</label>
        <input type="text" name="title" value="{{ $carousel->title }}" required class="w-full border p-2 rounded">
    </div>
    <div>
        <label class="block font-bold mb-1 text-green-900">Deskripsi Singkat</label>
        <textarea name="description" class="w-full border p-2 rounded h-20">{{ $carousel->description }}</textarea>
    </div>
    <div>
        <label class="block font-bold mb-1 text-green-900">Gambar Banner Saat Ini</label>
        @if($carousel->image)
            <img src="{{ image_url($carousel->image) }}" class="w-48 h-24 object-cover rounded mb-2 border border-green-200">
        @endif
        <input type="file" name="image" class="w-full border p-2 rounded">
    </div>
    <button type="submit" class="bg-[#22c55e] text-white px-6 py-2 rounded font-bold hover:bg-green-600">Simpan Perubahan</button>
</form>
@endsection