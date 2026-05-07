<nav class="fixed z-40 w-full bg-white/80 backdrop-blur-xl border-b border-indigo-50 dark:bg-gray-900/80 dark:border-gray-800 transition-all duration-300">
    <div class="px-4 py-2 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <!-- SISI KIRI: LOGO & MOBILE TOGGLE -->
            <div class="flex items-center justify-start flex-1">
                <button id="toggleSidebarMobile" class="p-2 mr-3 text-indigo-500 rounded-xl lg:hidden hover:bg-indigo-50 dark:hover:bg-gray-800 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                </button>
                
                <a href="{{ url('/orangtua/dashboard') }}" class="flex items-center gap-4 group">
                    <div class="relative">
                        <img src="{{ asset('img/logo.png') }}" 
                             class="h-12 w-auto object-contain transform group-hover:rotate-6 transition-all duration-500 ease-out" 
                             alt="Logo">
                        <div class="absolute inset-0 bg-indigo-400/30 blur-xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>

                    <div class="flex flex-col justify-center">
                        <span class="hidden lg:block leading-none text-2xl font-black tracking-tighter dark:text-white uppercase">
                            PORTAL<span class="text-indigo-600 italic"> TERAPI</span>
                        </span>
                        <span class="hidden lg:block text-[10px] font-bold text-gray-400 tracking-[0.3em] uppercase leading-none mt-1">
                           SLB Negeri Bagian B Garut
                        </span>
                    </div>
                </a>
            </div>

            <!-- SISI KANAN: NOTIFIKASI & USER MENU -->
            <div class="flex items-center justify-end flex-1 gap-2 md:gap-4">
                
                <!-- NOTIFIKASI -->
                <button type="button" class="relative p-2.5 text-gray-500 rounded-2xl hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-gray-800 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span class="absolute top-3 right-3 flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-indigo-600 border-2 border-white dark:border-gray-900"></span>
                    </span>
                </button>

                <!-- USER DROPDOWN -->
                <div class="flex items-center">
                    <button type="button" class="flex items-center p-1.5 rounded-2xl hover:bg-indigo-50 dark:hover:bg-gray-800 transition-all group" id="user-menu-button-2" data-dropdown-toggle="dropdown-2">
                        <div class="relative">
                            <img class="w-10 h-10 rounded-xl object-cover shadow-md ring-2 ring-indigo-500/20 group-hover:ring-indigo-500 transition-all" 
                                 src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366F1&color=fff&bold=true" alt="User">
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white dark:border-gray-900 rounded-full"></div>
                        </div>
                        <div class="hidden md:block text-left ml-3 mr-2">
                            <p class="text-xs font-bold text-gray-400 uppercase leading-none mb-1">Orang Tua</p>
                            <p class="text-sm font-black text-gray-900 dark:text-white leading-none capitalize">{{ Auth::user()->name }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                    
                    <!-- DROPDOWN CONTENT (Tanpa Animasi Transition) -->
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-[2rem] shadow-2xl border border-indigo-50 dark:bg-gray-900 dark:divide-gray-800 dark:border-gray-800 overflow-hidden" id="dropdown-2" style="min-width: 280px;">
                        <div class="px-6 py-6 bg-gradient-to-br from-indigo-600 to-violet-700">
                            <p class="text-[10px] font-bold text-indigo-200 uppercase tracking-[0.2em] mb-2">Halo, Ayah/Bunda!</p>
                            <p class="text-lg font-black text-white leading-none mb-1">{{ Auth::user()->name }}</p>
                            <p class="text-xs font-medium text-indigo-100/80 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        
                        <div class="p-3">
                            <a href="{{ route('orangtua.profile.edit') }}" 
                            class="flex items-center gap-4 px-4 py-3 text-sm font-bold rounded-2xl transition-all group 
                            {{ request()->routeIs('orangtua.profile.edit') 
                                ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' 
                                : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 dark:text-gray-300 dark:hover:bg-gray-800' }}">
                                
                                <div class="p-2 {{ request()->routeIs('orangtua.profile.edit') ? 'bg-white/20' : 'bg-indigo-100 dark:bg-indigo-900/30' }} rounded-xl group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                                Pengaturan Profil
                            </a>
                            <a href="{{ route('orangtua.siswa.edit') }}" 
                                class="flex items-center gap-4 px-4 py-3 text-sm font-bold rounded-2xl transition-all group 
                                {{ request()->routeIs('orangtua.siswa.edit') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }}">
                                    <div class="p-2 {{ request()->routeIs('orangtua.siswa.edit') ? 'bg-white/20' : 'bg-indigo-100' }} rounded-xl transition-transform group-hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-width="2"></path></svg>
                                    </div>
                                    Profil Anak
                                </a>
                        </div>

                        <div class="p-3 bg-gray-50/50 dark:bg-gray-800/50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-4 px-4 py-3 text-sm font-bold text-rose-600 rounded-2xl hover:bg-rose-100 dark:text-rose-400 dark:hover:bg-rose-900/20 transition-all group">
                                    <div class="p-2 bg-rose-100/50 dark:bg-rose-900/20 rounded-xl">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-width="2"></path>
                                        </svg>
                                    </div>
                                    Keluar Dari Sistem
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</nav>