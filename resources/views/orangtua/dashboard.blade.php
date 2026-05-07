@extends('orangtua.layouts.main')

@section('content')
<div class="space-y-8 pb-10">

    {{-- BARIS ATAS: ANALISIS RADAR & WIDGET KANAN --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- CARD KIRI: RADAR CHART (TETAP ADA) --}}
        <div class="lg:col-span-2 bg-white dark:bg-gray-900 p-8 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-indigo-50/50 dark:bg-indigo-900/10 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Analisis Capaian Terapi</h2>
                    <p class="text-sm text-gray-500 font-medium italic">Berdasarkan skor rata-rata mingguan</p>
                </div>
                <div class="bg-indigo-50 dark:bg-indigo-900/30 px-4 py-2 rounded-2xl">
                    <span class="text-indigo-600 dark:text-indigo-400 text-xs font-black uppercase tracking-wider">Update: {{ explode(',', $tanggal_hari_ini)[0] }}</span>
                </div>
            </div>
            
            <div class="relative h-[350px] flex justify-center">
                <canvas id="radarChart"></canvas>
            </div>
        </div>

        {{-- CARD KANAN: KALENDER & TREN KOLEKTIF (GANTI SESI TERDEKAT) --}}
        <div class="space-y-6">
            {{-- Kalender Hari Ini --}}
            <div class="group flex items-center gap-4 bg-white dark:bg-gray-900 p-6 rounded-[2rem] shadow-xl shadow-emerald-500/5 border border-emerald-50 dark:border-emerald-900/20">
                <div class="bg-emerald-600 p-4 rounded-2xl shadow-lg shadow-emerald-200 rotate-3 group-hover:rotate-0 transition-transform">
                    <i class="fa-solid fa-calendar-day text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em]">Hari Ini</p>
                    <p class="text-lg font-black text-gray-800 dark:text-gray-100">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </p>
                </div>
            </div>

            {{-- Tren Kolektif Mini --}}
            <div class="bg-white dark:bg-gray-900 p-6 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase">Grafik Kemajuan</h3>
                    <div class="flex bg-gray-100 dark:bg-gray-800 p-1 rounded-xl">
                        <button onclick="switchChart('sesi')" id="btnSesi" class="px-2 py-1 text-[8px] font-black uppercase rounded-lg transition-all bg-white shadow-sm text-emerald-600">Sesi</button>
                        <button onclick="switchChart('bulan')" id="btnBulan" class="px-2 py-1 text-[8px] font-black uppercase rounded-lg transition-all text-gray-400">Bulan</button>
                    </div>
                </div>
                <div class="h-[300px]">
                    <canvas id="globalTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- BARIS BAWAH: JADWAL HARI INI --}}
<div class="bg-white dark:bg-gray-900 rounded-[3rem] border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
    <div class="p-8 border-b border-gray-50 dark:border-gray-800 flex justify-between items-center bg-gray-50/30">
        <div>
            <h2 class="text-2xl font-black text-gray-800 dark:text-white uppercase tracking-tight">Jadwal Hari Ini</h2>
            {{-- DI SINI: Hapus italic, pakai font-medium biar lebih clear --}}
            <p class="text-sm text-gray-400 font-medium uppercase tracking-tighter">Sesi yang di jadwalkan untuk Ananda</p>
        </div>
        <a href="{{ route('orangtua.jadwal') }}" class="group flex items-center gap-2 text-sm font-black text-emerald-600 hover:text-emerald-700 transition-colors">
            LIHAT SEMUA <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>
    <div class="overflow-x-auto p-4">
        <table class="w-full text-left">
            <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                @forelse($jadwal_hari_ini as $j)
                <tr class="group">
                    <td class="px-6 py-6">
                        <div class="flex flex-col gap-1">
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Waktu Sesi</span>
                            <span class="w-fit px-4 py-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm text-emerald-600 font-black text-sm border border-emerald-50 dark:border-emerald-900/30">
                                {{ date('H:i', strtotime($j->jam_mulai)) }} - {{ date('H:i', strtotime($j->jam_selesai)) }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center font-bold text-white text-lg shadow-lg shadow-emerald-100">
                                <i class="fa-solid fa-brain"></i>
                            </div>
                            <div>
                                <p class="font-black text-gray-800 dark:text-gray-100 uppercase">{{ $j->jenis_terapi }}</p>
                                {{-- DI SINI: Nama Terapis jangan italic biar gak pusing --}}
                                <p class="text-[11px] font-bold text-gray-500">Terapis: {{ $j->guru->user->name }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-6 text-right">
                        @if($j->rekamTerapi->isNotEmpty())
                            {{-- Badge Selesai: Hapus italic --}}
                            <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 text-gray-500 text-[10px] font-black rounded-full">
                                <i class="fa-solid fa-check-double"></i> SELESAI
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-full">
                                <i class="fa-solid fa-clock"></i> MENDATANG
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center text-gray-400 font-bold">
                        <i class="fa-solid fa-calendar-xmark text-4xl mb-4 block opacity-20"></i>
                        Tidak ada jadwal sesi untuk hari ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Radar Chart (Tetap)
    const ctxRadar = document.getElementById('radarChart').getContext('2d');
    new Chart(ctxRadar, {
        type: 'radar',
        data: {
            labels: {!! json_encode($aspek_perkembangan['labels']) !!},
            datasets: [{
                label: 'Skor',
                data: {!! json_encode($aspek_perkembangan['skor']) !!},
                fill: true,
                backgroundColor: 'rgba(99, 102, 241, 0.15)',
                borderColor: '#6366f1',
                borderWidth: 3,
                pointBackgroundColor: '#fff',
                pointRadius: 4
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, scales: { r: { suggestedMin: 0, suggestedMax: 100, ticks: { display: false } } }, plugins: { legend: { display: false } } }
    });

    // 2. Line Chart (Tren Kolektif)
    const ctxLine = document.getElementById('globalTrendChart').getContext('2d');
    const dataSesi = { labels: @json($chartSesiLabels), values: @json($chartSesiValues) };
    const dataBulan = { labels: @json($chartBulanLabels), values: @json($chartBulanValues) };

    let globalTrendChart = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: dataSesi.labels,
            datasets: [{
                data: dataSesi.values,
                borderColor: '#10B981',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                pointRadius: 2
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false, 
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, max: 100, ticks: { font: { size: 8 } } }, x: { ticks: { font: { size: 8 } } } }
        }
    });

    function switchChart(type) {
        const btnSesi = document.getElementById('btnSesi');
        const btnBulan = document.getElementById('btnBulan');
        if (type === 'sesi') {
            globalTrendChart.data.labels = dataSesi.labels;
            globalTrendChart.data.datasets[0].data = dataSesi.values;
            btnSesi.classList.add('bg-white', 'shadow-sm', 'text-emerald-600');
            btnBulan.classList.remove('bg-white', 'shadow-sm', 'text-emerald-600');
        } else {
            globalTrendChart.data.labels = dataBulan.labels;
            globalTrendChart.data.datasets[0].data = dataBulan.values;
            btnBulan.classList.add('bg-white', 'shadow-sm', 'text-emerald-600');
            btnSesi.classList.remove('bg-white', 'shadow-sm', 'text-emerald-600');
        }
        globalTrendChart.update();
    }
</script>
@endpush
@endsection