<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Password Baru | Sistem Terapi SLB</title>
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
        /* Menghilangkan panah di input number */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full">
        <div class="glass p-10 rounded-[40px] shadow-2xl shadow-slate-200 border border-white">
            <h2 class="text-2xl font-black text-slate-900 text-center mb-2">Verifikasi OTP</h2>
            <p class="text-center text-slate-500 text-sm mb-8 font-medium">Masukkan kode 6 digit yang kami kirim ke email dan tentukan password baru Anda.</p>

            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1 text-center">Kode OTP</label>
                    <input type="number" name="otp" required maxlength="6"
                        class="w-full px-6 py-4 bg-slate-50 border @error('otp') border-red-500 @else border-slate-200 @enderror rounded-[22px] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none text-center text-2xl tracking-[10px] font-bold transition-all"
                        placeholder="000000">
                    @error('otp')
                        <p class="text-red-500 text-[11px] mt-2 font-bold text-center italic">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">Password Baru</label>
                    <input type="password" name="password" required 
                        class="w-full px-6 py-4 bg-slate-50 border @error('password') border-red-500 @else border-slate-200 @enderror rounded-[22px] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-semibold transition-all"
                        placeholder="••••••••">
                    @error('password')
                        <p class="text-red-500 text-[11px] mt-2 font-bold ml-1 italic">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[2px] mb-3 ml-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required 
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-[22px] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-semibold transition-all"
                        placeholder="••••••••">
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full bg-slate-900 text-white font-extrabold py-4 rounded-[22px] shadow-xl shadow-slate-200 hover:bg-indigo-600 hover:shadow-indigo-500/30 transition-all transform active:scale-[0.98]">
                        SIMPAN PASSWORD
                    </button>
                </div>
            </form>
        </div>

        <p class="mt-8 text-center text-xs text-slate-400 font-bold uppercase tracking-widest">
            Keamanan Data Prioritas Kami
        </p>
    </div>
</body>
</html>