<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Anggota - {{ $member->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .ktp-card {
            width: 70mm;
            height: 44mm;
        }

        @media print {
            @page {
                size: 70mm 44mm;
                margin: 0;
            }
            .no-print { display: none !important; }
            body {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .card-wrapper {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                gap: 8mm;
                min-height: 100vh;
                padding: 5mm;
            }
            .ktp-card {
                box-shadow: none !important;
                border: 1px solid #333 !important;
                border-radius: 3px !important;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-slate-200 py-8 px-4">

    <!-- Tombol Aksi (tidak ikut tercetak) -->
    <div class="no-print max-w-md mx-auto mb-6 flex justify-between items-center">
        <a href="{{ route('admin.members.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-100 text-slate-700 rounded-xl text-xs font-bold transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold transition shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Kartu
        </button>
    </div>

    <!-- Container Kartu -->
    <div class="card-wrapper flex flex-col items-center gap-6">

        <!-- SISI DEPAN -->
        <div class="text-center no-print">
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Sisi Depan</span>
        </div>

        <div class="ktp-card bg-white rounded shadow-md overflow-hidden border border-slate-400">

            <!-- Header -->
            <div class="bg-emerald-800 px-3 py-2 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 bg-white rounded-full flex items-center justify-center font-black text-emerald-800 font-serif text-[11px]">
                        NU
                    </div>
                    <div>
                        <p class="text-[9px] font-extrabold leading-none">KARTU ANGGOTA</p>
                        <p class="text-[6px] text-emerald-200">Nahdlatul Ulama</p>
                    </div>
                </div>
                <p class="text-[7px] font-semibold text-emerald-200">Windunegara</p>
            </div>

            <!-- Isi -->
            <div class="px-3 py-2 flex gap-2.5">
                <!-- Foto -->
                <div class="w-[16mm] h-[21mm] bg-slate-100 rounded border border-slate-300 overflow-hidden flex-shrink-0">
                    @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-[8px] text-slate-400 font-medium">Foto</span>
                        </div>
                    @endif
                </div>

                <!-- Data -->
                <div class="flex-grow space-y-1 min-w-0">
                    <div>
                        <p class="text-[5px] font-semibold text-slate-400 uppercase tracking-wide">Nama</p>
                        <p class="text-[8px] font-bold text-slate-800 leading-tight">{{ $member->name }}</p>
                    </div>
                    <div class="flex gap-3">
                        <div class="flex-1">
                            <p class="text-[5px] font-semibold text-slate-400 uppercase tracking-wide">NIK</p>
                            <p class="text-[7px] font-mono font-bold text-slate-700">{{ $member->nik ?? '-' }}</p>
                        </div>
                        <div class="flex-1">
                            <p class="text-[5px] font-semibold text-slate-400 uppercase tracking-wide">Telp</p>
                            <p class="text-[7px] font-mono font-bold text-slate-700">{{ $member->phone ?? '-' }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-[5px] font-semibold text-slate-400 uppercase tracking-wide">Alamat</p>
                        <p class="text-[6px] font-bold text-slate-700 leading-tight">{{ $member->address ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-slate-50 border-t border-slate-200 px-3 py-1 flex items-center justify-between">
                <p class="text-[6px] font-mono font-bold text-emerald-700">#{{ str_pad($member->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p class="text-[5px] text-slate-500">Berlaku s/d {{ date('d/m/Y', strtotime('+5 years')) }}</p>
            </div>
        </div>

        <!-- SISI BELAKANG -->
        <div class="text-center no-print">
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Sisi Belakang</span>
        </div>

        <div class="ktp-card bg-white rounded shadow-md overflow-hidden border border-slate-400">

            <!-- Header -->
            <div class="bg-emerald-800 px-3 py-2 text-white text-center">
                <p class="text-[8px] font-extrabold">SYARAT & KETENTUAN</p>
            </div>

            <!-- Isi -->
            <div class="px-3 py-2 space-y-1.5">
                <div>
                    <p class="text-[6px] font-bold text-emerald-800">1. Keanggotaan</p>
                    <p class="text-[5px] text-slate-600">Kartu ini adalah bukti keanggotaan resmi Ranting NU Desa Windunegara.</p>
                </div>
                <div>
                    <p class="text-[6px] font-bold text-emerald-800">2. Penggunaan</p>
                    <p class="text-[5px] text-slate-600">Wajib dibawa saat mengikuti kegiatan organisasi.</p>
                </div>
                <div>
                    <p class="text-[6px] font-bold text-emerald-800">3. Masa Berlaku</p>
                    <p class="text-[5px] text-slate-600">Berlaku 5 tahun sejak tanggal penerbitan.</p>
                </div>
                <div>
                    <p class="text-[6px] font-bold text-emerald-800">4. Penggantian</p>
                    <p class="text-[5px] text-slate-600">Kartu hilang/rusak dapat diganti menghubungi pengurus.</p>
                </div>
            </div>

            <!-- Tanda Tangan -->
            <div class="px-3 pb-2 flex justify-end">
                <div class="text-center">
                    <div class="w-16 border-t border-slate-400 mb-0.5"></div>
                    <p class="text-[5px] font-bold text-slate-600">Ketua Ranting</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-slate-50 border-t border-slate-200 px-3 py-1 text-center">
                <p class="text-[5px] text-slate-500">Diterbitkan oleh Ranting NU Desa Windunegara</p>
            </div>
        </div>

    </div>

</body>
</html>
