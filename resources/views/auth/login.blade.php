<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Pelayanan Sistem Terapi</title>
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #f8fafc;
        }
        .mesh-gradient {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(14, 165, 233, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(79, 70, 229, 0.08) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(14, 165, 233, 0.08) 0px, transparent 50%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.7);
        }
        .input-focus-effect:focus {
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="mesh-gradient min-h-screen flex items-center justify-center p-4 md:p-8">

    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10">
        <div class="absolute top-[10%] left-[5%] w-72 h-72 bg-indigo-200/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
        <div class="absolute bottom-[10%] right-[5%] w-72 h-72 bg-sky-200/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
    </div>

    <div class="max-w-4xl w-full grid md:grid-cols-2 shadow-[0_32px_64px_-15px_rgba(0,0,0,0.08)] rounded-[40px] overflow-hidden glass-card">
        
        <div class="hidden md:flex flex-col justify-between p-12 bg-slate-900 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mt-16"></div>
            
            <div class="relative z-10">
                <div class="inline-flex items-center justify-center p-3 bg-indigo-500/20 rounded-2xl border border-indigo-400/30 mb-8">
                    <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold leading-tight tracking-tight">
                    Pelayanan Terapi <br>
                    <span class="text-indigo-400">SLB Terintegrasi</span>
                </h1>
                <p class="mt-4 text-slate-400 text-sm leading-relaxed">
                    Solusi digital untuk memantau tumbuh kembang, laporan terapi harian, dan koordinasi antara terapis serta orang tua secara transparan.
                </p>
            </div>
            
            <div class="relative z-10 space-y-4">
                <div class="flex items-center gap-3 p-3 bg-white/5 rounded-2xl border border-white/10">
                    <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                    <span class="text-xs font-medium text-slate-300">Sistem Monitoring Real-time Aktif</span>
                </div>
                <p class="text-[11px] text-slate-500 font-medium tracking-wide uppercase">© 2026 E-Therapy SLB. All Rights Reserved.</p>
            </div>
        </div>

        <div class="p-8 md:p-12 lg:p-16 flex flex-col justify-center bg-white/40">
            
            <div class="text-center md:text-left mb-8">
                <img src="{{ asset('img/logo.png') }}" alt="Logo SLB" class="h-20 w-auto mb-6 mx-auto md:mx-0 drop-shadow-sm items-center">
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Selamat Datang</h2>
                <p class="text-slate-500 text-sm mt-1 font-medium">Silakan masuk untuk mengakses layanan.</p>
            </div>

            @if(session('status'))
            <div class="mb-6 p-3 bg-emerald-50 border border-emerald-100 rounded-xl flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <p class="text-emerald-700 text-xs font-bold">{{ session('status') }}</p>
            </div>
            @endif

            <form action="{{ url('/login') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wider ml-1">Username / Email</label>
                    <input type="text" name="login" value="{{ old('login') }}" required 
                        class="input-focus-effect w-full px-5 py-3.5 bg-white border @error('login') border-red-400 @else border-slate-200 @enderror rounded-2xl outline-none transition-all text-sm font-medium placeholder:text-slate-400 shadow-sm"
                        placeholder="Masukkan detail akun">
                    @error('login')
                        <p class="text-[11px] font-bold text-red-500 mt-1.5 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex justify-between mb-2 ml-1">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Password</label>
                        <a href="{{ url('/forgot-password') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors">Lupa Password?</a>
                    </div>
                    <input type="password" name="password" required 
                        class="input-focus-effect w-full px-5 py-3.5 bg-white border @error('password') border-red-400 @else border-slate-200 @enderror rounded-2xl outline-none transition-all text-sm font-medium shadow-sm"
                        placeholder="••••••••">
                    @error('password')
                        <p class="text-[11px] font-bold text-red-500 mt-1.5 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center ml-1">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500/20 cursor-pointer">
                    <label for="remember" class="ml-2.5 text-xs font-semibold text-slate-500 cursor-pointer select-none">Ingat perangkat ini</label>
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full bg-indigo-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:shadow-indigo-300/40 transition-all active:scale-[0.97] text-sm uppercase tracking-widest">
                        Masuk Ke Sistem
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center">
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[2px]">Portal Resmi SLB Negeri</p>
            </div>
        </div>
    </div>

    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
    </style>
</body>
</html>