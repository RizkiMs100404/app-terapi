@extends('admin.layouts.main')

@section('content')
<div class="bg-[#F8FAFC] min-h-screen p-6 lg:p-10">
    <div class="max-w-5xl mx-auto">
        {{-- Header & Navigation --}}
        <div class="flex items-center justify-between mb-10">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.rekam-terapi.index') }}" class="p-3 bg-white border border-slate-200 rounded-2xl shadow-sm hover:bg-indigo-600 hover:text-white transition-all group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Detail <span class="text-indigo-600">Sesi Terapi</span></h1>
                    <p class="text-slate-500 font-medium italic">Laporan lengkap sesi {{ $rekam->nomor_sesi }} — {{ $rekam->jadwal->tahunAjaran->tahun_ajaran ?? 'Pelayanan Terapi' }}</p>
                </div>
            </div>

            <button onclick="window.print()" class="hidden md:flex items-center gap-2 px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Laporan
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Kolom Kiri: Info Utama --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Card Laporan Utama --}}
                <div class="bg-white rounded-[3rem] border border-slate-100 shadow-xl shadow-indigo-900/5 overflow-hidden">
                    @php
                        $headerColor = match($rekam->hasil_kemajuan) {
                            'Meningkat Pesat' => 'bg-emerald-600',
                            'Meningkat' => 'bg-indigo-600',
                            'Tetap' => 'bg-amber-500',
                            'Menurun' => 'bg-rose-600',
                            default => 'bg-slate-700'
                        };
                    @endphp
                    <div class="{{ $headerColor }} p-8 text-white transition-colors duration-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="px-3 py-1 bg-white/20 rounded-lg text-[10px] font-black uppercase tracking-widest">{{ $rekam->jadwal->jenis_terapi }}</span>
                                <h2 class="text-3xl font-black mt-2">{{ $rekam->jadwal->siswa->nama_siswa }}</h2>
                            </div>
                            <div class="text-right">
                                <p class="text-white/70 text-xs font-bold uppercase tracking-tighter leading-none">Tanggal Pelaksanaan</p>
                                <p class="text-xl font-black">{{ \Carbon\Carbon::parse($rekam->tanggal_pelaksanaan)->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 space-y-8">
                        {{-- Hasil Kemajuan (Premium Icon & Highlight) --}}
                        <div>
                            <h4 class="flex items-center gap-2 text-sm font-black text-slate-900 uppercase tracking-widest mb-4">
                                <span class="w-2 h-6 bg-indigo-500 rounded-full"></span>
                                Ringkasan Kemajuan
                            </h4>
                            <div class="flex items-center gap-4 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                    @switch($rekam->hasil_kemajuan)
                                        @case('Meningkat Pesat')
                                            <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            @break
                                        @case('Meningkat')
                                            <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                            @break
                                        @case('Tetap')
                                            <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h8m-8 5h8m-8 5h8"></path>
                                            </svg>
                                            @break
                                        @case('Menurun')
                                            <svg class="w-10 h-10 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path>
                                            </svg>
                                            @break
                                        @default
                                            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                    @endswitch
                                </div>
                                <div>
                                    <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Status Perkembangan</span>
                                    <span class="text-2xl font-black text-slate-800 tracking-tight">{{ $rekam->hasil_kemajuan }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Catatan Terapis --}}
                        <div>
                            <h4 class="flex items-center gap-2 text-sm font-black text-slate-900 uppercase tracking-widest mb-4">
                                <span class="w-2 h-6 bg-emerald-500 rounded-full"></span>
                                Deskripsi Sesi & Observasi
                            </h4>
                            <div class="bg-white p-6 rounded-3xl border-2 border-dashed border-slate-100 text-slate-600 leading-relaxed font-medium">
                                {{ $rekam->catatan_terapis }}
                            </div>
                        </div>

                        {{-- Rekomendasi Lanjutan --}}
                        <div class="pt-6 border-t border-slate-50">
                            <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Rekomendasi Lanjutan
                            </h4>
                            <p class="text-slate-600 font-semibold bg-rose-50/50 p-6 rounded-3xl border border-rose-100/50">
                                {{ $rekam->rekomendasi_lanjutan ?? 'Tidak ada rekomendasi khusus untuk sesi ini.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Status & Skor --}}
            <div class="space-y-8">
                {{-- Score Card --}}
                <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-2xl">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl"></div>
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Skor Grafik Perkembangan</h4>

                    <div class="flex items-end gap-2 mb-4">
                        <span class="text-6xl font-black text-indigo-400 leading-none">{{ $rekam->skor_grafik }}</span>
                        <span class="text-xl font-bold text-slate-500">/100</span>
                    </div>

                    <div class="w-full h-3 bg-slate-800 rounded-full overflow-hidden mb-4">
                        <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500" style="width: {{ $rekam->skor_grafik }}%"></div>
                    </div>
                    <p class="text-xs text-slate-400 font-medium italic leading-relaxed">Skor ini dikonversi menjadi titik koordinat pada grafik bulanan siswa.</p>
                </div>

                {{-- Metadata Card --}}
                <div class="bg-white rounded-[2.5rem] border border-slate-100 p-8 shadow-xl shadow-indigo-900/5 space-y-6">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Terapis Penanggung Jawab</p>
                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-100">
                            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-black shadow-lg shadow-indigo-200">
                                {{ substr($rekam->jadwal->guru->user->name, 0, 1) }}
                            </div>
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-700 text-sm">{{ $rekam->jadwal->guru->user->name }}</span>
                                <span class="text-[9px] text-slate-400 font-black uppercase">NIP/ID Guru</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Status Presensi</p>
                        @php
                            $statusColors = match($rekam->status_kehadiran) {
                                'Hadir' => 'text-emerald-600 bg-emerald-50 border-emerald-100',
                                'Izin', 'Sakit' => 'text-amber-600 bg-amber-50 border-amber-100',
                                default => 'text-rose-600 bg-rose-50 border-rose-100',
                            };
                        @endphp
                        <span class="inline-flex items-center justify-center w-full px-4 py-3 rounded-xl border {{ $statusColors }} text-xs font-black uppercase tracking-widest">
                            ● {{ $rekam->status_kehadiran }}
                        </span>
                    </div>

                    @if($rekam->file_lampiran)
                    <div class="pt-4 border-t border-slate-50">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Dokumentasi Terlampir</p>
                        <a href="{{ asset('storage/' . $rekam->file_lampiran) }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-4 bg-indigo-50 border border-indigo-100 rounded-2xl text-indigo-600 font-bold text-xs hover:bg-indigo-600 hover:text-white transition-all shadow-sm group">
                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            UNDUH DOKUMEN SESI
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
