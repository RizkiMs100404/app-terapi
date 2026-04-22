<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemulihan Akun | Sistem Terapi SLBN</title>
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #fdfdfd; }
        .mesh-gradient {
            background-color: #ffffff;
            background-image: 
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(59, 130, 246, 0.05) 0px, transparent 50%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(226, 232, 240, 1);
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="mesh-gradient min-h-screen flex items-center justify-center p-6">

    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10">
        <div class="absolute top-[20%] left-[10%] w-96 h-96 bg-emerald-100/40 rounded-full filter blur-3xl animate-pulse"></div>
        <div class="absolute bottom-[20%] right-[10%] w-96 h-96 bg-blue-100/40 rounded-full filter blur-3xl animate-pulse" style="animation-delay: 2s"></div>
    </div>

    <div class="max-w-md w-full">
        <a href="{{ url('/login') }}" class="inline-flex items-center text-sm font-bold text-slate-400 hover:text-emerald-600 transition-colors mb-8 group">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Login
        </a>

        <div class="glass-card p-10 md:p-12 rounded-[3rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)] ring-1 ring-slate-100">
            <div class="mb-10 text-center">
                <div class="h-20 w-20 bg-emerald-50 text-emerald-600 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm border border-emerald-100/50 transition-transform hover:scale-110 duration-500">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 leading-tight tracking-tight">Pemulihan Akun</h2>
                <p class="text-slate-500 mt-4 text-sm font-medium leading-relaxed">
                    Masukkan email Anda. Kami akan mengirimkan kode OTP unik untuk mengatur ulang kata sandi Anda.
                </p>
            </div>

            @if(session('status'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 animate-fade-in">
                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                    <p class="text-emerald-700 text-xs font-bold">{{ session('status') }}</p>
                </div>
            @endif

            <form action="{{ url('/forgot-password') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-3 ml-1">Email Terdaftar</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                        class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 outline-none transition-all font-semibold text-slate-800 placeholder:font-normal placeholder:text-slate-300 shadow-sm"
                        placeholder="nama@email.com">
                    
                    @error('email')
                        <div class="flex items-center gap-1.5 mt-3 ml-1 text-red-500 animate-fade-in">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-[11px] font-bold uppercase">{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <button type="submit" 
                    class="w-full bg-slate-900 text-white font-bold py-4 rounded-2xl shadow-xl shadow-slate-200 hover:bg-emerald-600 hover:shadow-emerald-200 transition-all duration-300 active:scale-[0.98] text-[11px] uppercase tracking-[0.2em]">
                    KIRIM KODE OTP
                </button>
            </form>
        </div>
        
        <p class="mt-10 text-center text-sm font-medium text-slate-400">
            Mengalami kendala? <a href="#" class="text-emerald-600 font-bold hover:underline">Hubungi Admin IT SLB</a>
        </p>
    </div>

    <script>
        // Auto-hide alerts and errors after 4 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.animate-fade-in');
            
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.transition = "all 0.6s ease";
                    alert.style.opacity = "0";
                    alert.style.transform = "translateY(-10px)";
                    
                    setTimeout(() => alert.remove(), 600);
                }, 4000); 
            });
        });
    </script>
</body>
</html>