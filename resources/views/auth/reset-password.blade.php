<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Password Baru | Sistem Terapi SLBN</title>
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
        /* Menghilangkan panah di input number */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        
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
        <div class="glass-card p-10 rounded-[3rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)] ring-1 ring-slate-100">
            <h2 class="text-2xl font-extrabold text-slate-900 text-center mb-2 tracking-tight">Verifikasi OTP</h2>
            <p class="text-center text-slate-500 text-sm mb-8 font-medium leading-relaxed px-2">Masukkan kode 6 digit dari email dan tentukan password baru Anda.</p>

            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-3 ml-1 text-center">Kode OTP</label>
                    <input type="number" name="otp" required maxlength="6"
                        class="w-full px-6 py-4 bg-white border @error('otp') border-red-500 @else border-slate-200 @enderror rounded-2xl focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 outline-none text-center text-2xl tracking-[10px] font-bold transition-all shadow-sm"
                        placeholder="000000">
                    @error('otp')
                        <p class="text-red-500 text-[11px] mt-2 font-bold text-center animate-fade-in lowercase tracking-tight italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest ml-1">Password Baru</label>
                    <div class="relative group">
                        <input type="password" id="passwordInput" name="password" required 
                            class="w-full pl-6 pr-14 py-4 bg-white border @error('password') border-red-500 @else border-slate-200 @enderror rounded-2xl focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 outline-none font-semibold transition-all shadow-sm"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePassword('passwordInput', 'eyeIcon1')" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 flex items-center justify-center text-slate-400 hover:text-emerald-600 transition-all">
                            <i id="eyeIcon1" class="fa-regular fa-eye text-lg"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-[11px] mt-1 font-bold ml-1 animate-fade-in italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest ml-1">Konfirmasi Password</label>
                    <div class="relative group">
                        <input type="password" id="passwordConfirmInput" name="password_confirmation" required 
                            class="w-full pl-6 pr-14 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 outline-none font-semibold transition-all shadow-sm"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePassword('passwordConfirmInput', 'eyeIcon2')" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 flex items-center justify-center text-slate-400 hover:text-emerald-600 transition-all">
                            <i id="eyeIcon2" class="fa-regular fa-eye text-lg"></i>
                        </button>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                        class="w-full bg-slate-900 text-white font-bold py-4 rounded-2xl shadow-xl shadow-slate-200 hover:bg-emerald-600 hover:shadow-emerald-200 transition-all duration-300 active:scale-[0.98] text-[11px] uppercase tracking-[0.2em]">
                        SIMPAN PASSWORD
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

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