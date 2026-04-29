@extends('admin.layouts.main')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="min-h-screen p-6 lg:p-10 bg-[#F8FAFC]">
    <div class="max-w-6xl mx-auto">
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-10">
            <a href="{{ route('jadwal-terapi.index') }}" class="p-3 bg-white border border-indigo-100 rounded-2xl shadow-sm hover:bg-indigo-600 hover:text-white transition-all duration-300 group">
                <svg class="w-5 h-5 text-indigo-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Atur <span class="text-indigo-600">Jadwal Terapi</span></h1>
                <p class="text-slate-600 font-semibold italic">Menghubungkan siswa dengan tenaga ahli terapis</p>
            </div>
        </div>

        <form action="{{ route('jadwal-terapi.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Sisi Kiri: Detail Jadwal --}}
                <div class="lg:col-span-2 space-y-8">
                    <div class="group bg-white p-8 rounded-[2.5rem] border border-indigo-50 shadow-xl shadow-indigo-900/5 relative overflow-hidden transition-all duration-500">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-600/5 rounded-full -mr-16 -mt-16 transition-all duration-700 group-hover:scale-[3] group-hover:bg-indigo-600/10"></div>

                        <div class="flex items-center gap-3 mb-8 relative z-10">
                            <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800">Detail Sesi Terapi</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-indigo-900 ml-1">Pilih Siswa</label>
                                <select name="id_siswa" required class="w-full bg-indigo-50/50 border-2 border-transparent rounded-2xl px-5 py-4 focus:border-indigo-500 focus:bg-white outline-none font-bold text-slate-700 appearance-none transition-all cursor-pointer">
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach($siswa as $s) <option value="{{ $s->id }}">{{ $s->nama_siswa }}</option> @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-indigo-900 ml-1">Pilih Terapis</label>
                                <select name="id_guru" required class="w-full bg-indigo-50/50 border-2 border-transparent rounded-2xl px-5 py-4 focus:border-indigo-500 focus:bg-white outline-none font-bold text-slate-700 appearance-none transition-all cursor-pointer">
                                    <option value="">-- Pilih Terapis --</option>
                                    @foreach($guru as $g)
                                        <option value="{{ $g->id }}">{{ $g->user->name ?? 'Tanpa Nama' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-indigo-900 ml-1">Jenis Terapi</label>
                                <select name="jenis_terapi" required class="w-full bg-indigo-50/50 border-2 border-transparent rounded-2xl px-5 py-4 focus:border-indigo-500 focus:bg-white outline-none font-bold text-slate-700 appearance-none transition-all cursor-pointer">
                                    @foreach(App\Models\JadwalTerapi::listJenisTerapi() as $terapi)
                                        <option value="{{ $terapi }}">{{ $terapi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-indigo-900 ml-1">Tahun Ajaran</label>
                                <select name="id_tahun_ajaran" required class="w-full bg-indigo-50/50 border-2 border-transparent rounded-2xl px-5 py-4 focus:border-indigo-500 focus:bg-white outline-none font-bold text-slate-700 appearance-none transition-all cursor-pointer">
                                    @foreach($tahunAjaran as $ta)
                                        <option value="{{ $ta->id }}" {{ $ta->status_aktif ? 'selected' : '' }}>{{ $ta->rentang_tahun }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-sm font-bold text-indigo-900 ml-1">Catatan Tambahan (Keterangan)</label>
                                <textarea name="keterangan" rows="3" class="w-full bg-indigo-50/50 border-2 border-transparent rounded-2xl px-5 py-4 focus:border-indigo-500 focus:bg-white transition-all outline-none font-medium text-slate-700" placeholder="Informasi tambahan jika diperlukan..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sisi Kanan: Waktu & Lokasi --}}
                <div class="space-y-8">
                    <div class="group bg-indigo-700 p-8 rounded-[2.5rem] shadow-2xl shadow-indigo-900/20 text-white relative overflow-hidden transition-all duration-500 hover:bg-indigo-800">
                        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full transition-all duration-700 group-hover:scale-150"></div>
                        <h3 class="text-lg font-bold mb-8 text-indigo-200 flex items-center gap-2 relative z-10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Pengaturan Waktu
                        </h3>

                        <div class="space-y-6 relative z-10">
                            <div>
                                <label class="text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] block mb-2 ml-1">Hari</label>
                                <select name="hari" class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-white focus:bg-white/20 outline-none transition-all cursor-pointer font-bold">
                                    @foreach(App\Models\JadwalTerapi::listHari() as $h)
                                        <option value="{{ $h }}" class="text-slate-800">{{ $h }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] block mb-2 ml-1">Jam Mulai</label>
                                    <input type="time" name="jam_mulai" required class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-white focus:bg-white/20 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] block mb-2 ml-1">Jam Selesai</label>
                                    <input type="time" name="jam_selesai" required class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-white focus:bg-white/20 outline-none transition-all">
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] block mb-2 ml-1">Ruang Terapi</label>
                                <input type="text" name="ruang_terapi" placeholder="Contoh: Ruang A1" class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-white placeholder-indigo-300 focus:bg-white/20 outline-none transition-all">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-[2.5rem] border border-indigo-50 shadow-xl shadow-indigo-900/5">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-5 rounded-2xl shadow-xl shadow-indigo-200 transition-all active:scale-95 uppercase tracking-widest text-xs">
                            SIMPAN JADWAL
                        </button>
                        <a href="{{ route('jadwal-terapi.index') }}" class="block text-center mt-4 text-[10px] font-bold text-slate-400 hover:text-rose-500 tracking-widest uppercase transition-colors">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
