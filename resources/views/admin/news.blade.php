@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold text-[#22c55e] mb-4">Data Berita</h1>

<form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow mb-6 border border-green-200 grid grid-cols-2 gap-4">
    @csrf
    <div>
        <label class="block text-sm font-semibold mb-1 text-green-900">Judul Berita</label>
        <input type="text" name="title" placeholder="Masukkan judul berita" required class="border border-green-300 p-2 rounded w-full focus:outline-none focus:border-[#22c55e]">
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1 text-green-900">Foto Berita</label>
        <input type="file" name="image" required class="border border-green-300 p-2 rounded w-full">
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1 text-green-900">Kategori</label>
        <select name="category" class="border border-green-300 p-2 rounded w-full focus:outline-none focus:border-[#22c55e]" required>
            <option value="NU Desa">NU Desa</option>
            <option value="IPNU">IPNU</option>
            <option value="IPPNU">IPPNU</option>
            <option value="Fatayat">Fatayat</option>
            <option value="Muslimat">Muslimat</option>
            <option value="Banser">Banser</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1 text-green-900">Penulis</label>
        <input type="text" name="author" value="Admin WANUWIN" required class="border border-green-300 p-2 rounded w-full focus:outline-none focus:border-[#22c55e]">
    </div>
    <div class="col-span-2">
        <label class="block text-sm font-semibold mb-1 text-green-900">Isi Berita</label>
        <textarea name="content" placeholder="Tuliskan berita secara lengkap..." required class="border border-green-300 p-2 rounded w-full h-28 focus:outline-none focus:border-[#22c55e]"></textarea>
    </div>
    <div class="col-span-2">
        <label class="block text-sm font-semibold mb-1 text-green-900">Status</label>
        <select name="status" class="border border-green-300 p-2 rounded w-full focus:outline-none focus:border-[#22c55e]" required>
            <option value="published">Publish Sekarang</option>
            <option value="draft">Simpan Sebagai Draft</option>
        </select>
    </div>
    <button type="submit" class="bg-[#22c55e] text-white py-2 rounded font-bold col-span-2 hover:bg-green-600 transition">Posting Berita</button>
</form>

<div class="bg-white rounded shadow overflow-hidden border border-green-100">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-[#d1fae5] border-b border-green-200">
                <th class="p-3">Gambar</th>
                <th class="p-3">Judul Berita</th>
                <th class="p-3">Kategori</th>
                <th class="p-3">Penulis</th>
                <th class="p-3">Status</th>
                <th class="p-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($news as $row)
            <tr class="border-b border-green-100 hover:bg-green-50">
                <td class="p-3">
                    <img src="{{ asset('storage/'.$row->image) }}" class="w-16 h-12 object-cover rounded border border-green-200">
                </td>
                <td class="p-3 font-semibold text-green-900">{{ $row->title }}</td>
                <td class="p-3 text-gray-600">{{ $row->category }}</td>
                <td class="p-3 text-gray-600">{{ $row->author }}</td>
                <td class="p-3">
                    <span class="px-2 py-1 rounded text-xs text-white font-bold {{ $row->status == 'published' ? 'bg-green-500' : 'bg-gray-400' }}">
                        {{ strtoupper($row->status) }}
                    </span>
                </td>
                <td class="p-3">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('admin.news.edit', $row->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded font-bold text-xs hover:bg-blue-600 transition">Edit / Detail</a>
                        <form action="{{ route('admin.news.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded font-bold text-xs hover:bg-red-600 transition">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center p-6 text-gray-500">Belum ada data berita. Silakan tambahkan pada form di atas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection