@extends('admin.layouts.main')

@section('content')
<div class="bg-[#F8FAFC] min-h-screen p-6 lg:p-10">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Hasil <span class="text-indigo-600">Terapi</span></h1>
                <p class="text-slate-500 font-medium mt-1 italic">Monitoring kemajuan dan hasil perkembangan sesi terapi siswa secara real-time.</p>
            </div>
        </div>

        {{-- Filter --}}
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm mb-8">
            <form action="{{ route('admin.rekam-terapi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Siswa..." class="block w-full pl-6 pr-4 py-4 bg-slate-50 border-none rounded-2xl text-sm font-semibold focus:ring-4 focus:ring-indigo-50 outline-none shadow-inner">
                </div>

                <select name="status" class="px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 outline-none shadow-inner cursor-pointer">
                    <option value="">Semua Kehadiran</option>
                    <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                    <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="Tanpa Keterangan" {{ request('status') == 'Tanpa Keterangan' ? 'selected' : '' }}>Tanpa Keterangan</option>
                </select>

                <select name="kemajuan" class="px-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 outline-none shadow-inner cursor-pointer">
                    <option value="">Semua Kemajuan</option>
                    @foreach(\App\Models\RekamTerapi::listKemajuan() as $key => $label)
                        <option value="{{ $key }}" {{ request('kemajuan') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                <button type="submit" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">
                    Terapkan Filter
                </button>
            </form>
        </div>

        {{-- Table/List --}}
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Siswa & Sesi</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kemajuan Sesi</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Perkembangan Skor</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($rekamTerapi as $r)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $r->jadwal->siswa->nama_siswa }}</span>
                                    <span class="text-[10px] font-bold text-indigo-500 uppercase mt-1">Sesi #{{ $r->nomor_sesi }} — {{ \Carbon\Carbon::parse($r->tanggal_pelaksanaan)->translatedFormat('d F Y') }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                @php
                                    $kemajuanStyle = match($r->hasil_kemajuan) {
                                        'Meningkat Pesat' => 'bg-emerald-500 text-white',
                                        'Meningkat' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'Tetap' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'Menurun' => 'bg-rose-50 text-rose-600 border-rose-100',
                                        default => 'bg-slate-50 text-slate-600 border-slate-100'
                                    };
                                @endphp
                                <div class="flex flex-col gap-2">
                                    <span class="inline-flex items-center w-fit px-3 py-1 rounded-full border {{ $kemajuanStyle }} text-[9px] font-black uppercase tracking-wider">
                                        {{ $r->hasil_kemajuan }}
                                    </span>
                                    <span class="text-[9px] text-slate-400 font-bold uppercase italic">Oleh: {{ $r->jadwal->guru->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 h-2 w-24 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-indigo-400 to-indigo-600" style="width: {{ $r->skor_grafik }}%"></div>
                                    </div>
                                    <span class="text-xs font-black text-slate-700">{{ $r->skor_grafik }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                @php
                                    $statusStyle = match($r->status_kehadiran) {
                                        'Hadir' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'Izin', 'Sakit' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        default => 'bg-rose-50 text-rose-600 border-rose-100',
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-lg border {{ $statusStyle }} text-[9px] font-black uppercase tracking-wider">
                                    {{ $r->status_kehadiran }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.rekam-terapi.show', $r->id) }}" class="p-3 bg-slate-50 text-slate-400 hover:bg-indigo-600 hover:text-white rounded-xl transition-all shadow-sm" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.rekam-terapi.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus data laporan ini? File lampiran juga akan terhapus secara permanen.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-3 bg-slate-50 text-rose-300 hover:bg-rose-600 hover:text-white rounded-xl transition-all shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-24 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="p-6 bg-slate-50 rounded-full mb-4">
                                        <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <p class="text-slate-400 font-bold italic">Data rekam sesi terapi tidak ditemukan.</p>
                                    <a href="{{ route('admin.rekam-terapi.index') }}" class="mt-4 text-indigo-600 text-xs font-black uppercase tracking-widest decoration-2 underline underline-offset-4">Reset Filter</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8">
            {{ $rekamTerapi->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
