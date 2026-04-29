@extends('admin.layouts.main')

@section('content')
<div class="min-h-screen p-6 lg:p-10">
    <div class="max-w-5xl mx-auto">

        {{-- Header & Actions --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div class="flex items-center gap-5">
                <a href="{{ route('siswa.index') }}" class="group p-3 bg-white border border-slate-200 rounded-2xl hover:bg-indigo-600 transition-all shadow-sm">
                    <svg class="w-6 h-6 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Detail <span class="text-indigo-600">Siswa</span></h1>
                    <p class="text-slate-500 font-medium italic">Informasi lengkap profil murid terapi</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('siswa.edit', $siswa->id) }}" class="flex-1 md:flex-none px-6 py-3 bg-white border-2 border-indigo-600 text-indigo-600 font-bold rounded-2xl hover:bg-indigo-50 transition-all text-center">
                    Edit Profil
                </a>
                <button onclick="window.print()" class="p-3 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition-all shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H7v4a2 2 0 002 2z"></path></svg>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- Sidebar Kiri: Foto & Status Singkat --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/50 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-24 bg-indigo-600"></div>

                    <div class="relative z-10">
                        <div class="inline-flex p-1 bg-white rounded-full shadow-xl mb-4">
                            <div class="w-32 h-32 bg-slate-100 rounded-full flex items-center justify-center overflow-hidden border-4 border-white">
                                {{-- Placeholder Avatar berdasarkan Jenis Kelamin --}}
                                @if($siswa->jenis_kelamin == 'L')
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama_siswa) }}&background=4f46e5&color=fff&size=128" alt="Avatar">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama_siswa) }}&background=ec4899&color=fff&size=128" alt="Avatar">
                                @endif
                            </div>
                        </div>

                        <h2 class="text-2xl font-black text-slate-800 leading-tight">{{ $siswa->nama_siswa }}</h2>
                        <p class="text-indigo-600 font-bold mt-1 uppercase tracking-widest text-xs">{{ $siswa->nis }}</p>

                        <div class="flex items-center justify-center gap-2 mt-4">
                            <span class="px-4 py-1.5 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-tighter">Aktif Terapi</span>
                            <span class="px-4 py-1.5 bg-slate-100 text-slate-600 rounded-full text-[10px] font-black uppercase tracking-tighter">TA {{ $siswa->tahunAjaran->rentang_tahun }}</span>
                        </div>
                    </div>

                    <div class="mt-8 pt-8 border-t border-slate-100 grid grid-cols-2 gap-4">
                        <div class="text-left">
                            <p class="text-[10px] font-black text-slate-400 uppercase">Gender</p>
                            <p class="text-sm font-bold text-slate-700">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div class="text-left">
                            <p class="text-[10px] font-black text-slate-400 uppercase">Usia</p>
                            <p class="text-sm font-bold text-slate-700">{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->age }} Tahun</p>
                        </div>
                    </div>
                </div>

                {{-- Card Orang Tua --}}
                <div class="bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl text-white relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl transition-all group-hover:scale-150"></div>
                    <h3 class="text-xs font-black text-indigo-400 uppercase tracking-[0.2em] mb-6 italic">Wali Murid / Orang Tua</h3>

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-lg font-black leading-none">{{ $siswa->orangtua->user->name }}</p>
                            <p class="text-xs text-slate-400 mt-1 italic">{{ $siswa->orangtua->user->email }}</p>
                        </div>
                    </div>

                    <a href="https://wa.me/{{ $siswa->orangtua->no_hp }}" target="_blank" class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl flex items-center justify-center gap-2 transition-all text-sm uppercase tracking-widest shadow-lg shadow-indigo-900/50">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Hubungi Orang Tua
                    </a>
                </div>
            </div>

            {{-- Kolom Kanan: Detail Data --}}
            <div class="lg:col-span-8 space-y-8">

                {{-- Detail Profil --}}
                <div class="bg-white p-10 rounded-[2.5rem] border border-slate-200 shadow-xl shadow-slate-200/50 relative">
                    <div class="flex items-center gap-3 mb-10">
                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Informasi Data Pribadi</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                        <div class="space-y-1">
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Nomor Induk Siswa (NIS)</p>
                            <p class="text-lg font-bold text-slate-700">{{ $siswa->nis }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Tempat, Tanggal Lahir</p>
                            <p class="text-lg font-bold text-slate-700">{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Semester / Tahun Ajaran</p>
                            <p class="text-lg font-bold text-slate-700">{{ $siswa->tahunAjaran->semester }} - {{ $siswa->tahunAjaran->rentang_tahun }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Domisili (Kelurahan)</p>
                            <p class="text-lg font-bold text-slate-700">{{ $siswa->kelurahan }}</p>
                        </div>
                    </div>

                    <div class="mt-12 pt-8 border-t border-slate-100">
                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">Alamat Lengkap</p>
                        <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100 text-slate-700 leading-relaxed font-bold">
                            {{ $siswa->alamat_lengkap }}, Kec. {{ $siswa->kecamatan }}, {{ $siswa->kabupaten_kota }}, Prov. {{ $siswa->provinsi }} ({{ $siswa->kode_pos }})
                        </div>
                    </div>
                </div>

                {{-- Card Diagnosa (Highlight) --}}
                <div class="bg-white p-10 rounded-[2.5rem] border-2 border-indigo-100 shadow-xl shadow-indigo-100/50">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.691.34a2 2 0 01-1.783 0l-.691-.34a6 6 0 00-3.86-.517l-2.388.477a2 2 0 00-1.022.547l-.34.34a2 2 0 000 2.828l1.245 1.245A2 2 0 005.337 21h13.326a2 2 0 001.414-.586l1.245-1.245a2 2 0 000-2.828l-.34-.34z"></path></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Diagnosa & Kebutuhan Khusus</h3>
                    </div>

                    <div class="p-8 bg-indigo-50/50 rounded-[2rem] border border-indigo-100 min-h-[150px]">
                        <p class="text-indigo-900 leading-relaxed italic font-medium">
                            @if($siswa->kebutuhan_khusus)
                                "{{ $siswa->kebutuhan_khusus }}"
                            @else
                                <span class="text-slate-400">Tidak ada catatan diagnosa khusus untuk siswa ini.</span>
                            @endif
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * { visibility: hidden; }
        .bg-[#F1F5F9] { background: white !important; }
        .max-w-5xl, .max-w-5xl * { visibility: visible; }
        .max-w-5xl { position: absolute; left: 0; top: 0; width: 100%; }
        button, a[href*="edit"], a[href*="index"] { display: none !important; }
    }
</style>
@endsection
