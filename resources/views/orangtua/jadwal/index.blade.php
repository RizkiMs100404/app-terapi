@extends('orangtua.layouts.main')

@section('content')
<div class="min-h-screen p-4 lg:p-10">
    <div class="max-w-7xl mx-auto">
        
        {{-- Header & Filter --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 mb-12">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                        <i class="fa-solid fa-calendar-check text-xl"></i>
                    </span>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Jadwal <span class="text-indigo-500">Terapi</span></h1>
                </div>
                <p class="text-slate-500 font-medium">Agenda untuk <span class="text-indigo-600 font-bold">{{ $anak->nama_siswa }}</span> pada hari {{ $hariIndo }}.</p>
            </div>

            <form action="{{ route('orangtua.jadwal') }}" method="GET" class="bg-white p-3 rounded-[2.5rem] shadow-xl shadow-indigo-900/5 border border-indigo-50 flex flex-col md:flex-row items-center gap-4">
                <div class="flex items-center px-4 gap-3">
                    <i class="fa-solid fa-calendar-day text-indigo-400"></i>
                    <input type="date" name="tanggal" value="{{ $tanggalAktif }}" 
                        class="border-none focus:ring-0 text-sm font-black text-indigo-900 bg-transparent cursor-pointer">
                </div>
                <button type="submit" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-full font-black text-sm transition-all shadow-lg shadow-indigo-200 active:scale-95">
                    Tampilkan Jadwal
                </button>
            </form>
        </div>

        {{-- Jadwal Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @forelse ($jadwal as $item)
                @php
                    $laporanSelesai = $item->rekamTerapi->first();
                    $isRealtimeToday = ($tanggalAktif == date('Y-m-d'));
                @endphp

                <div class="group bg-white rounded-[3rem] p-8 border border-indigo-50 shadow-sm hover:shadow-2xl hover:shadow-indigo-200/40 transition-all duration-500 relative overflow-hidden">
                    
                    {{-- Status Badge --}}
                    @if($laporanSelesai)
                        <div class="absolute -right-12 top-6 bg-indigo-500 text-white text-[10px] font-black py-1 w-40 text-center rotate-45 shadow-lg z-10">SELESAI</div>
                    @elseif($isRealtimeToday)
                        <div class="absolute -right-12 top-6 bg-amber-500 text-white text-[10px] font-black py-1 w-40 text-center rotate-45 shadow-lg z-10">HARI INI</div>
                    @endif

                    <div class="relative">
                        <div class="flex justify-between items-start mb-6">
                            <div class="flex gap-2"> {{-- Ditambah div flex gap --}}
                                {{-- LABEL SESI OTOMATIS --}}
                                <span class="bg-amber-100 text-amber-700 text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-full border border-amber-200">
                                    {{ $item->nomor_sesi }}
                                </span>

                                <span class="bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-full border border-indigo-100">
                                    {{ $item->jenis_terapi }}
                                </span>
                            </div>
                        </div>

                        <h3 class="text-2xl font-black text-slate-900 mb-1 group-hover:text-indigo-600 transition-colors">{{ $item->ruang_terapi ?? 'Ruangan Terapi' }}</h3>
                        <p class="text-sm font-bold text-slate-400 mb-6 flex items-center gap-2">
                            <i class="fa-solid fa-user-tie text-indigo-400"></i>
                            {{ $item->guru->user->name }}
                        </p>

                        {{-- Time Highlight --}}
                        <div class="bg-indigo-950 rounded-3xl p-6 text-white flex items-center justify-between mb-8 shadow-xl shadow-indigo-900/20">
                            <div class="flex flex-col">
                                <span class="text-[9px] text-indigo-400 font-bold uppercase tracking-widest">Waktu Mulai</span>
                                <span class="text-xl font-black">{{ date('H:i', strtotime($item->jam_mulai)) }}</span>
                            </div>
                            <div class="h-8 w-[1px] bg-indigo-800"></div>
                            <div class="flex flex-col text-right">
                                <span class="text-[9px] text-indigo-400 font-bold uppercase tracking-widest">Selesai</span>
                                <span class="text-xl font-black">{{ date('H:i', strtotime($item->jam_selesai)) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('orangtua.jadwal.show', $item->id) }}" 
                            class="flex items-center justify-center gap-2 w-full py-4 bg-indigo-50 text-indigo-700 font-black text-xs uppercase tracking-widest rounded-2xl group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                            Lihat Detail Sesi <i class="fa-solid fa-arrow-right-long transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 flex flex-col items-center justify-center bg-white rounded-[3rem] border-2 border-dashed border-indigo-100">
                    <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mb-6">
                        <i class="fa-solid fa-calendar-xmark text-3xl text-indigo-200"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900">Tidak ada jadwal terapi</h3>
                    <p class="text-slate-400 font-medium">Tidak ada agenda ditemukan untuk hari {{ $hariIndo }}.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection