@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="{ openModal: false, editMode: false, currentMember: {} }">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Data Warga & Anggota NU</h1>
            <p class="text-xs text-slate-500 font-medium mt-1">Kelola direktori keanggotaan Ranting NU Desa Windunegara.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <button @click="openModal = true; editMode = false; currentMember = {}" class="inline-flex items-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs px-5 py-3 rounded-xl shadow-md transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Tambah Data Warga</span>
            </button>
            @if(count($members))
                <button onclick="window.open('{{ route('admin.members.card', $members->first()->id) }}', '_blank')" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs px-5 py-3 rounded-xl shadow-md transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    <span>Cetak Kartu</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                        <th class="py-4 px-6">Nama Lengkap</th>
                        <th class="py-4 px-6">NIK</th>
                        <th class="py-4 px-6">No. WhatsApp</th>
                        <th class="py-4 px-6">Alamat RT/RW</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse($members as $member)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-4 px-6 font-bold text-slate-800">
                                <div class="flex items-center gap-3">
                                    @if($member->photo)
                                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="w-8 h-8 rounded-lg object-cover border border-slate-200">
                                    @else
                                        <div class="w-8 h-8 bg-emerald-100 text-emerald-800 font-bold rounded-lg flex items-center justify-center text-xs">
                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <span>{{ $member->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 font-mono text-slate-600">{{ $member->nik ?? '-' }}</td>
                            <td class="py-4 px-6 font-mono text-slate-600">{{ $member->phone ?? '-' }}</td>
                            <td class="py-4 px-6 text-slate-600">{{ $member->address ?? '-' }}</td>
                            <td class="py-4 px-6 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.members.card', $member->id) }}" target="_blank" class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold transition">
                                    Kartu
                                </a>
                                <button @click="openModal = true; editMode = true; currentMember = @js($member)" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition">
                                    Edit
                                </button>
                                <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus data warga ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-bold transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400 font-medium">Belum ada data warga terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form Tambah/Edit -->
    <div x-cloak x-show="openModal" class="fixed inset-0 z-[300] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 overflow-y-auto">
        <div @click.away="openModal = false" x-show="openModal" x-transition class="bg-white w-full max-w-lg rounded-3xl p-6 shadow-2xl relative border border-slate-100 my-8">
            <h2 class="text-xl font-extrabold text-slate-800 mb-4" x-text="editMode ? 'Edit Data Warga' : 'Tambah Data Warga Baru'"></h2>

            <form :action="editMode ? '{{ url('admin/members') }}/' + currentMember.id : '{{ route('admin.members.store') }}'" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <!-- Foto Profil -->
                <div class="p-4 bg-emerald-50/50 rounded-2xl border border-emerald-100">
                    <label class="block text-[11px] font-bold text-emerald-800 uppercase mb-2">Foto Profil KTA (Opsional)</label>
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-20 bg-white rounded-lg border-2 border-dashed border-emerald-300 overflow-hidden flex items-center justify-center flex-shrink-0 relative">
                            <img id="modal-photo-preview" src="" class="w-full h-full object-cover absolute inset-0 z-10 hidden">
                            <span id="modal-photo-initial" class="text-xl font-black text-emerald-600 z-0" x-text="currentMember.name ? currentMember.name.charAt(0).toUpperCase() : '+'"></span>
                        </div>
                        <div class="flex-grow">
                            <input type="file" name="photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition" onchange="previewModalImage(event)">
                            <p class="text-[10px] text-emerald-600 font-medium mt-1.5">Format: JPG, PNG. Maksimal 2MB.</p>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="name" :value="currentMember.name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">NIK</label>
                    <input type="text" name="nik" :value="currentMember.nik" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none font-mono">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">No. WhatsApp / HP</label>
                    <input type="text" name="phone" :value="currentMember.phone" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none font-mono">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Alamat RT/RW & Dusun</label>
                    <textarea name="address" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none" x-text="currentMember.address"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" @click="openModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold transition" x-text="editMode ? 'Simpan Perubahan' : 'Tambah Warga'"></button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    function previewModalImage(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('modal-photo-preview');
                const initial = document.getElementById('modal-photo-initial');
                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                if (initial) initial.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
