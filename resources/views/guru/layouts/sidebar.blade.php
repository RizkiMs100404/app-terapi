<aside id="sidebar" class="fixed top-0 left-0 z-30 flex flex-col flex-shrink-0 hidden w-72 h-full pt-20 duration-300 lg:flex transition-all border-r border-gray-100 dark:bg-gray-900 dark:border-gray-800" aria-label="Sidebar">
    <div class="relative flex flex-col flex-1 min-h-0 bg-white dark:bg-gray-900">
        
        <div class="flex flex-col flex-1 pt-2 pb-4 overflow-y-auto px-4">
            <div class="flex-1 space-y-4">
                
                <div>
                    <p class="px-4 mb-3 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Utama</p>
                    <ul class="space-y-1.5">
                        <li>
                            <a href="{{ url('/guru/dashboard') }}" 
                               class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all duration-200 group {{ request()->is('guru/dashboard') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200 dark:shadow-none' : 'text-gray-500 hover:bg-emerald-50 hover:text-emerald-600 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                                <svg class="w-5 h-5 transition-colors {{ request()->is('guru/dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-emerald-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span class="ml-3">Dashboard Terapis</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="pt-4 border-t border-gray-50 dark:border-gray-800">
                    <p class="px-4 mb-3 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Pelayanan Terapi</p>
                    <ul class="space-y-1.5">
                        <li>
                            <a href="{{ url('/guru/jadwal') }}" 
                               class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all duration-200 group {{ request()->is('guru/jadwal*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'text-gray-500 hover:bg-emerald-50 hover:text-emerald-600 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                                <i class="fa-solid fa-calendar-day w-5 h-5 flex items-center justify-center transition-colors {{ request()->is('guru/jadwal*') ? 'text-white' : 'text-gray-400 group-hover:text-emerald-600' }}"></i>
                                <span class="ml-3">Jadwal Terapi</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('/guru/input-hasil') }}" 
                               class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all duration-200 group {{ request()->is('guru/input-hasil*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'text-gray-500 hover:bg-emerald-50 hover:text-emerald-600 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                                <i class="fa-solid fa-file-signature w-5 h-5 flex items-center justify-center transition-colors {{ request()->is('guru/input-hasil*') ? 'text-white' : 'text-gray-400 group-hover:text-emerald-600' }}"></i>
                                <span class="ml-3">Input Hasil Terapi</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('/guru/riwayat') }}" 
                               class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all duration-200 group {{ request()->is('guru/riwayat*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'text-gray-500 hover:bg-emerald-50 hover:text-emerald-600 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                                <i class="fa-solid fa-clock-rotate-left w-5 h-5 flex items-center justify-center transition-colors {{ request()->is('guru/riwayat*') ? 'text-white' : 'text-gray-400 group-hover:text-emerald-600' }}"></i>
                                <span class="ml-3">Riwayat Terapi</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</aside>

<div class="fixed inset-0 z-20 hidden bg-emerald-900/20 backdrop-blur-sm transition-opacity" id="sidebarBackdrop"></div>