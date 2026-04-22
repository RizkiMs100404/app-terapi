<nav class="fixed z-40 w-full bg-white/80 backdrop-blur-xl border-b border-gray-100 dark:bg-gray-950/80 dark:border-gray-800 transition-all duration-300">
  <div class="px-4 py-2 lg:px-8">
    <div class="flex items-center justify-between h-16">
      
      <div class="flex items-center justify-start flex-1">
        <button id="toggleSidebarMobile" class="p-2 mr-3 text-gray-500 rounded-xl lg:hidden hover:bg-emerald-50 hover:text-emerald-600 dark:hover:bg-gray-800 transition-colors">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
        </button>
        
        <a href="{{ url('/guru/dashboard') }}" class="flex items-center gap-4 group">
          <div class="relative">
            <img src="{{ asset('img/logo.png') }}" 
                 class="h-12 w-auto object-contain transform group-hover:rotate-6 transition-all duration-500" 
                 alt="Logo">
            <div class="absolute inset-0 bg-emerald-400/20 blur-xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
          </div>

          <div class="flex flex-col justify-center">
            <span class="hidden lg:block leading-none text-xl font-black tracking-tighter dark:text-white uppercase">
                PORTAL<span class="text-emerald-600 italic"> TERAPIS</span>
            </span>
            <span class="hidden lg:block text-[9px] font-bold text-gray-400 tracking-[0.3em] uppercase leading-none mt-1">
               SLB Negeri Bagian B Garut
            </span>
          </div>
        </a>
      </div>

      <div class="hidden md:flex flex-[2] justify-center">
        <form action="#" method="GET" class="w-full max-w-lg">
          <div class="relative group">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
              <svg class="w-4 h-4 text-gray-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" name="search" id="topbar-search" 
              class="bg-gray-100/50 border-none text-gray-900 text-sm rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:bg-white block w-full pl-11 p-3 dark:bg-gray-800/50 dark:text-white dark:focus:bg-gray-800 transition-all outline-none shadow-sm" 
              placeholder="Cari jadwal atau nama siswa...">
          </div>
        </form>
      </div>

      <div class="flex items-center justify-end flex-1 gap-2 md:gap-4">
        <button type="button" class="relative p-2.5 text-gray-500 rounded-2xl hover:bg-emerald-50 hover:text-emerald-600 dark:hover:bg-gray-800 transition-all">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
          <span class="absolute top-3 right-3 flex h-2.5 w-2.5">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500 border-2 border-white dark:border-gray-900"></span>
          </span>
        </button>

        <div class="flex items-center">
          <button type="button" class="flex items-center p-1.5 rounded-2xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-all border border-transparent hover:border-gray-200" id="user-menu-button-2" data-dropdown-toggle="dropdown-2">
            <img class="w-9 h-9 rounded-xl object-cover shadow-sm ring-2 ring-emerald-500/20" 
                 src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=10b981&color=fff&bold=true" alt="User">
            <div class="hidden md:block text-left ml-3 mr-2">
                <p class="text-xs font-extrabold text-gray-900 dark:text-white leading-none capitalize">{{ Auth::user()->name }}</p>
                <p class="text-[10px] font-medium text-emerald-600 mt-1">{{ Auth::user()->username }}</p>
            </div>
            <svg class="w-4 h-4 text-gray-400 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
          </button>
          
          <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-[2xl] shadow-2xl border border-gray-100 dark:bg-gray-900 dark:divide-gray-800 dark:border-gray-800 overflow-hidden" id="dropdown-2" style="min-width: 260px;">
            <div class="px-6 py-6 bg-gradient-to-br from-emerald-50 via-white to-white dark:from-emerald-900/20 dark:to-gray-900">
              <div class="flex items-center gap-3 mb-1">
                  <img class="w-12 h-12 rounded-2xl ring-4 ring-white shadow-lg" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=10b981&color=fff&bold=true" alt="">
                  <div class="overflow-hidden">
                    <p class="text-base font-black text-gray-900 dark:text-white leading-none truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] font-medium text-gray-500 mt-1 truncate">{{ Auth::user()->email }}</p> 
                  </div>
              </div>
            </div>
            
            <div class="p-2">
              <a href="{{ url('/guru/profile') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-gray-700 rounded-xl hover:bg-emerald-50 hover:text-emerald-600 dark:text-gray-300 dark:hover:bg-gray-800 transition-all group">
                <div class="p-2 bg-gray-50 dark:bg-gray-800 rounded-lg group-hover:bg-white dark:group-hover:bg-emerald-900/30 shadow-sm transition-all">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2"></path></svg>
                </div>
                Profil Saya
              </a>
            </div>

            <div class="p-2 bg-gray-50/50 dark:bg-gray-800/30">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 px-4 py-3 text-sm font-bold text-red-600 rounded-xl hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 transition-all group">
                  <div class="p-2 bg-red-100/50 dark:bg-red-900/20 rounded-lg group-hover:rotate-12 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-width="2"></path></svg>
                  </div>
                  Log Out
                </button>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</nav>