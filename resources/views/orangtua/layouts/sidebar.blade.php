<aside id="sidebar" class="fixed top-0 left-0 z-30 flex flex-col flex-shrink-0 hidden w-72 h-full pt-20 duration-300 lg:flex transition-all border-r border-indigo-100/50 bg-indigo-50/30 backdrop-blur-xl dark:bg-gray-900 dark:border-gray-800" aria-label="Sidebar">
    <div class="relative flex flex-col flex-1 min-h-0 bg-transparent">
        
        {{-- Efek Cahaya Dekoratif --}}
        <div class="absolute top-0 right-0 -mr-20 mt-20 w-40 h-40 bg-indigo-200/20 blur-[80px] rounded-full pointer-events-none"></div>

        <div class="flex flex-col flex-1 pt-4 pb-4 overflow-y-auto px-4 relative z-10">
            <div class="flex-1 space-y-8">
                
                <!-- SWITCHER ANAK -->
                <div class="px-2">
                    <div class="bg-white/80 dark:bg-indigo-900/40 p-4 rounded-[2rem] shadow-sm border border-white dark:border-indigo-800/30 group hover:shadow-md transition-all duration-500">
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-3 mb-1">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-500 to-teal-500 flex items-center justify-center text-white shadow-lg">
                                    <i class="fa-solid fa-child-reaching text-xs"></i>
                                </div>
                                <p class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest leading-none">Pilih Anak</p>
                            </div>
                            
                            <div class="relative">
                                <select onchange="window.location.href='/orangtua/switch-anak/' + this.value" 
                                        class="block w-full bg-indigo-50/50 dark:bg-gray-800 border-none text-sm font-black text-indigo-950 dark:text-indigo-50 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all cursor-pointer appearance-none py-2 pl-3 pr-8">
                                    @foreach($daftar_anak as $anak)
                                        <option value="{{ $anak->id }}" {{ session('selected_anak_id') == $anak->id ? 'selected' : '' }}>
                                            {{ $anak->nama_siswa }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-indigo-500">
                                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MENU UTAMA -->
                <div>
                    <p class="px-5 mb-4 text-[10px] font-bold text-indigo-400/70 uppercase tracking-[0.25em]">Menu Utama</p>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('orangtua.dashboard') }}" 
                               class="flex items-center px-5 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group 
                               {{ request()->routeIs('orangtua.dashboard') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-200 translate-x-1' : 'text-indigo-900/70 hover:bg-white hover:text-indigo-600 dark:text-gray-400 dark:hover:bg-gray-800 hover:shadow-sm hover:translate-x-1' }}">
                                <i class="fa-solid fa-house-chimney w-5 h-5 flex items-center justify-center transition-transform group-hover:scale-110"></i>
                                <span class="ml-3">Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('orangtua.jadwal') }}" 
                            class="flex items-center px-5 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group 
                            {{ request()->routeIs('orangtua.jadwal') || request()->routeIs('orangtua.jadwal.show') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-200 translate-x-1' : 'text-indigo-900/70 hover:bg-white hover:text-indigo-600 dark:text-gray-400 dark:hover:bg-gray-800 hover:shadow-sm hover:translate-x-1' }}">
                                <i class="fa-solid fa-calendar-day w-5 h-5 flex items-center justify-center transition-transform group-hover:scale-110"></i>
                                <span class="ml-3">Jadwal Terapi</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- MONITORING -->
                <div>
                    <p class="px-5 mb-4 text-[10px] font-bold text-indigo-400/70 uppercase tracking-[0.25em]">Monitoring</p>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('orangtua.perkembangan') }}" 
                               class="flex items-center px-5 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group 
                               {{ request()->routeIs('orangtua.perkembangan*') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-200 translate-x-1' : 'text-indigo-900/70 hover:bg-white hover:text-indigo-600 dark:text-gray-400 dark:hover:bg-gray-800 hover:shadow-sm hover:translate-x-1' }}">
                                <i class="fa-solid fa-seedling w-5 h-5 flex items-center justify-center transition-transform group-hover:scale-110"></i>
                                <span class="ml-3">Perkembangan Anak</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('orangtua.jadwal.history') }}" 
                            class="flex items-center px-5 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group 
                            {{ request()->routeIs('orangtua.jadwal.history') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-200 translate-x-1' : 'text-indigo-900/70 hover:bg-white hover:text-indigo-600 dark:text-gray-400 dark:hover:bg-gray-800 hover:shadow-sm hover:translate-x-1' }}">
                                <i class="fa-solid fa-file-waveform w-5 h-5 flex items-center justify-center transition-transform group-hover:scale-110"></i>
                                <span class="ml-3">Hasil Terapi</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- WHATSAPP KONSULTASI -->
                <div class="pt-4">
                    <div class="px-4">
                        <a href="{{ $link_wa ?? '#' }}" target="_blank"
                           class="flex flex-col items-center justify-center gap-1 px-4 py-4 text-xs font-black rounded-3xl transition-all duration-300 bg-gradient-to-r from-indigo-500 to-teal-500 text-white shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:-translate-y-1 active:scale-95 text-center">
                            <div class="flex items-center gap-2">
                                <i class="fa-brands fa-whatsapp text-xl animate-bounce-slow"></i>
                                <span>Konsultasi Whatsapp</span>
                            </div>
                            <span class="text-[9px] opacity-80 font-medium truncate w-full italic">Ananda: {{ $nama_anak ?? 'Anak Aktif' }}</span>
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
    .overflow-y-auto::-webkit-scrollbar {
        width: 4px;
    }
    .overflow-y-auto::-webkit-scrollbar-track {
        background: transparent;
    }
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: rgba(99, 102, 241, 0.2);
        border-radius: 10px;
    }
</style>