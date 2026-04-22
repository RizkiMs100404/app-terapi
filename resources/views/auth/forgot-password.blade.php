<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemulihan Akun | Sistem Terapi SLB</title>
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full">
        <a href="{{ url('/login') }}" class="inline-flex items-center text-sm font-bold text-slate-400 hover:text-indigo-600 transition-colors mb-8 group">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Login
        </a>

        <div class="glass p-10 md:p-12 rounded-[40px] shadow-2xl shadow-slate-200 border border-white">
            <div class="mb-10 text-center">
                <div class="h-16 w-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 leading-tight tracking-tight">Pemulihan Akun</h2>
                <p class="text-slate-500 mt-4 text-sm font-medium leading-relaxed">
                    Masukkan email Anda. Kami akan mengirimkan kode OTP unik untuk mengatur ulang kata sandi Anda.
                </p>
            </div>

            @if(session('status'))
                <div class="mb-6 p-4 bg-emerald-500/10 text-emerald-700 rounded-2xl text-sm font-bold border border-emerald-500/20 flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ url('/forgot-password') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">Email Terdaftar</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                        class="w-full px-6 py-4 bg-white border @error('email') border-red-500 @else border-slate-200 @enderror rounded-[22px] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-semibold text-slate-800 placeholder:font-normal placeholder:text-slate-300"
                        placeholder="nama@email.com">
                    
                    @error('email')
                        <div class="flex items-center gap-1.5 mt-3 ml-1 text-red-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-xs font-bold">{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <button type="submit" 
                    class="w-full bg-slate-900 text-white font-extrabold py-4 rounded-[22px] shadow-xl shadow-slate-200 hover:bg-indigo-600 hover:shadow-indigo-500/30 transition-all transform active:scale-[0.98]">
                    KIRIM KODE OTP
                </button>
            </form>
        </div>
        
        <p class="mt-10 text-center text-sm font-medium text-slate-400">
            Mengalami kendala? <a href="#" class="text-indigo-600 font-bold hover:underline">Hubungi Admin IT SLB</a>
        </p>
    </div>
</body>
</html>