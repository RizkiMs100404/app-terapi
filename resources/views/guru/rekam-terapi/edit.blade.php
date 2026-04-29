@extends('guru.layouts.main')

@section('content')
<div class="min-h-screen p-4 lg:p-10 bg-[#FBFEFD]">
    <div class="max-w-5xl mx-auto">

        {{-- Menampilkan Error Validasi jika ada --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-sm">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-red-800 font-bold">Ada kesalahan input:</span>
                </div>
                <ul class="list-disc list-inside text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
            <div>
                <a href="{{ route('guru.rekam-terapi.history') }}" class="group inline-flex items-center text-emerald-600 font-bold mb-3 transition-all hover:text-emerald-700">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Batal & Kembali
                </a>
                <h1 class="text-4xl font-black text-emerald-950 tracking-tight">Edit Laporan <span class="text-emerald-600">Sesi {{ $rekamTerapi->nomor_sesi }}</span></h1>
                <p class="text-slate-500 font-medium">Siswa: <span class="text-emerald-700 font-bold">{{ $rekamTerapi->jadwal->siswa->nama_siswa }}</span></p>
            </div>

            {{-- Badge Jenis Terapi Premium --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-emerald-500 to-teal-600 px-8 py-4 rounded-[2rem] shadow-lg shadow-emerald-200">
                <div class="absolute -right-2 -top-2 w-12 h-12 bg-white/10 rounded-full blur-xl"></div>
                <span class="block text-[10px] font-black text-emerald-100 uppercase tracking-[0.2em] mb-1">Jenis Terapi</span>
                <span class="text-white font-black text-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    {{ $rekamTerapi->jadwal->jenis_terapi }}
                </span>
            </div>
        </div>

        <form action="{{ route('guru.rekam-terapi.update', $rekamTerapi->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf
            @method('PUT')

            {{-- PENTING: Hidden Input Tanggal agar lolos validasi Controller --}}
            <input type="hidden" name="tanggal_pelaksanaan" value="{{ $rekamTerapi->tanggal_pelaksanaan }}">

            {{-- Main Form (Left) --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-emerald-900/5 border border-white">
                    <label class="block text-lg font-black text-emerald-900 mb-6">Update hasil kemajuan:</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach(\App\Models\RekamTerapi::listKemajuan() as $key => $label)
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="hasil_kemajuan" value="{{ $key }}" class="hidden peer" {{ $rekamTerapi->hasil_kemajuan == $key ? 'checked' : '' }}>
                            <div class="p-5 rounded-[1.5rem] border-2 border-emerald-50 bg-emerald-50/30 peer-checked:bg-emerald-600 peer-checked:border-emerald-600 peer-checked:text-white transition-all duration-300">
                                <span class="block text-sm font-black uppercase tracking-wider">{{ $label }}</span>
                            </div>
                            <div class="absolute top-4 right-4 opacity-0 peer-checked:opacity-100 transition-opacity">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    <div class="mt-8 space-y-6">
                        <div>
                            <label class="block text-sm font-black text-emerald-900 mb-2 ml-1">Catatan Terapis (Detail)</label>
                            <textarea name="catatan_terapis" rows="4" required class="w-full rounded-[1.5rem] border-none bg-slate-50 focus:ring-2 focus:ring-emerald-500 p-6 text-slate-700 font-medium">{{ old('catatan_terapis', $rekamTerapi->catatan_terapis) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-black text-emerald-900 mb-2 ml-1">Rekomendasi Selanjutnya</label>
                            <textarea name="rekomendasi_lanjutan" rows="3" class="w-full rounded-[1.5rem] border-none bg-slate-50 focus:ring-2 focus:ring-emerald-500 p-6 text-slate-700 font-medium">{{ old('rekomendasi_lanjutan', $rekamTerapi->rekomendasi_lanjutan) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Form (Right) --}}
            <div class="space-y-6">
                <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-emerald-900/5 border border-white">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-black text-emerald-900 mb-2 uppercase tracking-widest text-[10px]">Skor Perkembangan</label>
                            <input type="number" name="skor_grafik" value="{{ old('skor_grafik', $rekamTerapi->skor_grafik) }}" min="0" max="100" required
                                class="w-full rounded-2xl border-none bg-slate-50 focus:ring-2 focus:ring-emerald-500 font-black text-2xl text-emerald-600 p-4 text-center">
                        </div>

                        <div>
                            <label class="block text-sm font-black text-emerald-900 mb-2 uppercase tracking-widest text-[10px]">Status Kehadiran</label>
                            <select name="status_kehadiran" class="w-full rounded-2xl border-none bg-slate-50 focus:ring-2 focus:ring-emerald-500 font-bold p-4 text-slate-700 cursor-pointer">
                                <option value="Hadir" {{ $rekamTerapi->status_kehadiran == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="Izin" {{ $rekamTerapi->status_kehadiran == 'Izin' ? 'selected' : '' }}>Izin</option>
                                <option value="Sakit" {{ $rekamTerapi->status_kehadiran == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="Tanpa Keterangan" {{ $rekamTerapi->status_kehadiran == 'Tanpa Keterangan' ? 'selected' : '' }}>Tanpa Keterangan</option>
                            </select>
                        </div>

                        {{-- Dokumentasi Sesi dengan Preview --}}
                        <div>
                            <label class="block text-sm font-black text-emerald-900 mb-4 uppercase tracking-widest text-[10px]">Dokumentasi Sesi</label>
                            <div class="relative group">
                                <label for="file_dokumentasi" class="flex flex-col items-center justify-center w-full h-48 border-4 border-dashed border-emerald-50 hover:bg-emerald-50 hover:border-emerald-200 transition-all rounded-[2rem] cursor-pointer bg-slate-50/50 overflow-hidden">

                                    {{-- Preview Container --}}
                                    <div id="preview-container" class="absolute inset-0 {{ $rekamTerapi->file_lampiran ? '' : 'hidden' }}">
                                        <img id="image-preview"
                                             src="{{ $rekamTerapi->file_lampiran ? asset('storage/' . $rekamTerapi->file_lampiran) : '#' }}"
                                             alt="Preview" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            <p class="text-white text-[10px] font-black uppercase tracking-widest underline">Ganti Foto Dokumentasi</p>
                                        </div>
                                    </div>

                                    {{-- Placeholder (muncul kalau foto belum ada) --}}
                                    <div id="placeholder-content" class="flex flex-col items-center justify-center {{ $rekamTerapi->file_lampiran ? 'hidden' : '' }}">
                                        <div class="p-4 bg-white rounded-2xl shadow-sm mb-3">
                                            <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Belum ada foto</p>
                                    </div>

                                    <input type="file" name="file_lampiran" id="file_dokumentasi" class="hidden" accept="image/*,application/pdf" onchange="previewImage(this)" />
                                </label>
                            </div>
                            <p class="text-[9px] text-slate-400 mt-2 italic text-center">*Kosongkan jika tidak ingin mengubah foto</p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-6 rounded-[2.5rem] font-black text-xl transition-all shadow-xl shadow-emerald-200 active:scale-95 flex items-center justify-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Update Laporan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script for Preview Image --}}
<script>
    function previewImage(input) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            const preview = document.getElementById('image-preview');
            const previewContainer = document.getElementById('preview-container');
            const placeholder = document.getElementById('placeholder-content');

            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
