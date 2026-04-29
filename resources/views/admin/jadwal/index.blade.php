@extends('admin.layouts.main')

@section('content')
<div class="bg-[#F8FAFC] min-h-screen p-6 lg:p-10">
    <div class="max-w-7xl mx-auto">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Jadwal <span class="text-indigo-600">Terapi</span></h1>
                <p class="text-slate-500 text-sm font-medium mt-1">Manajemen waktu sesi terapi dan penggunaan ruangan.</p>
            </div>
            <a href="{{ route('jadwal-terapi.create') }}" class="flex items-center gap-3 px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-lg shadow-indigo-100 transition-all active:scale-95 font-bold text-xs uppercase tracking-widest">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                TAMBAH JADWAL
            </a>
        </div>

        {{-- Filter Section --}}
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mb-8">
            <form action="{{ route('jadwal-terapi.index') }}" method="GET" class="flex flex-col lg:flex-row gap-3">
                {{-- Search Siswa --}}
                <div class="relative flex-1 group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Siswa..." class="block w-full pl-11 pr-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-semibold focus:ring-2 focus:ring-indigo-100 outline-none text-slate-700 shadow-inner transition-all">
                </div>

                <div class="flex flex-wrap lg:flex-nowrap gap-3">
                    {{-- Input Tanggal Baru --}}
                    <input type="date" name="tanggal" value="{{ $tanggalAktif }}"
                        class="px-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-700 outline-none cursor-pointer shadow-inner focus:ring-2 focus:ring-indigo-100">

                    {{-- Dropdown Hari --}}
                    <select name="hari" class="px-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-700 outline-none cursor-pointer shadow-inner focus:ring-2 focus:ring-indigo-100">
                        <option value="">Semua Hari</option>
                        @foreach(App\Models\JadwalTerapi::listHari() as $h)
                            <option value="{{ $h }}" {{ request('hari') == $h ? 'selected' : '' }}>{{ $h }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="px-6 py-3 bg-slate-900 text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-800 transition-all shadow-md">CARI</button>

                    {{-- Reset Button disesuaikan dengan parameter baru --}}
                    @if(request()->anyFilled(['search', 'hari', 'tanggal']))
                        <a href="{{ route('jadwal-terapi.index') }}" class="px-4 py-3 bg-rose-50 text-rose-600 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-rose-100 transition-all flex items-center justify-center">RESET</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($jadwal as $j)
            <div class="relative group">
                {{-- Effect Glow --}}
                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-[2rem] opacity-0 group-hover:opacity-20 transition duration-500 blur"></div>

                <div class="relative bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-100/50 transition-all duration-500 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-slate-50">
                        <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 w-0 group-hover:w-full transition-all duration-700"></div>
                    </div>

                    <div class="p-6">
                        {{-- Header: Hari & Time Badge --}}
                        <div class="flex justify-between items-center mb-5">
                            <div class="flex items-center gap-3">
                                <div class="px-3 py-1 bg-indigo-600 text-white rounded-lg text-[10px] font-black uppercase tracking-tighter shadow-lg shadow-indigo-200">
                                    {{ $j->hari }}
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                    </span>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $j->ruang_terapi ?? 'Umum' }}</span>
                                </div>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="text-xl font-black text-slate-800 tracking-tight">{{ substr($j->jam_mulai, 0, 5) }}</span>
                                <span class="text-[8px] font-bold text-indigo-500 uppercase tracking-[0.2em] -mt-1">WIB</span>
                            </div>
                        </div>

                        {{-- Nama Siswa & Jenis Terapi --}}
                        <div class="mb-6">
                            <h3 class="text-xl font-black text-slate-900 group-hover:text-indigo-600 transition-colors leading-tight mb-2">
                                {{ $j->siswa->nama_siswa }}
                            </h3>
                            <div class="flex gap-2">
                                <span class="px-2.5 py-1 bg-gradient-to-br from-slate-800 to-slate-900 text-white text-[9px] font-black uppercase rounded-md tracking-wider shadow-sm">
                                    {{ $j->jenis_terapi }}
                                </span>
                            </div>
                        </div>

                        {{-- Terapis Section --}}
                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-100 group-hover:bg-white group-hover:shadow-md transition-all duration-300">
                            <div class="relative">
                                <div class="w-10 h-10 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center text-white font-black text-sm shadow-md">
                                    {{ substr($j->guru->user->name ?? '?', 0, 1) }}
                                </div>
                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-white rounded-full flex items-center justify-center shadow-sm">
                                    <div class="w-2.5 h-2.5 bg-indigo-500 rounded-full"></div>
                                </div>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Terapis Ahli</p>
                                <p class="text-sm font-bold text-slate-700 truncate">{{ $j->guru->user->name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        @if($j->keterangan)
                        <div class="mt-4 px-1">
                            <p class="text-[11px] text-slate-400 font-medium leading-relaxed line-clamp-2 italic">
                                "{{ $j->keterangan }}"
                            </p>
                        </div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-2 mt-6 pt-5 border-t border-slate-50">
                            <a href="{{ route('jadwal-terapi.edit', $j->id) }}" class="flex-[2] py-3 bg-white border border-slate-200 text-slate-700 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all text-center shadow-sm">
                                EDIT
                            </a>
                            <form action="{{ route('jadwal-terapi.destroy', $j->id) }}" method="POST" class="flex-1">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Hapus jadwal {{ $j->siswa->nama_siswa }}?')"
                                        class="w-full py-3 bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-xl transition-all flex items-center justify-center border border-rose-100 hover:border-rose-500 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-16 bg-white rounded-3xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center">
                <p class="text-slate-400 font-bold">Tidak ada jadwal ditemukan.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $jadwal->links() }}
        </div>
    </div>
</div>
@endsection
