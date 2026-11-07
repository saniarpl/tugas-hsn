<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - WANUWIN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
        :focus-visible { outline: 2px solid #047857; outline-offset: 2px; }
    </style>
</head>
<body class="flex min-h-screen items-center justify-center bg-slate-100 p-4 text-slate-700 sm:p-6">

    <div class="w-full max-w-4xl overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="grid md:grid-cols-2">

            <div class="hidden flex-col justify-between bg-[#043D2B] p-10 text-white md:flex">
                <div class="flex items-center gap-3">
                    <span class="grid h-11 w-11 place-items-center rounded-md bg-white/10 text-base font-extrabold" aria-hidden="true">NU</span>
                    <div>
                        <p class="text-lg font-extrabold leading-none">WANUWIN</p>
                        <p class="mt-1 text-[10px] font-semibold uppercase tracking-[0.14em] text-amber-300">Ranting NU Windunegara</p>
                    </div>
                </div>

                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-amber-300">Portal Resmi</p>
                    <h2 class="mt-3 text-2xl font-bold leading-snug">Panel Administrasi WANUWIN</h2>
                    <p class="mt-3 text-sm leading-6 text-emerald-50/75">Kelola warta berita, agenda kegiatan, galeri, data anggota, infaq masjid, dan masukan masyarakat dalam satu tempat.</p>
                </div>

                <p class="text-xs leading-5 text-emerald-100/50">Ranting Nahdlatul Ulama Desa Windunegara<br>Kec. Wangon, Kab. Banyumas</p>
            </div>

            <div class="p-8 sm:p-10">
                <div class="mb-8 md:hidden">
                    <span class="grid h-11 w-11 place-items-center rounded-md bg-[#065F46] text-base font-extrabold text-white" aria-hidden="true">NU</span>
                </div>

                <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-emerald-700">Administrator</p>
                <h1 class="mt-1 text-xl font-bold text-slate-900">Masuk Panel Admin</h1>
                <p class="mt-2 text-sm text-slate-500">Gunakan akun yang telah terdaftar untuk melanjutkan.</p>

                @if($errors->any())
                    <div class="mt-6 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-xs font-semibold text-red-700" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="mt-6 space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-1.5 block text-xs font-bold text-slate-700">Email Admin</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                               placeholder="admin@wanuwin.id"
                               class="w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-800 outline-none transition-colors focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20">
                    </div>

                    <div>
                        <label for="password" class="mb-1.5 block text-xs font-bold text-slate-700">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               placeholder="••••••••"
                               class="w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-800 outline-none transition-colors focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20">
                    </div>

                    <label class="flex cursor-pointer items-center gap-2 text-xs font-medium text-slate-600">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-emerald-700 focus:ring-emerald-600">
                        <span>Ingat saya pada perangkat ini</span>
                    </label>

                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-md bg-[#065F46] px-5 py-3 text-sm font-bold text-white transition-colors hover:bg-[#054F3A]">
                        Masuk ke Dashboard
                        <span aria-hidden="true">&rarr;</span>
                    </button>
                </form>

                <div class="mt-8 border-t border-slate-200 pt-5">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 transition-colors hover:text-emerald-800">
                        <span aria-hidden="true">&larr;</span> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
