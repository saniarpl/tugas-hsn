@extends('layouts.admin')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-[#22c55e]">Edit Data Kegiatan</h1>
    <a href="{{ route('admin.activities.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded font-bold hover:bg-gray-600">Kembali</a>
</div>

<form action="{{ route('admin.activities.update', $activity->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow border border-green-200 space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block font-bold mb-1">Nama Kegiatan</label>
        <input type="text" name="title" value="{{ $activity->title }}" required class="w-full border p-2 rounded">
    </div>
    <div>
        <label class="block font-bold mb-1">Tanggal</label>
        <input type="date" name="date" value="{{ $activity->date }}" required class="w-full border p-2 rounded">
    </div>
    <div>
        <label class="block font-bold mb-1">Lokasi</label>
        <input type="text" name="location" value="{{ $activity->location }}" required class="w-full border p-2 rounded">
    </div>
    <div>
        <label class="block font-bold mb-1">Deskripsi</label>
        <textarea name="description" required class="w-full border p-2 rounded h-24">{{ $activity->description }}</textarea>
    </div>
    <div>
        <label class="block font-bold mb-1">Foto Kegiatan</label>
        @if($activity->image)
            <img src="{{ asset('storage/'.$activity->image) }}" class="w-32 h-20 object-cover rounded mb-2">
        @endif
        <input type="file" name="image" class="w-full border p-2 rounded">
    </div>
    <button class="bg-[#22c55e] text-white px-6 py-2 rounded font-bold hover:bg-green-600">Update Data</button>
</form>
@endsection