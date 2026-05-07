@extends('admin.layouts.main')

@section('content')
<div class="bg-[#F8FAFC] min-h-screen p-6 lg:p-10">
    <div class="max-w-6xl mx-auto">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div class="flex items-center gap-5">
                <a href="{{ route('guru-terapis.index') }}" class="group p-3 bg-white border border-slate-200 rounded-2xl hover:bg-indigo-600 hover:border-indigo-600 transition-all duration-300 shadow-sm">
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Detail <span class="text-indigo-600">Guru Terapis</span></h1>
                    <p class="text-slate-600 font-semibold italic text-sm">Informasi profesional & kompetensi tenaga ahli.</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('guru-terapis.edit', $guru->id) }}" class="flex-1 md:flex-none px-6 py-3 bg-white border-2 border-indigo-50 text-indigo-600 rounded-2xl font-bold text-xs tracking-widest hover:bg-indigo-50 transition-all shadow-sm flex items-center justify-center gap-2 uppercase">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Data
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Info --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Profile Card --}}
                <div class="bg-white rounded-[3rem] p-8 md:p-12 border border-indigo-50 shadow-xl shadow-indigo-900/5 relative overflow-hidden group">
                    {{-- Decorative Background --}}
                    <div class="absolute top-0 right-0 w-80 h-80 bg-indigo-600/5 rounded-full -mr-40 -mt-40 transition-transform duration-700 group-hover:scale-110"></div>

                    <div class="flex flex-col md:flex-row items-center md:items-start gap-8 relative z-10">
                        {{-- Avatar Logic --}}
                        <div class="relative">
                            @if($guru->foto)
                                <img src="{{ asset('storage/foto_guru/' . $guru->foto) }}" 
                                     alt="{{ $guru->user->name }}" 
                                     class="w-32 h-32 rounded-[2.5rem] object-cover shadow-2xl shadow-indigo-100 border-4 border-white transition-transform group-hover:rotate-3">
                            @else
                                <div class="w-32 h-32 bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-[2.5rem] flex items-center justify-center text-white text-5xl font-black shadow-2xl shadow-indigo-200 uppercase transition-transform group-hover:rotate-3">
                                    {{ substr($guru->user->name, 0, 1) }}
                                </div>
                            @endif
                            
                            @if($guru->status_kerja == 'Aktif')
                            <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-indigo-500 border-4 border-white rounded-full flex items-center justify-center text-white shadow-lg animate-bounce" title="Status Aktif">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            </div>
                            @endif
                        </div>

                        {{-- Identity --}}
                        <div class="text-center md:text-left flex-1">
                            <div class="flex flex-wrap justify-center md:justify-start gap-2 mb-4">
                                <span class="px-4 py-1.5 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg shadow-indigo-100">
                                    Tenaga Ahli Terapis
                                </span>
                                <span class="px-4 py-1.5 bg-slate-100 text-slate-500 text-[10px] font-black uppercase tracking-widest rounded-full">
                                    NIP: {{ $guru->nip }}
                                </span>
                            </div>
                            <h2 class="text-4xl font-black text-slate-900 tracking-tight leading-tight mb-2 uppercase">{{ $guru->user->name }}</h2>
                            <div class="flex items-center justify-center md:justify-start gap-4 text-slate-500 font-bold text-sm italic">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path></svg>
                                    TA {{ $guru->tahunAjaran->rentang_tahun }}
                                </span>
                                <span class="text-slate-300">|</span>
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Skills / Keahlian Section --}}
                    <div class="mt-12 pt-10 border-t border-slate-50 relative z-10">
                        <p class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.2em] mb-5 ml-1">Spesialisasi & Keahlian Terapi</p>
                        <div class="flex flex-wrap gap-3">
                            @php
                                $skills = is_array($guru->keahlian_terapi) ? $guru->keahlian_terapi : json_decode($guru->keahlian_terapi, true) ?? [];
                            @endphp
                            @forelse($skills as $skill)
                                <div class="px-5 py-3 bg-indigo-50 border border-indigo-100 rounded-2xl flex items-center gap-3 group/skill hover:bg-indigo-600 transition-all duration-300 cursor-default shadow-sm">
                                    <div class="w-2 h-2 bg-indigo-400 rounded-full group-hover/skill:bg-white animate-pulse"></div>
                                    <span class="text-xs font-black text-indigo-700 group-hover/skill:text-white uppercase tracking-wider">{{ $skill }}</span>
                                </div>
                            @empty
                                <p class="text-slate-400 italic text-sm">Belum ada keahlian yang dicantumkan.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Bio Data Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm group hover:shadow-xl transition-all">
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Kontak Personal</p>
                        <h4 class="text-xl font-black text-slate-800">{{ $guru->nomor_hp }}</h4>
                        <p class="text-xs text-indigo-500 font-bold mt-2 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-ping"></span> WhatsApp Aktif
                        </p>
                    </div>

                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm group hover:shadow-xl transition-all">
                        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Kepegawaian</p>
                        <h4 class="text-xl font-black text-slate-800">{{ $guru->status_kerja }}</h4>
                        <p class="text-xs text-slate-400 font-bold mt-2 italic uppercase tracking-tighter">Terdaftar di Sistem Akademik</p>
                    </div>
                </div>
            </div>

            {{-- Sidebar Info --}}
            <div class="space-y-8">
                {{-- Account Credentials Card --}}
                <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl relative overflow-hidden group">
                    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl transition-transform duration-700 group-hover:scale-150"></div>

                    <div class="flex items-center gap-3 mb-8 relative z-10">
                        <div class="p-2 bg-indigo-500/20 rounded-lg text-indigo-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        </div>
                        <h3 class="text-indigo-200 font-black text-xs uppercase tracking-[0.2em]">Akun Akses</h3>
                    </div>

                    <div class="space-y-6 relative z-10">
                        <div class="bg-white/5 p-4 rounded-2xl border border-white/5 group-hover:border-indigo-500/30 transition-colors">
                            <p class="text-slate-500 text-[10px] font-black uppercase mb-1 tracking-widest">Username Login</p>
                            <p class="text-lg font-bold tracking-tight text-indigo-50">{{ $guru->user->username }}</p>
                        </div>
                        <div class="bg-white/5 p-4 rounded-2xl border border-white/5 group-hover:border-indigo-500/30 transition-colors">
                            <p class="text-slate-500 text-[10px] font-black uppercase mb-1 tracking-widest">Email Terdaftar</p>
                            <p class="text-lg font-bold tracking-tight text-indigo-50 break-all">{{ $guru->user->email }}</p>
                        </div>
                        <div class="flex items-center justify-between px-2 pt-2 border-t border-white/10">
                            <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest">Role User</p>
                            <p class="px-3 py-1 bg-indigo-600 text-white rounded-lg text-[10px] font-black uppercase tracking-tighter shadow-lg shadow-indigo-900/50">
                                {{ $guru->user->role }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Info Security --}}
                <div class="p-8 bg-white rounded-[2.5rem] border border-indigo-50 shadow-xl shadow-indigo-900/5 relative overflow-hidden group">
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg rotate-3 group-hover:rotate-0 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-800 uppercase tracking-widest">Data Terverifikasi</p>
                            <p class="text-[9px] font-bold text-slate-400 leading-relaxed uppercase mt-1">Standar Operasional Akademik SLBN Bagian B Garut.</p>
                        </div>
                    </div>
                </div>

                {{-- Action Log/Timestamp --}}
                <div class="px-8 py-6 bg-slate-50 rounded-[2rem] border border-slate-100">
                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-[10px] font-bold uppercase tracking-tighter">
                            <span class="text-slate-400 italic">Dibuat Pada</span>
                            <span class="text-slate-600 font-black">{{ $guru->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-[10px] font-bold uppercase tracking-tighter">
                            <span class="text-slate-400 italic">Update Terakhir</span>
                            <span class="text-indigo-600 font-black">{{ $guru->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection