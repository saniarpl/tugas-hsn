@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80">
        <div>
            <h1 class="text-2xl font-black text-slate-800">Edit Profil Warga</h1>
            <p class="text-xs text-slate-500 font-medium mt-1">Kelola identitas dan foto KTA milik {{ $member->name }}.</p>
        </div>
        <a href="{{ route('admin.members.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-4 py-2 rounded-xl transition">
            &larr; Kembali
        </a>
    </div>

    <form action="{{ route('admin.members.update', $member->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-6">
        @csrf @method('PUT')

        <!-- KOLOM KIRI: AREA FOTO PROFIL -->
        <div class="w-full md:w-1/3 flex flex-col gap-4">
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 text-center flex flex-col items-center">
                <h2 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4">Pratinjau Foto KTA</h2>

                <div class="w-32 h-40 rounded-2xl overflow-hidden border-2 border-dashed border-emerald-300 mb-5 relative bg-emerald-50 flex items-center justify-center shadow-inner group">
                    <img id="photo-preview" src="{{ $member->photo ? asset('storage/' . $member->photo) : '' }}" 
                         class="w-full h-full object-cover absolute inset-0 z-10 {{ $member->photo ? '' : 'hidden' }}">
                    
                    <span id="photo-initial" class="text-5xl font-black text-emerald-600 {{ $member->photo ? 'hidden' : '' }}">
                        {{ strtoupper(substr($member->name, 0, 1)) }}
                    </span>

                    <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition duration-300 z-20 flex items-center justify-center pointer-events-none">
                        <span class="text-white text-[10px] font-bold">Ubah Foto</span>
                    </div>
                </div>

                <label class="cursor-pointer w-full bg-emerald-100 hover:bg-emerald-200 text-emerald-800 text-xs font-extrabold py-3.5 px-4 rounded-xl transition border border-emerald-200 shadow-sm relative overflow-hidden text-center block">
                    Pilih File Foto Baru
                    <input type="file" name="photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImage(event)">
                </label>

                @error('photo')
                    <div class="text-rose-600 text-[10px] font-bold mt-2 bg-rose-50 p-2.5 rounded-lg border border-rose-200 text-left w-full">
                        {{ $message }}
                    </div>
                @enderror

                <p class="text-[10px] text-slate-400 font-medium mt-3 text-center leading-relaxed">
                    Maksimal ukuran 2MB.<br>Format: JPG, PNG, WEBP.
                </p>
            </div>
        </div>

        <!-- KOLOM KANAN: FORM DATA WARGA -->
        <div class="w-full md:w-2/3">
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80 space-y-5">
                <h2 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 pb-3 border-b border-slate-100">Informasi Kependudukan</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[11px] font-black text-slate-700 mb-1.5 uppercase tracking-wider">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $member->name) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 outline-none transition font-bold text-slate-800">
                        @error('name') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-700 mb-1.5 uppercase tracking-wider">Nomor Induk / NIK <span class="text-rose-500">*</span></label>
                        <input type="number" name="nik" value="{{ old('nik', $member->nik) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 outline-none transition font-mono font-bold text-slate-700">
                        @error('nik') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-black text-slate-700 mb-1.5 uppercase tracking-wider">Nomor WhatsApp / HP</label>
                    <input type="number" name="phone" value="{{ old('phone', $member->phone) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 outline-none transition font-bold text-slate-700">
                    @error('phone') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-black text-slate-700 mb-1.5 uppercase tracking-wider">Alamat Lengkap <span class="text-rose-500">*</span></label>
                    <textarea name="address" rows="3" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 outline-none transition font-bold text-slate-700 leading-relaxed">{{ old('address', $member->address) }}</textarea>
                    @error('address') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs px-8 py-3.5 rounded-xl shadow-lg hover:shadow-emerald-500/30 transition transform hover:-translate-y-0.5">
                        Simpan & Perbarui Data
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('photo-preview');
                const initial = document.getElementById('photo-initial');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (initial) initial.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection