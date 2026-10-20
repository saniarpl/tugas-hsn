@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold text-[#22c55e] mb-4">Data Saran & Kritik Warga</h1>

<div class="bg-white rounded-2xl shadow border border-green-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-[#d1fae5] border-b border-green-200 text-green-900">
                <th class="p-4 font-bold text-sm">Nama Pengirim</th>
                <th class="p-4 font-bold text-sm">Email</th>
                <th class="p-4 font-bold text-sm">No. HP / WA</th>
                <th class="p-4 font-bold text-sm">Isi Saran / Kritik</th>
                <th class="p-4 font-bold text-sm">Waktu Kirim</th>
                <th class="p-4 font-bold text-sm text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $row)
            <tr class="border-b border-green-50 hover:bg-green-50/50 transition">
                <td class="p-4 font-bold text-slate-800">{{ $row->name }}</td>
                <td class="p-4 text-xs text-slate-600">{{ $row->email }}</td>
                <td class="p-4 text-xs font-semibold text-emerald-700">{{ $row->phone }}</td>
                <td class="p-4 text-sm text-slate-700 leading-relaxed max-w-xs">{{ $row->content }}</td>
                
                <!-- Format Waktu Real-time (DiffForHumans) -->
                <td class="p-4 text-xs">
                    <span class="inline-block bg-emerald-100 text-emerald-800 font-bold px-2.5 py-1 rounded-full">
                        {{ $row->created_at->diffForHumans() }}
                    </span>
                    <div class="text-[10px] text-slate-400 mt-1">
                        {{ $row->created_at->format('d M Y, H:i') }} WIB
                    </div>
                </td>

                <td class="p-4 text-center">
                    <form action="{{ route('admin.feedbacks.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Yakin hapus pesan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-bold text-xs px-3 py-1.5 rounded-lg transition">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="p-8 text-center text-slate-400 text-sm">Belum ada tanggapan atau pesan saran & kritik yang masuk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection