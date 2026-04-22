<aside id="sidebar" class="fixed top-0 left-0 z-30 flex flex-col flex-shrink-0 hidden w-72 h-full pt-20 duration-300 lg:flex transition-all border-r border-indigo-100/50 bg-indigo-50/30 backdrop-blur-xl dark:bg-gray-900 dark:border-gray-800" aria-label="Sidebar">
    <div class="relative flex flex-col flex-1 min-h-0 bg-transparent">
        
        <div class="absolute top-0 right-0 -mr-20 mt-20 w-40 h-40 bg-indigo-200/20 blur-[80px] rounded-full pointer-events-none"></div>

        <div class="flex flex-col flex-1 pt-4 pb-4 overflow-y-auto px-4 relative z-10">
            <div class="flex-1 space-y-8">
                
                <div class="px-2">
                    <div class="bg-white/80 dark:bg-indigo-900/40 p-5 rounded-[2rem] shadow-sm border border-white dark:border-indigo-800/30 group hover:shadow-md transition-all duration-500">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-violet-500 flex items-center justify-center text-white shadow-lg">
                                <i class="fa-solid fa-child-reaching text-sm"></i>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest leading-none mb-1">Anak Saya</p>
                                <p class="text-sm font-black text-indigo-950 dark:text-indigo-50 truncate">Budi Santoso</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <p class="px-5 mb-4 text-[10px] font-bold text-indigo-400/70 uppercase tracking-[0.25em]">Menu Utama</p>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ url('/ortu/dashboard') }}" 
                               class="flex items-center px-5 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->is('ortu/dashboard') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-200 dark:shadow-none translate-x-1' : 'text-indigo-900/70 hover:bg-white hover:text-indigo-600 dark:text-gray-400 dark:hover:bg-gray-800 hover:shadow-sm hover:translate-x-1' }}">
                                <i class="fa-solid fa-house-chimney w-5 h-5 flex items-center justify-center transition-transform group-hover:scale-110"></i>
                                <span class="ml-3">Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('/ortu/jadwal') }}" 
                               class="flex items-center px-5 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->is('ortu/jadwal*') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-200' : 'text-indigo-900/70 hover:bg-white hover:text-indigo-600 dark:text-gray-400 dark:hover:bg-gray-800 hover:shadow-sm hover:translate-x-1' }}">
                                <i class="fa-solid fa-calendar-day w-5 h-5 flex items-center justify-center transition-transform group-hover:scale-110"></i>
                                <span class="ml-3">Jadwal Terapi</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <p class="px-5 mb-4 text-[10px] font-bold text-indigo-400/70 uppercase tracking-[0.25em]">Monitoring</p>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ url('/ortu/perkembangan') }}" 
                               class="flex items-center px-5 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->is('ortu/perkembangan*') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-200' : 'text-indigo-900/70 hover:bg-white hover:text-indigo-600 dark:text-gray-400 dark:hover:bg-gray-800 hover:shadow-sm hover:translate-x-1' }}">
                                <i class="fa-solid fa-seedling w-5 h-5 flex items-center justify-center transition-transform group-hover:scale-110"></i>
                                <span class="ml-3">Perkembangan</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('/ortu/hasil') }}" 
                               class="flex items-center px-5 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group {{ request()->is('ortu/hasil*') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-200' : 'text-indigo-900/70 hover:bg-white hover:text-indigo-600 dark:text-gray-400 dark:hover:bg-gray-800 hover:shadow-sm hover:translate-x-1' }}">
                                <i class="fa-solid fa-file-waveform w-5 h-5 flex items-center justify-center transition-transform group-hover:scale-110"></i>
                                <span class="ml-3">Hasil Terapi</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="pt-4">
                    <div class="px-4">
                        <a href="https://wa.me/628123456789" target="_blank"
                           class="flex items-center justify-center gap-3 px-4 py-4 text-sm font-black rounded-3xl transition-all duration-300 bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg shadow-emerald-200 hover:shadow-emerald-300 hover:-translate-y-1 active:scale-95">
                            <i class="fa-brands fa-whatsapp text-xl animate-bounce-slow"></i>
                            <span>Konsultasi Via Whatsapp</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>

<style>
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
    }
    .animate-bounce-slow {
        animation: bounce-slow 2s infinite;
    }
</style>