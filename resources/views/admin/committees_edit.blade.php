@extends('layouts.admin')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-[#22c55e]">Edit Data Pengurus</h1>
    <a href="{{ route('admin.committees.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded font-bold hover:bg-gray-600">Kembali</a>
</div>

<form action="{{ route('admin.committees.update', $committee->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow border border-green-200 space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block font-bold mb-1">Nama Pengurus</label>
        <input type="text" name="name" value="{{ $committee->name }}" required class="w-full border p-2 rounded">
    </div>
    <div>
        <label class="block font-bold mb-1">Jabatan</label>
        <input type="text" name="position" value="{{ $committee->position }}" required class="w-full border p-2 rounded">
    </div>
    <div>
        <label class="block font-bold mb-1">Organisasi</label>
        <input type="text" name="organization" value="{{ $committee->organization }}" required class="w-full border p-2 rounded">
    </div>
    <div>
        <label class="block font-bold mb-1">Periode</label>
        <input type="text" name="period" value="{{ $committee->period }}" required class="w-full border p-2 rounded">
    </div>
    <div>
        <label class="block font-bold mb-1">Foto Pengurus</label>
        @if($committee->image)
            <img src="{{ asset('storage/'.$committee->image) }}" class="w-20 h-20 object-cover rounded mb-2">
        @endif
        <input type="file" name="image" class="w-full border p-2 rounded">
    </div>
    <button class="bg-[#22c55e] text-white px-6 py-2 rounded font-bold hover:bg-green-600">Update Data</button>
</form>
@endsection