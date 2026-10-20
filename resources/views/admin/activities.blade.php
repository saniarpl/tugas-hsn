@extends('layouts.admin')
@section('content')
<h1 class="text-2xl font-bold text-[#22c55e] mb-4">Data Kegiatan</h1>
<form action="{{ route('admin.activities.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow mb-6 border border-green-200 grid grid-cols-2 gap-4">
    @csrf
    <input type="text" name="title" placeholder="Nama Kegiatan" required class="border p-2 rounded">
    <input type="date" name="date" required class="border p-2 rounded">
    <input type="text" name="location" placeholder="Lokasi" required class="border p-2 rounded">
    <input type="file" name="image" class="border p-2 rounded">
    <textarea name="description" placeholder="Deskripsi" required class="border p-2 rounded col-span-2"></textarea>
    <button class="bg-[#22c55e] text-white py-2 rounded font-bold col-span-2">Simpan Kegiatan</button>
</form>

<table class="w-full bg-white rounded shadow text-left border-collapse">
    <tr class="bg-[#d1fae5] border-b">
        <th class="p-3">Foto</th>
        <th class="p-3">Judul</th>
        <th class="p-3">Tanggal</th>
        <th class="p-3">Lokasi</th>
        <th class="p-3 text-center">Aksi</th>
    </tr>
    @foreach($data as $row)
    <tr class="border-b">
        <td class="p-3">
            @if($row->image)
                <img src="{{ asset('storage/'.$row->image) }}" class="w-16 h-12 object-cover rounded">
            @else
                <span class="text-xs text-gray-400">Tidak ada gambar</span>
            @endif
        </td>
        <td class="p-3 font-semibold">{{ $row->title }}</td>
        <td class="p-3">{{ $row->date }}</td>
        <td class="p-3">{{ $row->location }}</td>
        <td class="p-3 flex justify-center gap-2">
            <a href="{{ route('admin.activities.edit', $row->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded font-bold text-xs hover:bg-blue-600">Edit</a>
            <form action="{{ route('admin.activities.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                @csrf @method('DELETE')
                <button class="bg-red-500 text-white px-3 py-1 rounded font-bold text-xs hover:bg-red-600">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection