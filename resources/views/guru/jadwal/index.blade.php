@extends('guru.layouts.main')

@section('content')
<div class="min-h-screen p-4 lg:p-10">
    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-12">
            <div>
                <h1 class="text-4xl font-black text-emerald-900 tracking-tight">Jadwal Terapi</h1>
                <p class="text-slate-700/70 mt-2 font-medium">Berikut adalah agenda terapi siswa Anda minggu ini.</p>
            </div>

            <form action="{{ route('guru.jadwal.index') }}" method="GET" class="bg-white p-2 rounded-[2.5rem] shadow-xl shadow-emerald-900/5 border border-emerald-100 flex flex-col md:flex-row gap-2">
                <div class="relative flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..."
                        class="w-full md:w-64 border-none bg-transparent py-3 pl-12 pr-4 focus:ring-0 text-sm font-semibold text-emerald-900">
                    <svg class="w-5 h-5 absolute left-4 top-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <div class="h-8 w-[1px] bg-emerald-100 hidden md:block mt-2"></div>

                {{-- Menggunakan $tanggalAktif dari controller agar input terisi otomatis --}}
                <input type="date" name="tanggal" value="{{ $tanggalAktif }}"
                    class="border-none bg-transparent py-3 px-6 focus:ring-0 text-sm font-bold text-emerald-700">

                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-full font-black text-sm transition-all active:scale-95 shadow-lg shadow-emerald-200">
                    Terapkan
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @forelse ($jadwal as $item)
                @php
                    // Ambil tanggal target dari controller ($tanggalAktif)
                    $tanggalTarget = $tanggalAktif;

                    // Cek apakah tanggal yang dilihat adalah hari ini secara real-time
                    $isRealtimeToday = ($tanggalTarget == date('Y-m-d'));

                    // Cek rekam terapi spesifik pada tanggal target
                    $laporanSelesai = $item->rekamTerapi->where('tanggal_pelaksanaan', $tanggalTarget)->first();
                @endphp

                <div class="group bg-white rounded-[2.5rem] p-8 shadow-sm border {{ $item->hari == $hariIni ? 'border-emerald-500 ring-2 ring-emerald-500/10' : 'border-emerald-50' }} hover:shadow-2xl hover:shadow-emerald-200/50 transition-all duration-500 relative overflow-hidden">

                    {{-- Badge Status --}}
                    @if($laporanSelesai)
                        <div class="absolute -right-12 top-6 bg-amber-500 text-white text-[10px] font-black py-1 w-40 text-center rotate-45 shadow-lg">
                            SELESAI
                        </div>
                    @elseif($isRealtimeToday && $item->hari == $hariIni)
                        <div class="absolute -right-12 top-6 bg-emerald-500 text-white text-[10px] font-black py-1 w-40 text-center rotate-45 shadow-lg">
                            HARI INI
                        </div>
                    @endif

                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-700"></div>

                    <div class="relative">
                        <div class="flex justify-between items-start mb-8">
                            <span class="bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-[0.2em] px-4 py-2 rounded-full">
                                {{ $item->jenis_terapi }}
                            </span>
                            <div class="text-right {{ ($item->hari == $hariIni || $laporanSelesai) ? 'mr-8' : '' }}">
                                <p class="text-[10px] font-bold text-gray-300 uppercase italic">Ruangan</p>
                                <p class="text-sm font-black text-emerald-800">{{ $item->ruang_terapi ?? '-' }}</p>
                            </div>
                        </div>

                        <p class="text-emerald-600 font-bold text-xs uppercase tracking-tighter">{{ $item->hari }}</p>

                        <h3 class="text-2xl font-black text-emerald-950 mb-2 group-hover:text-emerald-600 transition-colors capitalize">
                            {{ $item->siswa->nama_siswa ?? 'Siswa Tidak Ditemukan' }}
                        </h3>

                        <div class="flex items-center gap-2 mb-8">
                            {{-- Dot indikator aktif jika hari ini --}}
                            <div class="w-2 h-2 {{ ($isRealtimeToday && $item->hari == $hariIni) ? 'bg-emerald-400 animate-pulse' : 'bg-slate-300' }} rounded-full"></div>
                            <p class="text-xs font-bold {{ ($isRealtimeToday && $item->hari == $hariIni) ? 'text-emerald-600' : 'text-slate-400' }}">
                                {{ $laporanSelesai ? 'Laporan Telah Terisi' : (($isRealtimeToday && $item->hari == $hariIni) ? 'Sesi Terapi Aktif' : 'Terjadwal') }}
                            </p>
                        </div>

                        <div class="bg-emerald-950 rounded-3xl p-6 text-white flex items-center justify-between mb-6 shadow-xl shadow-emerald-900/20">
                            <div class="flex flex-col">
                                <span class="text-[9px] text-emerald-400 font-bold uppercase tracking-widest">Jam Mulai</span>
                                <span class="text-lg font-black tracking-tighter">{{ date('H:i', strtotime($item->jam_mulai)) }}</span>
                            </div>
                            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            <div class="flex flex-col text-right">
                                <span class="text-[9px] text-emerald-400 font-bold uppercase tracking-widest">Selesai</span>
                                <span class="text-lg font-black tracking-tighter">{{ date('H:i', strtotime($item->jam_selesai)) }}</span>
                            </div>
                        </div>

                        {{-- Logic Tombol Dinamis --}}
                        @if($laporanSelesai)
                            <a href="{{ route('guru.rekam-terapi.edit', $laporanSelesai->id) }}"
                               class="flex items-center justify-center gap-2 w-full py-4 bg-amber-500 text-white font-black text-xs uppercase tracking-widest rounded-2xl hover:bg-amber-600 transition-all duration-300 border border-amber-400 shadow-lg shadow-amber-100">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Edit Hasil Terapi
                            </a>
                        @else
                            {{-- Link Create membawa tanggal yang sedang aktif --}}
                            <a href="{{ route('guru.rekam-terapi.create', ['id_jadwal' => $item->id, 'tanggal' => $tanggalTarget]) }}"
                               class="flex items-center justify-center gap-2 w-full py-4 {{ ($isRealtimeToday && $item->hari == $hariIni) ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'bg-emerald-50 text-emerald-700' }} font-black text-xs uppercase tracking-widest rounded-2xl group-hover:bg-emerald-800 group-hover:text-white transition-all duration-300 border border-emerald-100">
                                <i class="fa-solid fa-plus"></i>
                                Input Terapi
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-32 bg-white rounded-[3rem] border-4 border-dashed border-emerald-100">
                    <div class="w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-12 h-12 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-2xl font-black text-emerald-900">Jadwal Kosong</h3>
                    <p class="text-emerald-600/60 font-medium mt-2">Tidak ada agenda ditemukan.</p>
                    <a href="{{ route('guru.jadwal.index') }}" class="mt-8 text-emerald-600 font-bold underline decoration-2 underline-offset-4">Reset Filter</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
