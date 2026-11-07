@extends('layouts.admin')
@section('content')
<h1 class="text-2xl font-bold text-[#22c55e] mb-4">Data Pengurus</h1>
<form action="{{ route('admin.committees.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow mb-6 flex flex-wrap gap-4 border border-green-200">
    @csrf
    <input type="text" name="name" placeholder="Nama" required class="border p-2 rounded flex-1">
    <input type="text" name="position" placeholder="Jabatan (Ketua)" required class="border p-2 rounded flex-1">
    <input type="text" name="organization" placeholder="Organisasi (NU/IPNU/Banser)" required class="border p-2 rounded flex-1">
    <input type="text" name="period" placeholder="Periode (2023-2028)" required class="border p-2 rounded flex-1">
    <input type="file" name="image" class="border p-2 rounded">
    <button class="bg-[#22c55e] text-white px-6 rounded font-bold">Tambah</button>
</form>

<table class="w-full bg-white rounded shadow text-left border-collapse">
    <tr class="bg-[#d1fae5] border-b">
        <th class="p-3">Foto</th>
        <th class="p-3">Nama</th>
        <th class="p-3">Jabatan</th>
        <th class="p-3">Organisasi</th>
        <th class="p-3">Periode</th>
        <th class="p-3 text-center">Aksi</th>
    </tr>
    @foreach($data as $row)
    <tr class="border-b">
        <td class="p-3">
            @if($row->image)
                <img src="{{ image_url($row->image) }}" class="w-12 h-12 object-cover rounded-full">
            @else
                <span class="text-xs text-gray-400">Tidak ada foto</span>
            @endif
        </td>
        <td class="p-3 font-semibold">{{ $row->name }}</td>
        <td class="p-3">{{ $row->position }}</td>
        <td class="p-3">{{ $row->organization }}</td>
        <td class="p-3">{{ $row->period }}</td>
        <td class="p-3 flex justify-center gap-2">
            <a href="{{ route('admin.committees.edit', $row->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded font-bold text-xs hover:bg-blue-600">Edit</a>
            <form action="{{ route('admin.committees.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                @csrf @method('DELETE')
                <button class="bg-red-500 text-white px-3 py-1 rounded font-bold text-xs hover:bg-red-600">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection