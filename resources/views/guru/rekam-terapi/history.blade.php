@extends('guru.layouts.main')

@section('content')
<div class="min-h-screen p-6 lg:p-10">
    <div class="max-w-7xl mx-auto">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
            <div class="space-y-1">
                <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none">
                    Riwayat <span class="text-emerald-600">Terapi</span>
                </h1>
                <p class="text-slate-500 font-medium tracking-wide italic">Pusat dokumentasi dan arsip laporan sesi terapi siswa.</p>
            </div>

            <div class="flex items-center gap-3 bg-white p-2 rounded-2xl shadow-sm border border-slate-100">
                <div class="px-5 py-3 bg-emerald-50 rounded-xl border border-emerald-100">
                    <span class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] block mb-1">Total Laporan</span>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-box-archive text-emerald-600"></i>
                        <p class="text-2xl font-black text-emerald-900 leading-none">{{ $riwayat->total() }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search & Filter Card --}}
        <div class="bg-white p-4 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 mb-10 transition-all hover:shadow-2xl hover:shadow-slate-200/60">
            <form action="{{ route('guru.rekam-terapi.history') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-1 group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama siswa atau nomor sesi..."
                        class="w-full bg-slate-50 border-2 border-transparent focus:border-emerald-500 focus:bg-white rounded-2xl pl-14 pr-5 py-4 text-sm font-bold text-slate-700 transition-all outline-none">
                </div>
                <button type="submit" class="px-10 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-emerald-600 hover:shadow-lg hover:shadow-emerald-200 transition-all active:scale-95 py-4 md:py-0 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-filter text-[10px]"></i>
                    Filter Data
                </button>
            </form>
        </div>

        {{-- Table Container --}}
        <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl shadow-slate-200/40 overflow-hidden transition-all">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-7 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Sesi & Tanggal</th>
                            <th class="px-8 py-7 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Identitas Siswa</th>
                            <th class="px-8 py-7 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Analisis Kemajuan</th>
                            <th class="px-8 py-7 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Skor</th>
                            <th class="px-8 py-7 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Absensi</th>
                            <th class="px-8 py-7 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($riwayat as $r)
                        <tr class="hover:bg-emerald-50/20 transition-all group">
                            <td class="px-8 py-6">
                                <div class="relative pl-5 border-l-4 border-emerald-500">
                                    <span class="block text-sm font-black text-slate-900 uppercase tracking-tight">Sesi {{ $r->nomor_sesi }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                        <i class="fa-regular fa-calendar-check mr-1"></i>
                                        {{ \Carbon\Carbon::parse($r->tanggal_pelaksanaan)->translatedFormat('d F Y') }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-600 text-white rounded-2xl flex items-center justify-center font-black shadow-lg shadow-emerald-200 uppercase ring-4 ring-white">
                                        {{ substr($r->jadwal->siswa->nama_siswa, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 text-base leading-none mb-1.5">{{ $r->jadwal->siswa->nama_siswa }}</p>
                                        <p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest bg-emerald-50 px-2 py-0.5 rounded-md inline-flex items-center gap-1.5">
                                            <span class="w-1 h-1 bg-emerald-500 rounded-full animate-pulse"></span>
                                            {{ $r->jadwal->jenis_terapi }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                @php
                                    $config = match($r->hasil_kemajuan) {
                                        'Meningkat Pesat' => [
                                            'color' => 'text-emerald-700 bg-emerald-100 border-emerald-200',
                                            'icon' => 'fa-solid fa-rocket animate-bounce-slow',
                                            'bar' => 'bg-emerald-500'
                                        ],
                                        'Meningkat' => [
                                            'color' => 'text-blue-700 bg-blue-100 border-blue-200',
                                            'icon' => 'fa-solid fa-chart-line',
                                            'bar' => 'bg-blue-500'
                                        ],
                                        'Tetap' => [
                                            'color' => 'text-amber-700 bg-amber-100 border-amber-200',
                                            'icon' => 'fa-solid fa-equals',
                                            'bar' => 'bg-amber-500'
                                        ],
                                        default => [
                                            'color' => 'text-rose-700 bg-rose-100 border-rose-200',
                                            'icon' => 'fa-solid fa-arrow-trend-down',
                                            'bar' => 'bg-rose-500'
                                        ]
                                    };
                                @endphp
                                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-xl border {{ $config['color'] }} font-black text-[10px] uppercase tracking-wider shadow-sm transition-transform group-hover:scale-105">
                                    <i class="{{ $config['icon'] }}"></i>
                                    <span>{{ $r->hasil_kemajuan }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="flex flex-col items-center gap-1.5">
                                    <span class="text-xl font-black text-slate-800 leading-none tracking-tighter">{{ $r->skor_grafik }}</span>
                                    <div class="w-16 h-2 bg-slate-100 rounded-full overflow-hidden p-[2px] shadow-inner border border-slate-200/50">
                                        <div class="h-full {{ $config['bar'] }} rounded-full transition-all duration-1000 shadow-[0_0_8px_rgba(0,0,0,0.1)]" style="width: {{ $r->skor_grafik }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                @php
                                    $statusStyle = match($r->status_kehadiran) {
                                        'Hadir' => ['class' => 'text-emerald-600 bg-emerald-50 border-emerald-200', 'icon' => 'fa-circle-check'],
                                        'Izin', 'Sakit' => ['class' => 'text-amber-600 bg-amber-50 border-amber-200', 'icon' => 'fa-circle-info'],
                                        default => ['class' => 'text-rose-600 bg-rose-50 border-rose-200', 'icon' => 'fa-circle-xmark']
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-2 px-3 py-2 border-2 rounded-xl text-[10px] font-black uppercase tracking-tighter {{ $statusStyle['class'] }}">
                                    <i class="fa-solid {{ $statusStyle['icon'] }} text-[12px]"></i>
                                    {{ $r->status_kehadiran }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('guru.rekam-terapi.edit', $r->id) }}"
                                       class="p-3.5 bg-white border-2 border-slate-100 text-slate-400 hover:text-emerald-600 hover:border-emerald-500 hover:bg-emerald-50 rounded-2xl transition-all shadow-sm hover:shadow-emerald-100 active:scale-90 group/btn">
                                        <i class="fa-solid fa-pen-to-square text-lg transition-transform group-hover/btn:-rotate-12"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-32 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-36 h-36 bg-slate-50 rounded-[3.5rem] flex items-center justify-center mb-8 border-4 border-dashed border-slate-200 relative">
                                        <i class="fa-solid fa-folder-open text-6xl text-slate-200"></i>
                                        <div class="absolute -bottom-2 -right-2 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg text-slate-300">
                                            <i class="fa-solid fa-ban text-xl"></i>
                                        </div>
                                    </div>
                                    <h3 class="text-2xl font-black text-slate-800 mb-2">Data Tidak Ditemukan</h3>
                                    <p class="text-slate-400 font-medium max-w-sm mx-auto">Sistem tidak menemukan arsip terapi dengan kriteria tersebut. Coba cari kata kunci lain.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($riwayat->hasPages())
            <div class="p-8 bg-slate-50/50 border-t border-slate-100">
                {{ $riwayat->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Custom Pagination Styling */
    .pagination { @apply flex gap-2 justify-center; }
    .page-item.active .page-link { @apply bg-emerald-600 border-emerald-600 text-white rounded-2xl shadow-xl shadow-emerald-200; }
    .page-link { @apply rounded-2xl border-none bg-white text-slate-700 font-black px-5 py-3 hover:bg-emerald-50 transition-all shadow-sm; }

    /* Micro Animations */
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-5px) rotate(5deg); }
    }
    .animate-bounce-slow {
        animation: bounce-slow 2.5s infinite ease-in-out;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        @apply bg-slate-200 rounded-full hover:bg-emerald-200 transition-colors;
    }
</style>
@endsection
