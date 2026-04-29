@extends('guru.layouts.main')

@section('content')
<div class="min-h-screen p-4 lg:p-10 bg-[#FBFEFD]">
    <div class="max-w-6xl mx-auto">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <h1 class="text-4xl font-black text-emerald-950">Daftar <span class="text-emerald-600">Siswa Terapi</span></h1>
                <p class="text-slate-500 font-medium mt-1">Kelola dan pantau perkembangan setiap siswa secara real-time</p>
            </div>

            {{-- Stats Brief (Optional tapi bikin makin Premium) --}}
            <div class="hidden md:flex gap-4">
                <div class="px-6 py-3 bg-white rounded-2xl shadow-sm border border-emerald-50">
                    <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Siswa</span>
                    <span class="text-xl font-black text-emerald-600">{{ $siswa->total() }}</span>
                </div>
            </div>
        </div>

        {{-- SEARCH & FILTER ENGINE (GG Version) --}}
        <form action="{{ route('guru.siswa-terapi.index') }}" method="GET" class="mb-10">
            <div class="bg-white p-4 rounded-[2.5rem] shadow-xl shadow-emerald-900/5 border border-emerald-50 flex flex-col lg:flex-row gap-4 items-end">

                {{-- Search Box --}}
                <div class="flex-1 w-full text-left">
                    <label class="ml-5 mb-2 block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Cari Data Siswa</label>
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-emerald-500"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama atau NIS..."
                            class="w-full pl-12 pr-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-emerald-500/10 font-bold text-slate-700 placeholder:text-slate-400 transition-all">
                    </div>
                </div>

                {{-- Date Range Filter --}}
                <div class="flex flex-col md:flex-row items-center gap-3 w-full lg:w-auto">
                    <div class="w-full md:w-auto">
                        <label class="ml-5 mb-2 block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Mulai Tanggal</label>
                        <div class="relative">
                            <i class="fa-solid fa-calendar-alt absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                class="w-full pl-12 pr-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-emerald-500/10 font-bold text-slate-700 transition-all">
                        </div>
                    </div>
                    <div class="w-full md:w-auto">
                        <label class="ml-5 mb-2 block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Sampai</label>
                        <div class="relative">
                            <i class="fa-solid fa-calendar-check absolute left-5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                class="w-full pl-12 pr-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-emerald-500/10 font-bold text-slate-700 transition-all">
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-2 w-full lg:w-auto">
                    <button type="submit" class="flex-1 lg:flex-none bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-2xl shadow-lg shadow-emerald-200 transition-all active:scale-95 font-black text-sm uppercase tracking-widest">
                        <i class="fa-solid fa-filter mr-2"></i> Filter
                    </button>

                    @if(request()->anyFilled(['search', 'start_date', 'end_date']))
                        <a href="{{ route('guru.siswa-terapi.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-500 px-6 py-4 rounded-2xl transition-all flex items-center justify-center">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Grid Card Siswa --}}
        @if($siswa->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($siswa as $s)
                <div class="group bg-white rounded-[3rem] p-8 shadow-xl shadow-emerald-900/5 border border-white hover:border-emerald-100 hover:shadow-emerald-900/10 transition-all duration-500 relative overflow-hidden">
                    {{-- Decorative Circle --}}
                    <div class="absolute -top-12 -right-12 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-700 opacity-50"></div>

                    <div class="flex items-center gap-5 mb-8 relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-[2rem] flex items-center justify-center text-emerald-600 group-hover:from-emerald-600 group-hover:to-teal-600 group-hover:text-white transition-all duration-500 shadow-inner">
                            <i class="fa-solid fa-user-graduate text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-emerald-950 text-xl leading-tight group-hover:text-emerald-600 transition-colors">{{ $s->nama_siswa }}</h3>
                            <span class="inline-block px-3 py-1 bg-slate-100 rounded-lg text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">NIS: {{ $s->nis }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-8 relative">
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Sesi</span>
                            <span class="text-lg font-black text-emerald-600">{{ $s->rekam_terapi_count }} <span class="text-xs">Sesi</span></span>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Status</span>
                            <span class="text-[10px] font-black text-slate-600 uppercase tracking-tighter italic">Aktif Terapi</span>
                        </div>
                        <div class="col-span-2 p-4 bg-emerald-50/50 rounded-2xl border border-emerald-100/50">
                            <span class="block text-[9px] font-black text-emerald-400 uppercase tracking-widest mb-1">Kebutuhan Khusus</span>
                            <p class="text-xs font-bold text-slate-600 line-clamp-1 italic">"{{ $s->kebutuhan_khusus }}"</p>
                        </div>
                    </div>

                    <a href="{{ route('guru.siswa-terapi.show', $s->id) }}" class="relative flex items-center justify-center gap-3 w-full py-5 bg-emerald-600 text-white rounded-[1.5rem] font-black text-sm uppercase tracking-[0.2em] shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-emerald-300 transition-all active:scale-95 overflow-hidden">
                        <span class="relative z-10">Perkembangan</span>
                        <i class="fa-solid fa-arrow-right-long relative z-10 animate-bounce-x"></i>
                    </a>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-[3rem] p-20 text-center shadow-xl shadow-emerald-900/5 border border-white">
                <div class="w-32 h-32 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                    <i class="fa-solid fa-user-slash text-5xl"></i>
                </div>
                <h3 class="text-2xl font-black text-emerald-950">Siswa Tidak Ditemukan</h3>
                <p class="text-slate-500 mt-2">Coba sesuaikan kata kunci pencarian atau filter tanggal Anda.</p>
                <a href="{{ route('guru.siswa-terapi.index') }}" class="inline-block mt-8 text-emerald-600 font-black uppercase tracking-widest text-sm hover:underline">
                    <i class="fa-solid fa-rotate-left mr-2"></i> Reset Filter
                </a>
            </div>
        @endif

        <div class="mt-12 flex justify-center">
            {{ $siswa->links() }}
        </div>
    </div>
</div>

<style>
    @keyframes bounce-x {
        0%, 100% { transform: translateX(0); }
        50% { transform: translateX(5px); }
    }
    .animate-bounce-x {
        animation: bounce-x 1s infinite;
    }
</style>
@endsection
