@extends('orangtua.layouts.main')

@section('content')
<div class="min-h-screen p-4 lg:p-10">
    <div class="max-w-7xl mx-auto">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Riwayat Perkembangan</h1>
                <p class="text-sm text-slate-500 font-medium mt-1">Pantau setiap kemajuan Ananda <span class="text-indigo-600 font-bold">{{ $anak->nama_siswa }}</span></p>
            </div>
            
            {{-- Search Bar --}}
            <form action="{{ route('orangtua.jadwal.history') }}" method="GET" class="relative group">
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="w-full md:w-80 pl-12 pr-4 py-4 bg-white border border-slate-200 rounded-[2rem] text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm"
                    placeholder="Cari catatan atau nama guru...">
                <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </form>
        </div>

        {{-- Table Container --}}
        <div class="bg-white rounded-[3rem] shadow-xl shadow-indigo-900/5 border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Sesi & Terapis</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Tanggal</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Skor & Kemajuan</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Catatan & Lampiran</th>
                            <th class="px-6 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($history as $item)
                        <tr class="hover:bg-indigo-50/30 transition-colors group">
                            {{-- Sesi & Guru --}}
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0 w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center font-black text-xs shadow-lg shadow-indigo-200">
                                        {{ $item->nomor_sesi ?? 'N/A' }}
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="relative w-10 h-10 rounded-full overflow-hidden border-2 border-white shadow-sm ring-1 ring-slate-100">
                                            @if($item->jadwal->guru->foto)
                                                <img src="{{ asset('storage/foto_guru/' . $item->jadwal->guru->foto) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                                                    <i class="fa-solid fa-user text-xs"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-900 leading-tight">{{ $item->jadwal->guru->user->name }}</p>
                                            <p class="text-[9px] font-bold text-indigo-500 uppercase tracking-widest">{{ $item->jadwal->jenis_terapi }}</p>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Tanggal --}}
                            <td class="px-6 py-6 whitespace-nowrap">
                                <p class="text-sm font-bold text-slate-700">{{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->isoFormat('DD MMMM YYYY') }}</p>
                                <p class="text-[10px] text-slate-400 font-medium uppercase italic">{{ $item->jadwal->hari }}</p>
                            </td>

                            {{-- Skor & Kemajuan --}}
                            <td class="px-6 py-6">
                                <div class="mb-2 flex items-center justify-between">
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Skor: {{ $item->skor_grafik ?? 0 }}%</span>
                                </div>
                                <div class="w-32 h-1.5 bg-slate-100 rounded-full overflow-hidden mb-3">
                                    <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $item->skor_grafik ?? 0 }}%"></div>
                                </div>

                                @php
                                    $color = match($item->hasil_kemajuan) {
                                        'Meningkat Pesat' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
                                        'Meningkat' => 'bg-blue-100 text-blue-700 ring-blue-200',
                                        'Tetap' => 'bg-amber-100 text-amber-700 ring-amber-200',
                                        default => 'bg-rose-100 text-rose-700 ring-rose-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black uppercase {{ $color }} ring-1 ring-inset">
                                    {{ $item->hasil_kemajuan }}
                                </span>
                            </td>

                            {{-- Catatan & Lampiran --}}
                            <td class="px-6 py-6 max-w-xs">
                                <div class="text-xs text-slate-600 leading-relaxed mb-3 line-clamp-2 group-hover:line-clamp-none transition-all">
                                    <span class="font-bold text-slate-900">Catatan:</span> {{ $item->catatan_terapis ?? '-' }}
                                </div>
                                
                                @if($item->file_lampiran)
                                    <a href="{{ asset('storage/lampiran_terapi/' . $item->file_lampiran) }}" target="_blank" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-[10px] font-black uppercase hover:bg-indigo-600 hover:text-white transition-all group/btn">
                                        <i class="fa-solid fa-camera text-xs"></i>
                                        Dokumentasi
                                    </a>
                                @else
                                    <span class="text-[10px] text-slate-300 italic">No Attachment</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-6">
                                <div class="flex flex-col items-center gap-1">
                                    @if($item->status_kehadiran == 'Hadir')
                                        <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500">
                                            <i class="fa-solid fa-check text-xs"></i>
                                        </div>
                                        <span class="text-[9px] font-black text-emerald-600 uppercase">Hadir</span>
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-amber-50 flex items-center justify-center text-amber-500">
                                            <i class="fa-solid fa-clock text-xs"></i>
                                        </div>
                                        <span class="text-[9px] font-black text-amber-600 uppercase">{{ $item->status_kehadiran }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center text-slate-400">
                                <i class="fa-solid fa-inbox text-4xl mb-4 block opacity-20"></i>
                                <p class="text-sm font-bold uppercase tracking-widest">Belum ada data history</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($history->hasPages())
            <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">
                {{ $history->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection