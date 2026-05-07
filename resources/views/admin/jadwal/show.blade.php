@extends('admin.layouts.main')

@section('content')
<div class="min-h-screen p-6 lg:p-10">
    <div class="max-w-5xl mx-auto">

        {{-- Header & Actions --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div class="flex items-center gap-5">
                <a href="{{ route('jadwal-terapi.index') }}" class="group p-3 bg-white border border-slate-200 rounded-2xl hover:bg-indigo-600 transition-all shadow-sm">
                    <svg class="w-6 h-6 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Detail <span class="text-indigo-600">Jadwal</span></h1>
                    <p class="text-slate-500 font-medium italic">Informasi manajemen waktu terapi</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('jadwal-terapi.edit', $jadwal->id) }}" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all text-center shadow-lg shadow-indigo-200">
                    Edit Jadwal
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- Sidebar Kiri: Info Utama --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/50 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-24 bg-indigo-600"></div>

                    <div class="relative z-10">
                        <div class="inline-flex p-1 bg-white rounded-full shadow-xl mb-4">
                            <div class="w-32 h-32 bg-slate-50 rounded-full flex flex-col items-center justify-center border-4 border-white overflow-hidden">
                                <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <h2 class="text-2xl font-black text-slate-800 leading-tight uppercase">{{ $jadwal->hari }}</h2>
                        <p class="text-indigo-600 font-bold mt-1 tracking-widest text-xs uppercase">{{ $jadwal->jenis_terapi }}</p>

                        <div class="flex items-center justify-center gap-2 mt-4">
                            <span class="px-4 py-1.5 bg-indigo-50 text-indigo-700 rounded-full text-[10px] font-black uppercase tracking-widest">
                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-8 pt-8 border-t border-slate-100">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Sesi</p>
                        <p class="text-sm font-bold text-emerald-600 flex items-center justify-center gap-1">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span> Terjadwal Aktif
                        </p>
                    </div>
                </div>

                {{-- Card Tahun Ajaran --}}
                <div class="bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl text-white relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl transition-all"></div>
                    <p class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-4">Tahun Akademik</p>
                    <p class="text-xl font-black">{{ $jadwal->tahunAjaran->tahun_ajaran }}</p>
                    <p class="text-xs text-slate-400 mt-1 italic font-medium">Semester {{ $jadwal->tahunAjaran->semester }}</p>
                </div>
            </div>

            {{-- Kolom Kanan: Detail Data --}}
            <div class="lg:col-span-8 space-y-6">

                {{-- Detail Pelaksanaan --}}
                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/50">
                    <div class="flex items-center gap-3 mb-10">
                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Detail Pelaksanaan</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        {{-- Bagian Siswa --}}
                        <div class="space-y-4">
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Siswa</p>
                            <div class="flex items-start gap-4">
                                <div class="w-16 h-16 rounded-2xl overflow-hidden bg-slate-100 border-2 border-indigo-50 flex-shrink-0 mt-1">
                                    @if($jadwal->siswa->foto && Storage::disk('public')->exists('foto_siswa/' . $jadwal->siswa->foto))
                                        <img src="{{ asset('storage/foto_siswa/' . $jadwal->siswa->foto) }}" alt="Foto Siswa" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-indigo-100 text-indigo-600 font-black text-xl">
                                            {{ substr($jadwal->siswa->nama_siswa, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-lg font-bold text-slate-700 leading-tight">{{ $jadwal->siswa->nama_siswa }}</p>
                                    <p class="text-xs font-medium text-slate-400 mt-1 mb-2">NIS: {{ $jadwal->siswa->nis }}</p>
                                    
                                    {{-- Tambahan Kelas & Tingkat --}}
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        <span class="px-2.5 py-1 bg-slate-100 text-slate-600 text-[9px] font-black uppercase rounded-md tracking-wider border border-slate-200">
                                            {{ $jadwal->siswa->tingkat }}
                                        </span>
                                        <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 text-[9px] font-black uppercase rounded-md tracking-wider border border-indigo-100">
                                            Kelas {{ $jadwal->siswa->kelas }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Bagian Guru --}}
                        <div class="space-y-4">
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Guru Terapis</p>
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-2xl overflow-hidden bg-slate-100 border-2 border-slate-50 flex-shrink-0">
                                    @if($jadwal->guru->foto && Storage::disk('public')->exists('foto_guru/' . $jadwal->guru->foto))
                                        <img src="{{ asset('storage/foto_guru/' . $jadwal->guru->foto) }}" alt="Foto Guru" class="w-full h-full object-cover shadow-inner">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-600 font-black text-xl">
                                            {{ substr($jadwal->guru->user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-lg font-bold text-slate-700 leading-tight">{{ $jadwal->guru->user->name }}</p>
                                    <p class="text-xs font-medium text-slate-400 mt-1">NIP: {{ $jadwal->guru->nip }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Jenis Terapi --}}
                        <div class="space-y-1">
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Jenis Terapi</p>
                            <p class="text-lg font-bold text-indigo-600">{{ $jadwal->jenis_terapi }}</p>
                        </div>

                        {{-- Ruang Terapi --}}
                        <div class="space-y-1">
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Ruang Terapi</p>
                            <p class="text-lg font-bold text-slate-700">{{ $jadwal->ruang_terapi ?? '-' }}</p>
                        </div>

                        {{-- Keterangan --}}
                        <div class="md:col-span-2 space-y-1 pt-6 border-t border-slate-50">
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Keterangan Tambahan</p>
                            <p class="text-base text-slate-600 leading-relaxed">{{ $jadwal->keterangan ?: 'Tidak ada catatan tambahan untuk jadwal ini.' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Tautan Laporan --}}
                <div class="p-8 bg-slate-50 rounded-[2.5rem] flex items-center justify-between group hover:bg-white hover:shadow-lg transition-all border border-transparent hover:border-slate-100">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center text-slate-400 group-hover:text-indigo-600 transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-black text-slate-800">Laporan Hasil Sesi</h4>
                            <p class="text-sm text-slate-500 font-medium">Lihat riwayat perkembangan terapi siswa</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.rekam-terapi.index', ['id_jadwal' => $jadwal->id]) }}" class="p-3 bg-white rounded-xl shadow-sm group-hover:bg-indigo-600 group-hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection