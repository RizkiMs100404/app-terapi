<aside id="sidebar" class="fixed top-0 left-0 z-30 flex flex-col flex-shrink-0 hidden w-72 h-full pt-20 duration-300 lg:flex transition-all border-r border-gray-100 dark:bg-gray-900 dark:border-gray-800" aria-label="Sidebar">
    <div class="relative flex flex-col flex-1 min-h-0 bg-white dark:bg-gray-900">

        <div class="flex flex-col flex-1 pt-2 pb-4 overflow-y-auto px-4">
            <div class="flex-1 space-y-4">

                <div>
                    <p class="px-4 mb-3 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Menu Utama</p>
                    <ul class="space-y-1.5">
                        <li>
                            <a href="{{ url('/admin/dashboard') }}"
                               class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all duration-200 group {{ request()->is('admin/dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200 dark:shadow-none' : 'text-gray-500 hover:bg-blue-50 hover:text-blue-600 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                                <svg class="w-5 h-5 transition-colors {{ request()->is('admin/dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span class="ml-3">Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="pt-4 border-t border-gray-50 dark:border-gray-800">
                    <p class="px-4 mb-3 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Data Master</p>
                    <ul class="space-y-1.5">
                        <li>
                            <a href="{{ url('/admin/tahun-ajaran') }}"
                               class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all duration-200 group {{ request()->is('admin/tahun-ajaran*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-gray-500 hover:bg-blue-50 hover:text-blue-600 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                                <i class="fa-solid fa-calendar-days w-5 h-5 flex items-center justify-center transition-colors {{ request()->is('admin/tahun-ajaran*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-600' }}"></i>
                                <span class="ml-3">Tahun Akademik</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('/admin/orangtua') }}"
                               class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all duration-200 group {{ request()->is('admin/orangtua*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-gray-500 hover:bg-blue-50 hover:text-blue-600 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                                <i class="fa-solid fa-users w-5 h-5 flex items-center justify-center transition-colors {{ request()->is('admin/orangtua*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-600' }}"></i>
                                <span class="ml-3">Data Orang Tua</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('/admin/guru-terapis') }}"
                               class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all duration-200 group {{ request()->is('admin/guru*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-gray-500 hover:bg-blue-50 hover:text-blue-600 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                                <i class="fa-solid fa-user-doctor w-5 h-5 flex items-center justify-center transition-colors {{ request()->is('admin/guru*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-600' }}"></i>
                                <span class="ml-3">Data Guru Terapis</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('/admin/siswa') }}"
                               class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all duration-200 group {{ request()->is('admin/siswa*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-gray-500 hover:bg-blue-50 hover:text-blue-600 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                                <i class="fa-solid fa-user-graduate w-5 h-5 flex items-center justify-center transition-colors {{ request()->is('admin/siswa*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-600' }}"></i>
                                <span class="ml-3">Data Siswa</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="pt-4 border-t border-gray-50 dark:border-gray-800">
                    <p class="px-4 mb-3 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Aktivitas & Laporan</p>
                    <ul class="space-y-1.5">
                        <li>
                            <a href="{{ url('/admin/jadwal-terapi') }}"
                               class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all duration-200 group {{ request()->is('admin/jadwal*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-gray-500 hover:bg-blue-50 hover:text-blue-600 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                                <i class="fa-solid fa-calendar-check w-5 h-5 flex items-center justify-center transition-colors {{ request()->is('admin/jadwal*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-600' }}"></i>
                                <span class="ml-3">Jadwal Terapi</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('/admin/rekam-terapi') }}"
                               class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all duration-200 group {{ request()->is('admin/rekam*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-gray-500 hover:bg-blue-50 hover:text-blue-600 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                                <i class="fa-solid fa-file-medical w-5 h-5 flex items-center justify-center transition-colors {{ request()->is('admin/rekam*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-600' }}"></i>
                                <span class="ml-3">Hasil Terapi</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('/admin/laporan') }}"
                               class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all duration-200 group {{ request()->is('admin/laporan*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-gray-500 hover:bg-blue-50 hover:text-blue-600 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                                <i class="fa-solid fa-chart-line w-5 h-5 flex items-center justify-center transition-colors {{ request()->is('admin/laporan*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-600' }}"></i>
                                <span class="ml-3">Laporan Perkembangan</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="pt-4 border-t border-gray-50 dark:border-gray-800">
                    <p class="px-4 mb-3 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Pengaturan Sistem</p>
                    <ul class="space-y-1.5">
                        <li>
                            <a href="{{ url('/admin/users') }}"
                               class="flex items-center px-4 py-3 text-sm font-bold rounded-2xl transition-all duration-200 group {{ request()->is('admin/users*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-gray-500 hover:bg-blue-50 hover:text-blue-600 dark:text-gray-400 dark:hover:bg-gray-800' }}">
                                <i class="fa-solid fa-users-gear w-5 h-5 flex items-center justify-center transition-colors {{ request()->is('admin/users*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-600' }}"></i>
                                <span class="ml-3">Manajemen User</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</aside>

<div class="fixed inset-0 z-20 hidden bg-gray-900/40 backdrop-blur-sm transition-opacity lg:hidden" id="sidebarBackdrop"></div>
