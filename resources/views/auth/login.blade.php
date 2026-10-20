<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - WANUWIN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <div class="absolute inset-0 bg-gradient-to-br from-emerald-950 via-slate-900 to-emerald-900 opacity-80 pointer-events-none"></div>

    <div class="w-full max-w-md bg-white rounded-3xl p-8 shadow-2xl relative z-10 border border-slate-100">
        
        <!-- Header Form -->
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg border border-amber-300">
                <span class="font-extrabold text-slate-950 text-2xl font-serif">NU</span>
            </div>
            <h1 class="text-2xl font-black text-slate-800">Login Administrator</h1>
            <p class="text-xs text-slate-500 mt-1 font-medium">Masuk untuk mengelola portal WANUWIN</p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-xs text-red-600 font-bold">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1.5">Email Admin</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@wanuwin.id" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition font-medium">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1.5">Password</label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition font-medium">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 text-slate-600 font-medium cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <span>Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs py-3.5 rounded-xl shadow-lg transition">
                Masuk ke Dashboard
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="text-xs font-bold text-slate-400 hover:text-emerald-700 transition">&larr; Kembali ke Beranda Utama</a>
        </div>

    </div>

</body>
</html>