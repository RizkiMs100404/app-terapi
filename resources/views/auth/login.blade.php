<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistem Pelayanan Terapi SLBN</title>
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
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

    <div class="max-w-5xl w-full grid md:grid-cols-12 gap-0 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.12)] ring-1 ring-slate-200/60 rounded-[3rem] overflow-hidden glass-card">
        
        <div class="hidden md:flex md:col-span-5 flex-col justify-center items-center p-12 bg-slate-50/50 border-r border-gray-100">
            <div id="lottie-container" class="w-full max-w-[320px] h-auto"></div>
            <div class="text-center mt-8">
                <h3 class="text-xl font-bold text-slate-800 italic">E-Therapy Monitoring</h3>
                <p class="mt-2 text-slate-500 text-sm leading-relaxed px-4">
                    Membantu memantau tumbuh kembang ananda dengan kasih sayang dan data yang terukur.
                </p>
            </div>
        </div>

        <div class="md:col-span-7 p-8 md:p-16 flex flex-col justify-center bg-white">
            
            <div class="flex flex-col items-center mb-10">
                <div class="p-4 bg-white rounded-3xl shadow-md border border-gray-50 mb-4 transition-transform hover:scale-105 duration-500">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo SLB" class="h-24 w-auto">
                </div>
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Portal Layanan Terapi</h2>
                <p class="text-slate-400 text-sm font-medium mt-1 uppercase tracking-[0.2em]">SLB Negeri B Garut</p>
            </div>

            @if(session('status'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 animate-fade-in">
                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                <p class="text-emerald-700 text-xs font-bold">{{ session('status') }}</p>
            </div>
            @endif

            <form action="{{ url('/login') }}" method="POST" class="max-w-md mx-auto w-full space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest ml-1">ID Akun / Email</label>
                    <div class="relative group">
                        <input type="text" name="login" value="{{ old('login') }}" required 
                            class="w-full pl-5 pr-5 py-4 bg-white border border-slate-200 rounded-2xl outline-none transition-all focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 text-sm font-semibold shadow-sm"
                            placeholder="Masukkan detail login anda">
                    </div>
                    @error('login')
                        <p class="text-[11px] font-bold text-red-500 mt-1 ml-1 animate-fade-in">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Kata Sandi</label>
                        <a href="{{ url('/forgot-password') }}" class="text-[11px] font-bold text-emerald-600 hover:text-emerald-700">Lupa Password?</a>
                    </div>
                    <div class="relative group">
                        <input type="password" id="passwordInput" name="password" required 
                            class="w-full pl-5 pr-14 py-4 bg-white border border-slate-200 rounded-2xl outline-none transition-all focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 text-sm font-semibold shadow-sm"
                            placeholder="••••••••">
                        
                        <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 flex items-center justify-center text-slate-400 hover:text-emerald-600 transition-all">
                            <i id="eyeIcon" class="fa-regular fa-eye text-lg"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-[11px] font-bold text-red-500 mt-1 ml-1 animate-fade-in">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between px-1">
                    <label class="inline-flex items-center cursor-pointer group" for="remember">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-emerald-600 border-slate-300 rounded focus:ring-emerald-500/20 cursor-pointer">
                        <span class="ml-2 text-xs font-bold text-slate-400 group-hover:text-slate-600 transition-colors">Ingat Saya</span>
                    </label>
                </div>

                <button type="submit" 
                    class="w-full bg-slate-900 text-white font-bold py-4 rounded-2xl shadow-xl shadow-slate-200 hover:bg-emerald-600 hover:shadow-emerald-200 transition-all duration-300 active:scale-[0.98] text-[11px] uppercase tracking-[0.2em]">
                    Masuk Sekarang
                </button>
            </form>
        </div>
    </div>

    <script>
        // Load Lottie Animation
        lottie.loadAnimation({
            container: document.getElementById('lottie-container'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: "{{ asset('lottie/login.json') }}"
        });

        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
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