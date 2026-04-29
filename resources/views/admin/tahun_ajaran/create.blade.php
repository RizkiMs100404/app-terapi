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
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Tambah Periode</h1>
                    <p class="text-slate-500 font-medium">Konfigurasi tahun akademik dan semester aktif sistem.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('tahun-ajaran.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800">Detail Akademik</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Rentang Tahun Ajaran</label>
                                <input type="text" name="rentang_tahun" value="{{ old('rentang_tahun') }}" placeholder="Contoh: 2026/2027" required
                                    class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-100 transition-all outline-none text-lg font-bold text-slate-700">
                                @error('rentang_tahun') <span class="text-red-500 text-xs font-medium ml-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-2 md:col-span-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Pilih Semester</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="semester" value="Ganjil" class="sr-only peer" checked>
                                        <div class="p-4 rounded-2xl bg-slate-50 border-2 border-transparent peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 transition-all text-center font-bold text-slate-600 peer-checked:text-indigo-600">
                                            Ganjil
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="semester" value="Genap" class="sr-only peer">
                                        <div class="p-4 rounded-2xl bg-slate-50 border-2 border-transparent peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 transition-all text-center font-bold text-slate-600 peer-checked:text-indigo-600">
                                            Genap
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-indigo-600 p-8 rounded-[2.5rem] shadow-xl shadow-indigo-200 relative overflow-hidden group">
                        <div class="relative z-10">
                            <h3 class="text-white font-bold text-lg mb-2">Informasi Sistem</h3>
                            <p class="text-indigo-100 text-sm leading-relaxed max-w-md">
                                Menambahkan tahun ajaran baru akan memudahkan Anda dalam mengelompokkan data siswa dan jadwal terapi berdasarkan periode tertentu.
                            </p>
                        </div>
                        {{-- Dekorasi --}}
                        <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-all"></div>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl text-white">
                        <h3 class="text-lg font-bold mb-6 flex items-center gap-2 text-indigo-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Opsi Status
                        </h3>

                        <div class="space-y-6">
                            <div class="p-6 bg-white/5 rounded-3xl border border-white/10">
                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox" name="status_aktif" value="1" class="sr-only peer">
                                    <div class="w-12 h-7 bg-slate-700 rounded-full peer peer-checked:bg-emerald-500 after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:rounded-full after:h-[19px] after:w-[19px] after:transition-all peer-checked:after:translate-x-full relative"></div>
                                    <div class="ml-4">
                                        <span class="block text-sm font-bold">Aktifkan Sekarang</span>
                                        <span class="text-[10px] text-slate-400 uppercase tracking-wider">Set sebagai periode utama</span>
                                    </div>
                                </label>
                            </div>

                            <div class="bg-indigo-500/10 p-4 rounded-2xl border border-indigo-500/20">
                                <p class="text-[10px] text-indigo-300 leading-relaxed italic">
                                    *Catatan: Mengaktifkan periode ini akan menonaktifkan periode lain yang sedang berjalan secara otomatis.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-5 rounded-[1.5rem] transition-all shadow-xl shadow-indigo-100 mb-4 active:scale-95 uppercase tracking-widest text-sm">
                            Simpan Periode
                        </button>
                        <a href="{{ route('tahun-ajaran.index') }}" class="block text-center text-xs font-bold text-slate-400 hover:text-slate-600 transition-all">
                            BATALKAN
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
