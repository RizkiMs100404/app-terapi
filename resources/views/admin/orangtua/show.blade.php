@extends('admin.layouts.main')

@section('content')
<div class="bg-[#F8FAFC] min-h-screen p-6 lg:p-10">
    <div class="max-w-6xl mx-auto">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div class="flex items-center gap-5">
                <a href="{{ route('orangtua.index') }}" class="group p-3 bg-white border border-slate-200 rounded-2xl hover:bg-indigo-600 hover:border-indigo-600 transition-all duration-300 shadow-sm">
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Detail Profil Wali</h1>
                    <p class="text-slate-600 font-semibold italic text-sm">Informasi lengkap akses portal keluarga & siswa.</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('orangtua.edit', $orangtua->id) }}" class="flex-1 md:flex-none px-6 py-3 bg-white border-2 border-indigo-50 text-indigo-600 rounded-2xl font-bold text-xs tracking-widest hover:bg-indigo-50 transition-all shadow-sm flex items-center justify-center gap-2 uppercase">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Profil
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
                        {{-- Avatar --}}
                        <div class="relative">
                            <div class="w-32 h-32 bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-[2.5rem] flex items-center justify-center text-white text-5xl font-black shadow-2xl shadow-indigo-200">
                                {{ substr($orangtua->user->name, 0, 1) }}
                            </div>
                            <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-emerald-500 border-4 border-white rounded-full flex items-center justify-center text-white shadow-lg">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            </div>
                        </div>

                        {{-- Identity --}}
                        <div class="text-center md:text-left flex-1">
                            <div class="flex flex-wrap justify-center md:justify-start gap-2 mb-4">
                                <span class="px-4 py-1.5 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg shadow-indigo-100">
                                    Wali Murid
                                </span>
                                <span class="px-4 py-1.5 bg-slate-100 text-slate-500 text-[10px] font-black uppercase tracking-widest rounded-full">
                                    TA {{ $orangtua->tahunAjaran->rentang_tahun }}
                                </span>
                            </div>
                            <h2 class="text-4xl font-black text-slate-900 tracking-tight leading-tight mb-2 uppercase">{{ $orangtua->user->name }}</h2>
                            <div class="flex items-center justify-center md:justify-start gap-4 text-slate-500 font-bold text-sm italic">
                                <span class="flex items-center gap-1.5 text-emerald-600">
                                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                                    Status Akun Aktif
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Details Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-12 pt-10 border-t border-slate-50 relative z-10">
                        <div class="group/item">
                            <p class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-3 ml-1">Identitas Ibu Kandung</p>
                            <div class="flex items-center gap-4 bg-slate-50 p-5 rounded-3xl border border-transparent group-hover/item:border-indigo-100 group-hover/item:bg-white transition-all duration-300 shadow-sm group-hover/item:shadow-indigo-100/50">
                                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-pink-500 shadow-sm border border-pink-50 group-hover/item:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div>
                                    <span class="block font-black text-slate-800 text-lg leading-tight uppercase">{{ $orangtua->nama_ibu }}</span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Wali Siswa</span>
                                </div>
                            </div>
                        </div>

                        <div class="group/item">
                            <p class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-3 ml-1">Saluran Komunikasi</p>
                            <div class="flex items-center gap-4 bg-slate-50 p-5 rounded-3xl border border-transparent group-hover/item:border-emerald-100 group-hover/item:bg-white transition-all duration-300 shadow-sm group-hover/item:shadow-emerald-100/50">
                                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-emerald-500 shadow-sm border border-emerald-50 group-hover/item:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <div>
                                    <span class="block font-black text-slate-800 text-lg leading-tight">{{ $orangtua->nomor_hp_aktif }}</span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter italic">WhatsApp Terhubung</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Children Section --}}
                <div class="space-y-6">
                    <div class="flex items-center justify-between px-2">
                        <h3 class="text-xl font-black text-slate-800 flex items-center gap-3">
                            <div class="p-2 bg-indigo-600 rounded-lg text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            Relasi Siswa Terhubung
                        </h3>
                        <span class="text-[10px] font-black text-slate-400 bg-slate-100 px-3 py-1 rounded-full">{{ count($orangtua->anak) }} SISWA</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($orangtua->anak as $anak)
                        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm flex items-center gap-5 group hover:border-indigo-200 hover:shadow-lg hover:shadow-indigo-900/5 transition-all duration-300">
                            <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center font-black text-xl border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white group-hover:rotate-6 transition-all duration-300">
                                {{ substr($anak->nama_siswa, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-black text-slate-800 group-hover:text-indigo-600 transition-colors uppercase leading-tight">{{ $anak->nama_siswa }}</h4>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Nis</span>
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[9px] font-black rounded-md">{{ $anak->nis ?? '?' }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full bg-slate-50 border-2 border-dashed border-slate-200 p-12 rounded-[3rem] text-center">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <p class="text-slate-400 font-bold italic">Ops! Belum ada data anak yang terhubung ke akun ini.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Sidebar Info --}}
            <div class="space-y-8">
                {{-- Account Credentials Card --}}
                <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl relative overflow-hidden group">
                    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl transition-transform duration-700 group-hover:scale-150"></div>

                    <div class="flex items-center gap-3 mb-8 relative z-10">
                        <div class="p-2 bg-indigo-500/20 rounded-lg">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        </div>
                        <h3 class="text-indigo-200 font-black text-xs uppercase tracking-[0.2em]">Akun Login</h3>
                    </div>

                    <div class="space-y-6 relative z-10">
                        <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                            <p class="text-slate-500 text-[10px] font-black uppercase mb-1 tracking-widest">Username Akses</p>
                            <p class="text-lg font-bold tracking-tight text-indigo-100">{{ $orangtua->user->username }}</p>
                        </div>
                        <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                            <p class="text-slate-500 text-[10px] font-black uppercase mb-1 tracking-widest">Email Terdaftar</p>
                            <p class="text-lg font-bold tracking-tight text-indigo-100 break-all">{{ $orangtua->user->email }}</p>
                        </div>
                        <div class="flex items-center justify-between px-2">
                            <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest">Tipe Akun</p>
                            <p class="px-3 py-1 bg-indigo-500 text-white rounded-lg text-[10px] font-black uppercase tracking-tighter shadow-lg shadow-indigo-900/50">
                                {{ $orangtua->user->role }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Additional Info Card --}}
                <div class="bg-white rounded-[2.5rem] p-8 border border-indigo-50 shadow-xl shadow-indigo-900/5 group">
                    <h3 class="text-slate-400 font-black text-[10px] uppercase tracking-[0.2em] mb-6 italic flex items-center gap-2">
                        <span class="w-4 h-[2px] bg-slate-200"></span>
                        Info Tambahan
                    </h3>
                    <div class="flex items-start gap-4">
                        <div class="p-4 bg-amber-50 text-amber-600 rounded-[1.5rem] border border-amber-100 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Pekerjaan Wali</p>
                            <p class="text-xl font-black text-slate-700 leading-tight mt-2 uppercase">{{ $orangtua->pekerjaan ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Security Info --}}
                <div class="p-6 bg-emerald-50 rounded-[2.5rem] border border-emerald-100 flex items-center gap-4">
                    <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <p class="text-[9px] font-bold text-emerald-800 leading-relaxed uppercase tracking-wider italic">
                        Data ini terlindungi oleh enkripsi sistem manajemen sekolah.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
