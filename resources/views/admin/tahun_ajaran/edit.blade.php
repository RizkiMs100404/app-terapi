@extends('admin.layouts.main')

@section('content')
<div class="bg-[#F8FAFC] min-h-screen p-6 lg:p-10">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-10">
            <div class="flex items-center gap-4">
                <a href="{{ route('tahun-ajaran.index') }}" class="group p-3 bg-white border border-slate-200 rounded-2xl hover:bg-slate-50 transition-all shadow-sm">
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Perbarui Periode</h1>
                    <p class="text-slate-500 font-medium">Ubah konfigurasi untuk rentang {{ $ta->rentang_tahun }}.</p>
                </div>
            </div>
        </div>

        {{-- Form Edit --}}
        <form action="{{ route('tahun-ajaran.update', $ta->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden">
                        {{-- Aksen Dekorasi Tipis --}}
                        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/5 rounded-full -mr-16 -mt-16"></div>

                        <div class="flex items-center gap-3 mb-8 relative z-10">
                            <div class="w-10 h-10 bg-indigo-50 dark:bg-indigo-950 rounded-xl flex items-center justify-center text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800">Ubah Detail Akademik</h3>
                        </div>

                        <div class="grid grid-cols-1 gap-6 relative z-10">
                            <div class="space-y-2 relative">
                                <label class="text-sm font-bold text-slate-700 ml-1">Rentang Tahun Ajaran</label>
                                <input type="text" name="rentang_tahun" value="{{ old('rentang_tahun', $ta->rentang_tahun) }}" required
                                    class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-100 transition-all outline-none text-lg font-bold text-slate-700 shadow-inner placeholder:text-slate-300">
                                @error('rentang_tahun') <span class="text-red-500 text-xs font-medium ml-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Pilih Semester</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="semester" value="Ganjil" class="sr-only peer" {{ old('semester', $ta->semester) == 'Ganjil' ? 'checked' : '' }}>
                                        <div class="p-5 rounded-2xl bg-slate-50 border-2 border-transparent peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 transition-all text-center font-bold text-slate-600 peer-checked:text-indigo-600 flex items-center justify-center gap-3">
                                            <span class="w-2.5 h-2.5 rounded-full {{ old('semester', $ta->semester) == 'Ganjil' ? 'bg-indigo-500' : 'bg-slate-300' }} transition-colors"></span>
                                            Ganjil
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="semester" value="Genap" class="sr-only peer" {{ old('semester', $ta->semester) == 'Genap' ? 'checked' : '' }}>
                                        <div class="p-5 rounded-2xl bg-slate-50 border-2 border-transparent peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 transition-all text-center font-bold text-slate-600 peer-checked:text-indigo-600 flex items-center justify-center gap-3">
                                            <span class="w-2.5 h-2.5 rounded-full {{ old('semester', $ta->semester) == 'Genap' ? 'bg-indigo-500' : 'bg-slate-300' }} transition-colors"></span>
                                            Genap
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card Informasi (Aksen Biru) --}}
                    <div class="bg-white p-8 rounded-[2.5rem] border-l-4 border-l-indigo-600 border border-slate-100 shadow-sm flex items-center gap-6 group hover:shadow-lg transition-shadow">
                        <div class="p-4 rounded-3xl bg-indigo-50 text-indigo-600 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-base mb-1">Catatan Pembaruan</h4>
                            <p class="text-xs text-slate-500 leading-relaxed max-w-sm">
                                Perubahan pada tahun ajaran ini akan berdampak pada pengelompokan data siswa dan jadwal terapi yang terkait dengan periode ini.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    {{-- Card Pengaturan Status (Gelap) --}}
                    <div class="bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl text-white relative overflow-hidden group">
                        {{-- Aksen Dekorasi Gelap --}}
                        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl transition-all group-hover:bg-indigo-500/20"></div>

                        <h3 class="text-lg font-bold mb-6 flex items-center gap-2 text-indigo-400 relative z-10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Opsi Status
                        </h3>

                        <div class="space-y-6 relative z-10">
                            <div class="p-6 bg-white/5 rounded-3xl border border-white/10 group/toggle transition-colors hover:bg-white/10">
                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox" name="status_aktif" value="1" id="status_aktif" class="sr-only peer" {{ $ta->status_aktif ? 'checked' : '' }}>
                                    <div class="w-12 h-7 bg-slate-700 rounded-full peer peer-checked:bg-emerald-500 after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:rounded-full after:h-[19px] after:w-[19px] after:transition-all peer-checked:after:translate-x-full relative"></div>
                                    <div class="ml-4 flex-1">
                                        <span class="block text-sm font-bold">Status Aktivasi</span>
                                        <span class="text-[10px] text-slate-400 uppercase tracking-wider group-hover/toggle:text-slate-200">Set sebagai periode utama</span>
                                    </div>
                                </label>
                            </div>

                            {{-- Info Box (Serasi sama Create) --}}
                            <div class="bg-indigo-500/10 p-5 rounded-2xl border border-indigo-500/20 text-center flex items-center gap-3 justify-center">
                                <svg class="w-4 h-4 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <p class="text-[10px] text-indigo-300 leading-relaxed font-bold italic tracking-wide">
                                    Peringatan: Mengubah status akan mempengaruhi default sistem.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Card Tombol Aksi (Putih) --}}
                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-5 rounded-[1.5rem] transition-all shadow-xl shadow-indigo-100 mb-4 active:scale-95 uppercase tracking-widest text-sm flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            PERBARUI DATA
                        </button>
                        <a href="{{ route('tahun-ajaran.index') }}" class="block text-center text-xs font-bold text-slate-400 hover:text-slate-600 transition-all tracking-widest uppercase">
                            BATALKAN
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
