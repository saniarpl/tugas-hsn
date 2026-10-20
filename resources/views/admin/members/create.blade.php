@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-800">Tambah Warga Baru</h1>
            <p class="text-xs text-slate-500 font-medium mt-1">Lengkapi form identitas warga NU di bawah ini.</p>
        </div>
        <a href="{{ route('admin.members.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition">
            &larr; Kembali
        </a>
    </div>

    <!-- PENTING: enctype="multipart/form-data" wajib ada untuk upload file -->
    <form action="{{ route('admin.members.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80 space-y-6">
        @csrf
        
        <!-- Section: Foto Profil -->
        <div class="p-5 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl border border-emerald-100">
            <h2 class="text-[11px] font-black text-emerald-800 uppercase tracking-widest mb-4 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Foto Profil KTA
            </h2>
            
            <div class="flex flex-col sm:flex-row gap-5">
                <!-- Preview Foto -->
                <div class="flex-shrink-0">
                    <div class="w-32 h-40 rounded-2xl overflow-hidden border-2 border-dashed border-emerald-300 bg-white flex items-center justify-center shadow-inner relative group mx-auto sm:mx-0">
                        <img id="photo-preview" src="" class="w-full h-full object-cover absolute inset-0 z-10 hidden">
                        <div id="photo-placeholder" class="text-center">
                            <svg class="w-10 h-10 text-emerald-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span class="text-[9px] text-emerald-400 font-bold uppercase">3x4</span>
                        </div>
                    </div>
                </div>

                <!-- Input File -->
                <div class="flex-grow">
                    <label class="cursor-pointer w-full bg-white hover:bg-emerald-50 text-emerald-700 text-xs font-extrabold py-3.5 px-4 rounded-xl transition border-2 border-emerald-200 hover:border-emerald-300 shadow-sm relative overflow-hidden text-center block">
                        <svg class="w-5 h-5 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Pilih File Foto
                        <input type="file" name="photo" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImage(event)">
                    </label>
                    
                    @error('photo')
                        <div class="text-rose-600 text-[10px] font-bold mt-2 bg-rose-50 p-2.5 rounded-lg border border-rose-200 text-left">
                            {{ $message }}
                        </div>
                    @enderror

                    <p class="text-[10px] text-emerald-600 font-medium mt-3 leading-relaxed">
                        <span class="font-bold">Tips:</span> Gunakan foto dengan rasio 3x4 (potret). Format: JPG, PNG, WEBP. Maksimal 2MB.
                    </p>
                </div>
            </div>
        </div>

        <!-- Section: Data Diri -->
        <div class="space-y-5">
            <h2 class="text-[11px] font-black text-slate-400 uppercase tracking-widest pb-3 border-b border-slate-100">Informasi Kependudukan</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-[11px] font-black text-slate-700 mb-1.5 uppercase tracking-wider">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 outline-none transition font-bold text-slate-800" placeholder="Masukkan nama lengkap">
                    @error('name') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-700 mb-1.5 uppercase tracking-wider">Nomor Induk Kependudukan (NIK) <span class="text-rose-500">*</span></label>
                    <input type="number" name="nik" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 outline-none transition font-mono font-bold text-slate-700" placeholder="16 digit NIK">
                    @error('nik') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-700 mb-1.5 uppercase tracking-wider">Nomor WhatsApp / HP</label>
                <input type="number" name="phone" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 outline-none transition font-bold text-slate-700" placeholder="08xxxxxxxxxx">
                @error('phone') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-700 mb-1.5 uppercase tracking-wider">Alamat Lengkap <span class="text-rose-500">*</span></label>
                <textarea name="address" rows="3" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 outline-none transition font-bold text-slate-700 leading-relaxed" placeholder="RT/RW, Dusun, Desa"></textarea>
                @error('address') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="pt-5 border-t border-slate-100 flex justify-end">
            <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white font-extrabold text-xs px-8 py-3.5 rounded-xl shadow-lg hover:shadow-emerald-500/30 transition transform hover:-translate-y-0.5">
                Simpan Data Warga
            </button>
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
                const placeholder = document.getElementById('photo-placeholder');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
