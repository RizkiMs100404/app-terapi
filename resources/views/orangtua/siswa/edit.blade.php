@extends('orangtua.layouts.main')

@section('content')
<div class="min-h-screen p-6 lg:p-10">
    <div class="max-w-5xl mx-auto">
        <div class="mb-10">
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">Profil <span class="text-indigo-600">Anak</span></h1>
            <p class="text-slate-500 font-semibold italic mt-1">Lengkapi data informasi medik dan identitas anak Anda</p>
        </div>

        <form action="{{ route('orangtua.siswa.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Kiri: Foto --}}
                <div class="lg:col-span-1">
                    <div class="bg-white p-8 rounded-[3rem] border border-indigo-50 shadow-xl text-center shadow-indigo-900/5">
                        <div class="relative w-48 h-48 mx-auto mb-6">
                            <img id="preview" src="{{ $siswa->foto ? asset('storage/foto_siswa/'.$siswa->foto) : 'https://ui-avatars.com/api/?name='.urlencode($siswa->nama_siswa).'&background=4f46e5&color=fff' }}" 
                                 class="w-full h-full object-cover rounded-[2.5rem] border-4 border-white shadow-2xl ring-2 ring-indigo-100">
                            
                            <label for="upload-foto" class="absolute -bottom-2 -right-2 w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white cursor-pointer hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" stroke-width="2"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"></path></svg>
                            </label>
                            <input type="file" name="foto" id="upload-foto" class="hidden" onchange="previewImage(this)">
                        </div>
                        <h2 class="text-xl font-black text-slate-800">{{ $siswa->nama_siswa }}</h2>
                        <p class="text-indigo-600 font-bold text-xs uppercase tracking-widest mt-1">{{ $siswa->nis }}</p>
                    </div>
                </div>

                {{-- Kanan: Form Data --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-10 rounded-[3rem] border border-indigo-50 shadow-xl shadow-indigo-900/5">
                        <h3 class="text-xl font-black text-slate-800 mb-8 flex items-center gap-3">
                            <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center text-sm">1</span>
                            Identitas Umum
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-indigo-900 uppercase tracking-widest ml-1">Nama Lengkap Anak</label>
                                <input type="text" name="nama_siswa" value="{{ old('nama_siswa', $siswa->nama_siswa) }}" class="w-full bg-indigo-50/30 border-2 border-transparent rounded-2xl px-5 py-3.5 focus:border-indigo-500 focus:bg-white transition-all outline-none font-bold text-slate-700">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-indigo-900 uppercase tracking-widest ml-1">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="w-full bg-indigo-50/30 border-2 border-transparent rounded-2xl px-5 py-3.5 focus:border-indigo-500 focus:bg-white transition-all outline-none font-bold text-slate-700">
                                    <option value="L" {{ $siswa->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ $siswa->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-indigo-900 uppercase tracking-widest ml-1">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}" class="w-full bg-indigo-50/30 border-2 border-transparent rounded-2xl px-5 py-3.5 focus:border-indigo-500 focus:bg-white transition-all outline-none font-bold text-slate-700">
                            </div>
                        </div>

                        <h3 class="text-xl font-black text-slate-800 my-8 flex items-center gap-3">
                            <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center text-sm">2</span>
                            Informasi Khusus
                        </h3>
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-indigo-900 uppercase tracking-widest ml-1">Kebutuhan Khusus / Diagnosa</label>
                                <textarea name="kebutuhan_khusus" rows="3" class="w-full bg-indigo-50/30 border-2 border-transparent rounded-2xl px-5 py-3.5 focus:border-indigo-500 focus:bg-white transition-all outline-none font-bold text-slate-700">{{ old('kebutuhan_khusus', $siswa->kebutuhan_khusus) }}</textarea>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-indigo-900 uppercase tracking-widest ml-1">Alamat Lengkap</label>
                                <textarea name="alamat_lengkap" rows="3" class="w-full bg-indigo-50/30 border-2 border-transparent rounded-2xl px-5 py-3.5 focus:border-indigo-500 focus:bg-white transition-all outline-none font-bold text-slate-700">{{ old('alamat_lengkap', $siswa->alamat_lengkap) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-10 flex justify-end">
                            <button type="submit" class="px-10 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-indigo-100 transition-all active:scale-95 uppercase tracking-widest text-xs">
                                Simpan Data Anak
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection