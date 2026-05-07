@extends('orangtua.layouts.main')

@section('content')
<div class="min-h-screen p-4 lg:p-10">
    <div class="max-w-6xl mx-auto">
        
        {{-- Breadcrumb Navigation --}}
        <nav class="flex items-center gap-2 mb-8 group">
            <a href="{{ route('orangtua.jadwal') }}" class="flex items-center justify-center w-10 h-10 bg-white rounded-xl shadow-sm border border-slate-200 text-slate-500 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="ml-2">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kembali</p>
                <p class="text-sm font-bold text-slate-700">Daftar Jadwal Terapi</p>
            </div>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            {{-- KOLOM KIRI: MAIN CARD (7 Bagian) --}}
            <div class="lg:col-span-7 space-y-6">
                <div class="bg-white rounded-[3rem] shadow-2xl shadow-indigo-900/5 border border-indigo-50/50 overflow-hidden">
                    {{-- Header Visual --}}
                    <div class="bg-indigo-600 p-10 text-white relative overflow-hidden">
                        <div class="absolute -top-10 -right-10 opacity-10">
                            <i class="fa-solid fa-notes-medical text-[12rem] -rotate-12"></i>
                        </div>
                        
                        <div class="relative z-10">
                            <div class="flex gap-2 mb-6">
                                <span class="px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-[9px] font-black uppercase tracking-widest text-white border border-white/20">
                                    {{ $jadwal->nomor_sesi }}
                                </span>
                                <span class="px-4 py-1.5 bg-indigo-400/40 backdrop-blur-md rounded-full text-[9px] font-black uppercase tracking-widest text-white border border-white/10">
                                    {{ $jadwal->jenis_terapi }}
                                </span>
                            </div>
                            <h1 class="text-3xl lg:text-4xl font-black tracking-tight leading-tight">Detail Pelaksanaan<br>Sesi Terapi</h1>
                        </div>
                    </div>

                    {{-- Data Detail --}}
                    <div class="p-10 space-y-10">
                        {{-- Row 1: Ruangan & Hari --}}
                        <div class="grid grid-cols-2 gap-6">
                            <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100 group hover:border-indigo-200 transition-all">
                                <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-indigo-600 mb-4 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-door-open"></i>
                                </div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter mb-1">Lokasi Ruangan</p>
                                <p class="text-base font-black text-slate-900">{{ $jadwal->ruang_terapi ?? 'Ruang Utama' }}</p>
                            </div>
                            <div class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100 group hover:border-indigo-200 transition-all">
                                <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-indigo-600 mb-4 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-calendar-check"></i>
                                </div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter mb-1">Hari Rutin</p>
                                <p class="text-base font-black text-slate-900">{{ $jadwal->hari }}</p>
                            </div>
                        </div>

                        {{-- Row 2: Waktu --}}
                        <div class="relative p-8 bg-indigo-50/50 rounded-[2.5rem] border border-indigo-100/50">
                            <div class="flex items-center gap-6">
                                <div class="hidden md:flex w-16 h-16 bg-white rounded-2xl shadow-sm items-center justify-center text-indigo-600">
                                    <i class="fa-solid fa-clock-rotate-left text-2xl"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-2">Jadwal Waktu Terapi</p>
                                    <div class="flex items-baseline gap-3">
                                        <span class="text-4xl font-black text-indigo-900 tracking-tighter">
                                            {{ date('H:i', strtotime($jadwal->jam_mulai)) }}
                                        </span>
                                        <span class="text-indigo-300 font-bold">—</span>
                                        <span class="text-4xl font-black text-indigo-900 tracking-tighter">
                                            {{ date('H:i', strtotime($jadwal->jam_selesai)) }}
                                        </span>
                                        <span class="ml-2 text-xs font-bold text-indigo-400">WIB</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-6 bg-amber-50/50 border border-amber-100 rounded-3xl italic text-amber-700 text-xs leading-relaxed">
                            <i class="fa-solid fa-quote-left mt-1 opacity-40"></i>
                            "Penting bagi Ibu/Bapak untuk hadir 10 menit sebelum sesi dimulai guna mempersiapkan kematangan emosional anak."
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: SIDEBAR INFO (5 Bagian) --}}
            <div class="lg:col-span-5 space-y-6">
                
                {{-- Terapis Card --}}
                <div class="bg-white p-8 rounded-[3rem] shadow-xl shadow-indigo-900/5 border border-indigo-50 flex items-center gap-5 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-50 rounded-bl-[5rem] -mr-10 -mt-10 transition-all group-hover:scale-110"></div>
                    
                    <div class="relative z-10 w-20 h-20 rounded-full border-4 border-white shadow-md overflow-hidden bg-slate-100 flex items-center justify-center">
                        <i class="fa-solid fa-user-tie text-3xl text-slate-300"></i>
                    </div>
                    
                    <div class="relative z-10 flex-1">
                        <p class="text-[9px] font-black text-indigo-400 uppercase tracking-widest mb-1">Terapis Pengampu</p>
                        <h4 class="text-lg font-black text-slate-900 leading-tight">{{ $jadwal->guru->user->name }}</h4>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter tracking-widest">Sertifikasi Aktif</span>
                        </div>
                    </div>
                </div>

                {{-- Status Card --}}
                <div class="bg-white p-8 rounded-[3rem] shadow-xl shadow-indigo-900/5 border border-indigo-50">
                    <h5 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6 px-2">Status Laporan</h5>
                    
                    @if($jadwal->rekamTerapi->first())
                        <div class="bg-emerald-50/70 border border-emerald-100 p-6 rounded-[2.5rem] relative overflow-hidden">
                            <div class="relative z-10">
                                <div class="flex items-center gap-3 text-emerald-700 mb-3">
                                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shadow-sm">
                                        <i class="fa-solid fa-check-double text-xs"></i>
                                    </div>
                                    <span class="font-black text-xs uppercase tracking-tight">Data Tersedia</span>
                                </div>
                                <p class="text-[11px] text-emerald-600 font-medium leading-relaxed mb-4">
                                    Laporan perkembangan untuk sesi ini sudah selesai disusun oleh terapis.
                                </p>
                                <a href="{{ route('orangtua.jadwal.history') }}" class="inline-block w-full text-center py-3 bg-white border border-emerald-200 text-emerald-700 text-[10px] font-black uppercase rounded-2xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm">Lihat Hasil Terapi</a>
                            </div>
                        </div>
                    @else
                        <div class="bg-amber-50/70 border border-amber-100 p-6 rounded-[2.5rem]">
                            <div class="flex items-center gap-3 text-amber-700 mb-3">
                                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shadow-sm">
                                    <i class="fa-solid fa-hourglass-half text-xs animate-spin-slow"></i>
                                </div>
                                <span class="font-black text-xs uppercase tracking-tight">Menunggu Laporan</span>
                            </div>
                            <p class="text-[11px] text-amber-600 font-medium leading-relaxed">
                                Laporan akan diupdate oleh sistem segera setelah terapis mengisi hasil observasi hari ini.
                            </p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 3s linear infinite;
    }
</style>
@endsection