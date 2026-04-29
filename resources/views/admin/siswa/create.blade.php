@extends('admin.layouts.main')

@section('content')
<div class=" min-h-screen p-6 lg:p-10">
    <div class="max-w-6xl mx-auto">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-10">
            <div class="flex items-center gap-4">
                <a href="{{ route('siswa.index') }}" class="group p-3 bg-white border border-slate-200 rounded-2xl hover:bg-indigo-600 transition-all shadow-sm">
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Registrasi <span class="text-indigo-600">Siswa</span></h1>
                    <p class="text-slate-500 font-medium italic">Pendaftaran murid baru sistem pelayanan terapi.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('siswa.store') }}" method="POST" id="formSiswa">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Form Kiri (Data Utama) --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Profil Identitas --}}
                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/50">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Profil Identitas</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] ml-1">NIS (Nomor Induk Siswa)</label>
                                <input type="text" name="nis" value="{{ old('nis') }}" placeholder="Contoh: 2026001" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-indigo-500 transition-all outline-none font-bold text-slate-700">
                                @error('nis') <span class="text-rose-500 text-xs font-bold ml-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] ml-1">Nama Lengkap Siswa</label>
                                <input type="text" name="nama_siswa" value="{{ old('nama_siswa') }}" placeholder="Masukkan nama lengkap" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-indigo-500 transition-all outline-none font-bold text-slate-700">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] ml-1">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-indigo-500 transition-all outline-none font-bold text-slate-700">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] ml-1">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-indigo-500 transition-all outline-none font-bold text-slate-700">
                            </div>
                        </div>
                    </div>

                    {{-- Domisili --}}
                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/50">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Domisili & Wilayah</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em]">Provinsi</label>
                                <select id="provinsi" name="provinsi" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-emerald-500 transition-all outline-none text-sm font-bold text-slate-700"></select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em]">Kota/Kabupaten</label>
                                <select id="kabupaten" name="kabupaten_kota" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-emerald-500 transition-all outline-none text-sm font-bold text-slate-700"></select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em]">Kecamatan</label>
                                <select id="kecamatan" name="kecamatan" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-emerald-500 transition-all outline-none text-sm font-bold text-slate-700"></select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em]">Kelurahan</label>
                                <select id="kelurahan" name="kelurahan" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-emerald-500 transition-all outline-none text-sm font-bold text-slate-700"></select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-1 space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em]">Kode Pos</label>
                                <input type="text" name="kode_pos" value="{{ old('kode_pos') }}" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-emerald-500 outline-none transition-all font-bold text-slate-700">
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em]">Alamat Lengkap</label>
                                <input type="text" name="alamat_lengkap" value="{{ old('alamat_lengkap') }}" placeholder="Jl. Raya No. 1..." class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-emerald-500 outline-none transition-all font-bold text-slate-700">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Kanan --}}
                <div class="space-y-8">
                    <div class="bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl text-white relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-indigo-500/10 rounded-full"></div>
                        <h3 class="text-lg font-black mb-6 flex items-center gap-2 uppercase tracking-widest text-indigo-400 italic">
                            Data Penunjang
                        </h3>
                        <div class="space-y-6">
                            <div>
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-2">Pilih Orang Tua</label>
                                <select name="id_orangtua" class="w-full bg-white/5 border-2 border-white/10 rounded-2xl px-5 py-4 text-white focus:border-indigo-500 outline-none font-bold">
                                    <option value="" class="text-slate-900">-- Cari Nama Wali --</option>
                                    @foreach($orangtua as $ortu)
                                        <option value="{{ $ortu->id }}" class="text-slate-900">{{ $ortu->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-2">Tahun Ajaran</label>
                                <select name="id_tahun_ajaran" class="w-full bg-white/5 border-2 border-white/10 rounded-2xl px-5 py-4 text-white focus:border-indigo-500 outline-none font-bold">
                                    @foreach($tahunAjaran as $ta)
                                        <option value="{{ $ta->id }}" class="text-slate-900">{{ $ta->rentang_tahun }} - {{ $ta->semester }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-2">Diagnosa / Kebutuhan Khusus</label>
                                <textarea name="kebutuhan_khusus" class="w-full bg-white/5 border-2 border-white/10 rounded-2xl px-5 py-4 text-white focus:border-indigo-500 outline-none h-32 text-sm italic font-medium" placeholder="Tulis diagnosa awal...">{{ old('kebutuhan_khusus') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/50">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-5 rounded-2xl transition-all shadow-xl shadow-indigo-100 mb-4 uppercase tracking-widest text-xs">
                            SIMPAN SISWA
                        </button>
                        <a href="{{ route('siswa.index') }}" class="w-full bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-500 font-black py-5 rounded-2xl transition-all flex items-center justify-center uppercase tracking-widest text-xs">
                            BATAL / KEMBALI
                        </a>
                        <p class="text-center text-[10px] text-slate-400 mt-6 italic font-medium">Pastikan data sesuai dengan kartu identitas asli.</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const p = document.getElementById('provinsi'),
          k = document.getElementById('kabupaten'),
          kc = document.getElementById('kecamatan'),
          kl = document.getElementById('kelurahan');

    // Load Provinces
    fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
        .then(r => r.json())
        .then(d => {
            p.innerHTML = '<option value="">Pilih Provinsi</option>';
            d.forEach(v => {
                let opt = new Option(v.name, v.name);
                opt.setAttribute('data-id', v.id); // Simpan ID di atribut data
                p.add(opt);
            });
        });

    // Province change -> Load Regencies
    p.onchange = () => {
        const id = p.options[p.selectedIndex].getAttribute('data-id');
        k.innerHTML = '<option>Loading...</option>';
        kc.innerHTML = ''; kl.innerHTML = '';

        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${id}.json`)
            .then(r => r.json())
            .then(d => {
                k.innerHTML = '<option value="">Pilih Kabupaten</option>';
                d.forEach(v => {
                    let opt = new Option(v.name, v.name);
                    opt.setAttribute('data-id', v.id);
                    k.add(opt);
                });
            });
    };

    // Regency change -> Load Districts
    k.onchange = () => {
        const id = k.options[k.selectedIndex].getAttribute('data-id');
        kc.innerHTML = '<option>Loading...</option>';
        kl.innerHTML = '';

        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${id}.json`)
            .then(r => r.json())
            .then(d => {
                kc.innerHTML = '<option value="">Pilih Kecamatan</option>';
                d.forEach(v => {
                    let opt = new Option(v.name, v.name);
                    opt.setAttribute('data-id', v.id);
                    kc.add(opt);
                });
            });
    };

    // District change -> Load Villages
    kc.onchange = () => {
        const id = kc.options[kc.selectedIndex].getAttribute('data-id');
        kl.innerHTML = '<option>Loading...</option>';

        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${id}.json`)
            .then(r => r.json())
            .then(d => {
                kl.innerHTML = '<option value="">Pilih Kelurahan</option>';
                d.forEach(v => {
                    kl.add(new Option(v.name, v.name));
                });
            });
    };
});
</script>
@endsection
