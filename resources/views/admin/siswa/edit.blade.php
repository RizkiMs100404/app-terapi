@extends('admin.layouts.main')

@section('content')
{{-- Library SweetAlert2 untuk alert yang premium --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="min-h-screen p-6 lg:p-10">
    <div class="max-w-6xl mx-auto">
        {{-- Alert Error jika validasi gagal (tertangkap catch controller) --}}
        @if(session('error'))
            <script>
                Swal.fire({ icon: 'error', title: 'Oops...', text: "{{ session('error') }}", confirmButtonColor: '#4f46e5' });
            </script>
        @endif

        {{-- Header --}}
        <div class="flex items-center justify-between mb-10">
            <div class="flex items-center gap-4">
                <a href="{{ route('siswa.index') }}" class="group p-3 bg-white border border-slate-200 rounded-2xl hover:bg-indigo-600 transition-all shadow-sm">
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Edit Profil <span class="text-indigo-600">Siswa</span></h1>
                    <p class="text-slate-500 font-medium italic">Perbarui data: <span class="text-indigo-600">{{ $siswa->nama_siswa }} (NIS: {{ $siswa->nis }})</span></p>
                </div>
            </div>
        </div>

        <form action="{{ route('siswa.update', $siswa->id) }}" method="POST" id="formEditSiswa" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Wajib untuk Update --}}

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Form Kiri (Data Utama) --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Profil Identitas --}}
                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/50 relative overflow-hidden group">
                        {{-- Decorative background --}}
                        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full -mr-16 -mt-16 transition-all group-hover:scale-150"></div>

                        <div class="flex items-center gap-3 mb-8 relative z-10">
                            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Profil Identitas</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] ml-1">NIS (Nomor Induk Siswa)</label>
                                <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" required placeholder="Contoh: 2026001" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-indigo-500 transition-all outline-none font-bold text-slate-700">
                                @error('nis') <span class="text-rose-500 text-xs font-bold ml-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] ml-1">Nama Lengkap Siswa</label>
                                <input type="text" name="nama_siswa" value="{{ old('nama_siswa', $siswa->nama_siswa) }}" required placeholder="Masukkan nama lengkap" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-indigo-500 transition-all outline-none font-bold text-slate-700">
                                @error('nama_siswa') <span class="text-rose-500 text-xs font-bold ml-1">{{ $message }}</span> @enderror
                            </div>
                            {{-- Tingkat (Update Baru) --}}
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] ml-1">Tingkat Sekolah</label>
                                <select name="tingkat" required class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-indigo-500 transition-all outline-none font-bold text-slate-700 cursor-pointer">
                                    <option value="SDLB" {{ old('tingkat', $siswa->tingkat) == 'SDLB' ? 'selected' : '' }}>SDLB</option>
                                    <option value="SMPLB" {{ old('tingkat', $siswa->tingkat) == 'SMPLB' ? 'selected' : '' }}>SMPLB</option>
                                    <option value="SMALB" {{ old('tingkat', $siswa->tingkat) == 'SMALB' ? 'selected' : '' }}>SMALB</option>
                                </select>
                                @error('tingkat') <span class="text-rose-500 text-xs font-bold ml-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Kelas (Update Baru) --}}
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] ml-1">Kelas</label>
                                <input type="text" name="kelas" value="{{ old('kelas', $siswa->kelas) }}" required placeholder="Contoh: 1-A atau VII-B" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-indigo-500 transition-all outline-none font-bold text-slate-700">
                                @error('kelas') <span class="text-rose-500 text-xs font-bold ml-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] ml-1">Jenis Kelamin</label>
                                <select name="jenis_kelamin" required class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-indigo-500 transition-all outline-none font-bold text-slate-700 cursor-pointer">
                                    <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] ml-1">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}" required class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-indigo-500 transition-all outline-none font-bold text-slate-700">
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

                        {{-- Info Wilayah Saat Ini --}}
                        <div class="bg-slate-50 border border-slate-100 p-5 rounded-2xl mb-6 flex items-start gap-4 italic text-sm text-slate-600 shadow-inner">
                            <svg class="w-10 h-10 text-emerald-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <span class="font-bold text-emerald-700">Wilayah Tercatat:</span><br>
                                {{ $siswa->alamat_lengkap }}, Kel. {{ $siswa->kelurahan }}, Kec. {{ $siswa->kecamatan }}, {{ $siswa->kabupaten_kota }}, Prov. {{ $siswa->provinsi }}, {{ $siswa->kode_pos }}.
                                <p class="text-xs mt-1 text-slate-400">Gunakan dropdown di bawah jika ingin mengubah wilayah.</p>
                            </div>
                        </div>

                        {{-- Dropdown API Wilayah --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 relative z-10">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em]">Provinsi Baru</label>
                                <select id="provinsi" name="provinsi" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-emerald-500 transition-all outline-none text-sm font-bold text-slate-700 cursor-pointer"></select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em]">Kota/Kabupaten Baru</label>
                                <select id="kabupaten" name="kabupaten_kota" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-emerald-500 transition-all outline-none text-sm font-bold text-slate-700 cursor-pointer"></select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em]">Kecamatan Baru</label>
                                <select id="kecamatan" name="kecamatan" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-emerald-500 transition-all outline-none text-sm font-bold text-slate-700 cursor-pointer"></select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em]">Kelurahan Baru</label>
                                <select id="kelurahan" name="kelurahan" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-emerald-500 transition-all outline-none text-sm font-bold text-slate-700 cursor-pointer"></select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10">
                            <div class="md:col-span-1 space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em]">Kode Pos</label>
                                <input type="text" name="kode_pos" value="{{ old('kode_pos', $siswa->kode_pos) }}" class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-emerald-500 outline-none transition-all font-bold text-slate-700">
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.1em]">Alamat Lengkap Baru</label>
                                <input type="text" name="alamat_lengkap" value="{{ old('alamat_lengkap', $siswa->alamat_lengkap) }}" placeholder="Jl. Raya No. 1..." class="w-full bg-slate-50 border-2 border-transparent rounded-2xl px-5 py-4 focus:bg-white focus:border-emerald-500 outline-none transition-all font-bold text-slate-700">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Kanan --}}
                <div class="space-y-8">
                    {{-- Card Foto Profil --}}
                        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/50 mb-8 overflow-hidden relative group">
                            <div class="absolute top-0 left-0 w-full h-2 bg-indigo-600"></div>
                            
                            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-6 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Foto Profil
                            </h3>

                            <div class="flex flex-col items-center">
                                {{-- Preview Container --}}
                                <div class="relative group/avatar mb-6">
                                    <div class="w-40 h-40 rounded-[2rem] overflow-hidden ring-4 ring-slate-50 shadow-2xl relative">
                                        <img id="previewFoto" 
                            src="{{ $siswa->foto && Storage::exists('public/foto_siswa/' . $siswa->foto) 
                                    ? asset('storage/foto_siswa/' . $siswa->foto) 
                                    : 'https://ui-avatars.com/api/?name='.urlencode($siswa->nama_siswa).'&background=4f46e5&color=fff&size=512' }}" 
                            class="w-full h-full object-cover transition-transform duration-500 group-hover/avatar:scale-110"
                            alt="Foto Siswa">
                                        
                                        {{-- Overlay Label --}}
                                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover/avatar:opacity-100 transition-opacity">
                                            <span class="text-white text-[10px] font-black uppercase tracking-tighter">Ganti Foto</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Custom File Input --}}
                                <div class="w-full">
                                    <label class="block">
                                        <span class="sr-only">Pilih Foto</span>
                                        <input type="file" name="foto" id="inputFoto" accept="image/*"
                                            class="block w-full text-sm text-slate-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-full file:border-0
                                            file:text-xs file:font-black
                                            file:bg-indigo-50 file:text-indigo-700
                                            hover:file:bg-indigo-100 transition-all cursor-pointer"/>
                                    </label>
                                    <p class="text-[9px] text-slate-400 mt-3 text-center italic">Format: JPG, PNG, WEBP (Maks. 2MB)</p>
                                </div>
                            </div>
                        </div>
                    {{-- Data Penunjang (Indigo Night) --}}
                    <div class="bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl text-white relative overflow-hidden group">
                        {{-- Decorative --}}
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-indigo-500/10 rounded-full blur-xl transition-all group-hover:scale-150"></div>

                        <h3 class="text-lg font-black mb-6 flex items-center gap-2 uppercase tracking-widest text-indigo-300 italic relative z-10">
                            Data Penunjang
                        </h3>
                        <div class="space-y-6 relative z-10">
                            <div>
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-2">Wali Murid (Orang Tua)</label>
                                <select name="id_orangtua" required class="w-full bg-white/5 border-2 border-white/10 rounded-2xl px-5 py-4 text-white focus:border-indigo-500 outline-none font-bold cursor-pointer">
                                    @foreach($orangtua as $ortu)
                                        <option value="{{ $ortu->id }}" class="text-slate-900" {{ old('id_orangtua', $siswa->id_orangtua) == $ortu->id ? 'selected' : '' }}>{{ $ortu->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-2">Tahun Ajaran Aktif</label>
                                <select name="id_tahun_ajaran" required class="w-full bg-white/5 border-2 border-white/10 rounded-2xl px-5 py-4 text-white focus:border-indigo-500 outline-none font-bold cursor-pointer">
                                    @foreach($tahunAjaran as $ta)
                                        <option value="{{ $ta->id }}" class="text-slate-900" {{ old('id_tahun_ajaran', $siswa->id_tahun_ajaran) == $ta->id ? 'selected' : '' }}>{{ $ta->rentang_tahun }} - {{ $ta->semester }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest block mb-2">Diagnosa / Kebutuhan Khusus</label>
                                <textarea name="kebutuhan_khusus" class="w-full bg-white/5 border-2 border-white/10 rounded-2xl px-5 py-4 text-white focus:border-indigo-500 outline-none h-40 text-sm italic font-medium leading-relaxed" placeholder="Tulis diagnosa atau kebutuhan khusus siswa...">{{ old('kebutuhan_khusus', $siswa->kebutuhan_khusus) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Actions Card --}}
                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/50">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-5 rounded-2xl transition-all shadow-xl shadow-indigo-100 mb-4 uppercase tracking-widest text-xs flex items-center justify-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            SIMPAN PERUBAHAN
                        </button>

                        {{-- Tombol Batal --}}
                        <a href="{{ route('siswa.index') }}" class="w-full bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-500 font-black py-5 rounded-2xl transition-all flex items-center justify-center uppercase tracking-widest text-xs gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            BATAL / KEMBALI
                        </a>

                        <p class="text-center text-[10px] text-slate-400 mt-6 italic font-medium leading-relaxed">
                            Pastikan diagnosa dan alamat sudah diperiksa kembali sebelum disimpan.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Script API Wilayah Indonesia --}}
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
            p.innerHTML = '<option value="">Pilih Provinsi Baru (Jika Ubah)</option>';
            d.forEach(v => {
                let opt = new Option(v.name, v.name);
                opt.setAttribute('data-id', v.id); // Simpan ID di data-id
                p.add(opt);
            });
        });

    // Province change -> Load Regencies
    p.onchange = () => {
        const selectedOption = p.options[p.selectedIndex];
        if(!selectedOption.value) return; // Jika pilih default

        const id = selectedOption.getAttribute('data-id');
        k.innerHTML = '<option>Loading...</option>';
        kc.innerHTML = ''; kl.innerHTML = ''; // Reset dropdown bawahnya

        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${id}.json`)
            .then(r => r.json())
            .then(d => {
                k.innerHTML = '<option value="">Pilih Kabupaten Baru</option>';
                d.forEach(v => {
                    let opt = new Option(v.name, v.name);
                    opt.setAttribute('data-id', v.id);
                    k.add(opt);
                });
            });
    };

    // Regency change -> Load Districts
    k.onchange = () => {
        const selectedOption = k.options[k.selectedIndex];
        if(!selectedOption.value) return;

        const id = selectedOption.getAttribute('data-id');
        kc.innerHTML = '<option>Loading...</option>';
        kl.innerHTML = '';

        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${id}.json`)
            .then(r => r.json())
            .then(d => {
                kc.innerHTML = '<option value="">Pilih Kecamatan Baru</option>';
                d.forEach(v => {
                    let opt = new Option(v.name, v.name);
                    opt.setAttribute('data-id', v.id);
                    kc.add(opt);
                });
            });
    };

    // District change -> Load Villages
    kc.onchange = () => {
        const selectedOption = kc.options[kc.selectedIndex];
        if(!selectedOption.value) return;

        const id = selectedOption.getAttribute('data-id');
        kl.innerHTML = '<option>Loading...</option>';

        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${id}.json`)
            .then(r => r.json())
            .then(d => {
                kl.innerHTML = '<option value="">Pilih Kelurahan Baru</option>';
                d.forEach(v => {
                    // Kelurahan tidak butuh ID lagi karena ini level terakhir
                    kl.add(new Option(v.name, v.name));
                });
            });
    };
});

// Letakkan di dalam document.addEventListener('DOMContentLoaded', function() { ... })
const inputFoto = document.getElementById('inputFoto');
const previewFoto = document.getElementById('previewFoto');

if(inputFoto) {
    inputFoto.onchange = evt => {
        const [file] = inputFoto.files;
        if (file) {
            // Validasi Ukuran 2MB
            if(file.size > 2048 * 1024){
                Swal.fire({ icon: 'error', title: 'File Terlalu Besar', text: 'Maksimal 2MB ya Bang!' });
                inputFoto.value = "";
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewFoto.src = e.target.result;
            }
            reader.readAsDataURL(file);
            
            // Efek refresh biar kelihatan ganti
            previewFoto.classList.add('opacity-50');
            setTimeout(() => previewFoto.classList.remove('opacity-50'), 300);
        }
    };
}
</script>
@endsection
