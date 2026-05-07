@extends('guru.layouts.main')

@section('content')
<div class="min-h-screen p-6 lg:p-10">
    <div class="max-w-5xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div class="flex items-center gap-5">
                <a href="{{ route('guru.jadwal.index') }}" class="group p-3 bg-white border border-slate-200 rounded-2xl hover:bg-emerald-600 transition-all shadow-sm">
                    <svg class="w-6 h-6 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Detail <span class="text-emerald-600">Jadwal Saya</span></h1>
                    <p class="text-slate-500 font-medium italic">Informasi sesi terapi yang akan dilaksanakan</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- Sidebar Kiri: Info Utama --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/50 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-24 bg-emerald-600"></div>

                    <div class="relative z-10">
                        <div class="inline-flex p-1 bg-white rounded-full shadow-xl mb-4">
                            <div class="w-32 h-32 bg-slate-50 rounded-full flex flex-col items-center justify-center border-4 border-white overflow-hidden">
                                <svg class="w-12 h-12 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <h2 class="text-2xl font-black text-slate-800 leading-tight uppercase">{{ $jadwal->hari }}</h2>
                        <p class="text-emerald-600 font-bold mt-1 tracking-widest text-xs uppercase">{{ $jadwal->jenis_terapi }}</p>

                        <div class="flex items-center justify-center gap-2 mt-4">
                            <span class="px-4 py-1.5 bg-emerald-50 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-100">
                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-8 pt-8 border-t border-slate-100">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Sesi</p>
                        <p class="text-sm font-bold text-emerald-600 flex items-center justify-center gap-1">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span> Sesi Aktif
                        </p>
                    </div>
                </div>

                {{-- Card Tahun Ajaran --}}
                <div class="bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl text-white relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl transition-all"></div>
                    <p class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] mb-4">Tahun Akademik</p>
                    <p class="text-xl font-black">{{ $jadwal->tahunAjaran->tahun_ajaran }}</p>
                    <p class="text-xs text-slate-400 mt-1 italic font-medium">Semester {{ $jadwal->tahunAjaran->semester }}</p>
                </div>
            </div>

            {{-- Kolom Kanan: Detail Data --}}
            <div class="lg:col-span-8 space-y-6">

                {{-- Detail Pelaksanaan --}}
                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/50">
                    <div class="flex items-center gap-3 mb-10">
                        <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Informasi Siswa & Ruangan</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        {{-- Bagian Siswa --}}
                        <div class="space-y-4">
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Siswa</p>
                            <div class="flex items-center gap-4">
                                <div class="w-20 h-20 rounded-2xl overflow-hidden bg-slate-100 border-2 border-emerald-50 flex-shrink-0">
                                   @if($jadwal->siswa->foto && Storage::disk('public')->exists('foto_siswa/' . $jadwal->siswa->foto))
                                        <img src="{{ asset('storage/foto_siswa/' . $jadwal->siswa->foto) }}" alt="Foto" class="w-full h-full object-cover shadow-inner">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-emerald-100 text-emerald-600 font-black text-2xl">
                                            {{ substr($jadwal->siswa->nama_siswa, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-lg font-black text-slate-700 leading-tight mb-2">{{ $jadwal->siswa->nama_siswa }}</p>
                                    <div class="flex flex-wrap gap-2">
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded text-[9px] font-black border border-slate-200">
                                            {{ $jadwal->siswa->tingkat }}
                                        </span>
                                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded text-[9px] font-black border border-emerald-100">
                                            KELAS {{ $jadwal->siswa->kelas }}
                                        </span>
                                    </div>
                                    <p class="text-[10px] font-bold text-slate-300 mt-2 tracking-widest uppercase">NIS: {{ $jadwal->siswa->nis }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Ruang Terapi --}}
                        <div class="space-y-4">
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Lokasi / Ruangan</p>
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-emerald-600 border border-slate-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-7h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <p class="text-lg font-black text-slate-700">{{ $jadwal->ruang_terapi ?? 'Ruang Terapi Umum' }}</p>
                            </div>
                        </div>

                        {{-- Keterangan --}}
                        <div class="md:col-span-2 space-y-3 pt-6 border-t border-slate-50">
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Catatan Tambahan</p>
                            <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                                <p class="text-sm text-slate-600 leading-relaxed italic">
                                    "{{ $jadwal->keterangan ?: 'Tidak ada catatan khusus untuk sesi ini.' }}"
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection