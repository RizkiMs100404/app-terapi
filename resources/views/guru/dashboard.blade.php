@extends('guru.layouts.main')

@section('content')
@php
    // Logika Ucapan Waktu Dinamis
    $hour = date('H');
    $ucapan = 'Selamat Malam';
    if ($hour >= 5 && $hour < 11) $ucapan = 'Selamat Pagi';
    elseif ($hour >= 11 && $hour < 15) $ucapan = 'Selamat Siang';
    elseif ($hour >= 15 && $hour < 18) $ucapan = 'Selamat Sore';
@endphp

<div class="space-y-8 p-2 md:p-4">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="animate-in fade-in slide-in-from-left duration-700">
            <h1 class="text-4xl font-black text-gray-900 dark:text-white tracking-tight leading-tight">
                {{ $ucapan }}, <br class="md:hidden">
                <span class="text-emerald-600 relative">
                    {{-- Perbaikan: Menampilkan nama lengkap --}}
                    {{ Auth::user()->name }}! 
                    <svg class="absolute -bottom-2 left-0 w-full h-2 text-emerald-200 dark:text-emerald-900/50" viewBox="0 0 100 10" preserveAspectRatio="none"><path d="M0 5 Q 25 0 50 5 T 100 5" stroke="currentColor" stroke-width="4" fill="none"/></svg>
                </span>
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-4 font-bold flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
                Siap melayani pelayanan terapi untuk siswa hari ini?
            </p>
        </div>

        {{-- Kalender Hari Ini --}}
        <div class="group flex items-center gap-4 bg-white dark:bg-gray-900 p-4 rounded-[2rem] shadow-xl shadow-emerald-500/5 border border-emerald-50 dark:border-emerald-900/20">
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
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Card: Total Siswa --}}
        <div class="group bg-white dark:bg-gray-900 p-8 rounded-[3rem] border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-2xl transition-all duration-500">
            <div class="flex justify-between items-start">
                <div class="w-14 h-14 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-id-card-clip"></i>
                </div>
                <span class="text-[10px] font-bold px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full uppercase">Monitoring</span>
            </div>
            <div class="mt-6">
                <h3 class="text-gray-400 font-bold text-xs uppercase tracking-widest">Siswa Binaan</h3>
                <p class="text-5xl font-black text-gray-900 dark:text-white mt-2">{{ $stats['total_siswa'] }}</p>
            </div>
        </div>

        {{-- Card: Sesi Hari Ini --}}
        <div class="relative overflow-hidden bg-emerald-600 p-8 rounded-[3rem] shadow-2xl shadow-emerald-200 dark:shadow-none transition-transform hover:scale-[1.02]">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <i class="fa-solid fa-clock-rotate-left text-9xl -rotate-12"></i>
            </div>
            <div class="relative z-10 text-white">
                <div class="w-14 h-14 bg-white/20 backdrop-blur-xl rounded-2xl flex items-center justify-center text-white text-2xl">
                    <i class="fa-solid fa-bolt-lightning"></i>
                </div>
                <div class="mt-6">
                    <h3 class="text-emerald-100 font-bold text-xs uppercase tracking-widest opacity-80">Sesi Hari Ini</h3>
                    <p class="text-5xl font-black mt-2">{{ $stats['sesi_hari_ini'] }} <span class="text-xl font-medium opacity-60">Sesi</span></p>
                </div>
            </div>
        </div>

        {{-- Card: Kepatuhan Laporan --}}
        <div class="group bg-white dark:bg-gray-900 p-8 rounded-[3rem] border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-2xl transition-all duration-500 text-center">
             <div class="inline-flex relative items-center justify-center">
                <svg class="w-24 h-24 transform -rotate-90">
                    <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="transparent" class="text-gray-100 dark:text-gray-800" />
                    <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="transparent" class="text-orange-500" stroke-dasharray="251.2" stroke-dashoffset="{{ 251.2 - (251.2 * $stats['laporan_selesai']) / 100 }}" stroke-linecap="round" />
                </svg>
                <span class="absolute text-xl font-black text-gray-800 dark:text-white">{{ $stats['laporan_selesai'] }}%</span>
            </div>
            <h3 class="text-gray-400 font-bold text-xs uppercase tracking-widest mt-4">Kepatuhan Laporan</h3>
            <p class="text-xs text-gray-500 mt-1">Status pelaporan bulan ini</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Antrean Sesi --}}
<div class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-[3rem] border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
    <div class="p-8 border-b border-gray-50 dark:border-gray-800 flex justify-between items-center bg-gray-50/30">
        <div>
            <h2 class="text-2xl font-black text-gray-800 dark:text-white">Antrean Sesi</h2>
            <p class="text-sm text-gray-400 font-bold uppercase tracking-tighter italic">Urutan pelayanan hari ini</p>
        </div>
        <a href="{{ route('guru.jadwal.index') }}" class="group flex items-center gap-2 text-sm font-black text-emerald-600 hover:text-emerald-700 transition-colors">
            LIHAT JADWAL <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>
    <div class="overflow-x-auto p-4 custom-scrollbar">
        <table class="w-full text-left">
            <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                @forelse($jadwal as $j)
                <tr class="hover:bg-emerald-50/50 dark:hover:bg-emerald-900/10 transition-all group">
                    <td class="px-6 py-6">
                        <div class="flex flex-col gap-1">
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Jadwal Mulai</span>
                            <span class="w-fit px-4 py-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm text-emerald-600 font-black text-sm border border-emerald-50 dark:border-emerald-900/30">
                                {{ $j->jam_mulai }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-6">
                        <div class="flex items-center gap-4">
                            {{-- Container Foto Siswa --}}
                            <div class="w-12 h-12 rounded-2xl overflow-hidden shadow-md border-2 border-white dark:border-gray-700 flex-shrink-0">
                                @if($j->siswa->foto && Storage::disk('public')->exists('foto_siswa/' . $j->siswa->foto))
                                    <img src="{{ asset('storage/foto_siswa/' . $j->siswa->foto) }}" 
                                        alt="Foto {{ $j->siswa->nama_siswa }}" 
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-emerald-600 flex items-center justify-center font-bold text-white text-sm uppercase">
                                        {{ substr($j->siswa->nama_siswa, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            
                            <div>
                                <p class="font-black text-gray-800 dark:text-gray-100 line-clamp-1">{{ $j->siswa->nama_siswa }}</p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-[10px] font-black text-emerald-500 uppercase tracking-tighter">{{ $j->jenis_terapi }}</span>
                                    <span class="text-[10px] text-gray-300">•</span>
                                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-tighter italic">
                                        {{ $j->siswa->tingkat }} — Kelas {{ $j->siswa->kelas }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-6 text-right">
                        {{-- Logika Status Sesi --}}
                        @if($j->status_sesi == 'selesai')
                            <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 text-gray-500 text-[10px] font-black rounded-full italic">
                                <i class="fa-solid fa-check-double"></i> TERLAKSANA
                            </span>
                        @else
                            <a href="{{ route('guru.rekam-terapi.create', ['id_jadwal' => $j->id]) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black rounded-full transition-all shadow-lg shadow-emerald-200 dark:shadow-none hover:scale-105 active:scale-95">
                                <i class="fa-solid fa-plus-circle"></i> INPUT HASIL
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center text-gray-400 font-bold italic">
                        <i class="fa-solid fa-mug-hot text-4xl mb-4 block opacity-20"></i>
                        Tidak ada antrean sesi untuk hari ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

       {{-- Tren Kolektif (Chart) --}}
<div class="bg-white dark:bg-gray-900 rounded-[3rem] border border-gray-100 dark:border-gray-800 shadow-sm p-8 flex flex-col">
    <div class="mb-6 flex justify-between items-center">
        <div class="text-left">
            <h2 class="text-xl font-black text-gray-800 dark:text-white">Tren Kolektif</h2>
            <p id="chartSubtitle" class="text-xs text-gray-400 font-bold uppercase tracking-widest">Rata-rata 10 Sesi Terakhir</p>
        </div>
        
        <!-- Toggle Switch Grafik -->
        <div class="flex bg-gray-100 dark:bg-gray-800 p-1 rounded-2xl">
            <button onclick="switchChart('sesi')" id="btnSesi" class="px-4 py-2 text-[10px] font-black uppercase rounded-xl transition-all duration-300 bg-white dark:bg-gray-700 shadow-sm text-emerald-600">Sesi</button>
            <button onclick="switchChart('bulan')" id="btnBulan" class="px-4 py-2 text-[10px] font-black uppercase rounded-xl transition-all duration-300 text-gray-400 hover:text-gray-600">Bulanan</button>
        </div>
    </div>
    
    <div class="flex-grow min-h-[250px]">
        <canvas id="globalTrendChart"></canvas>
    </div>

    <!-- Box Analisis Dinamis -->
    <div class="mt-8 p-6 {{ $stats['tren_naik'] ? 'bg-emerald-50 dark:bg-emerald-900/20 border-emerald-100' : 'bg-rose-50 dark:bg-rose-900/20 border-rose-100' }} rounded-[2rem] border">
        <div class="flex items-start gap-3 {{ $stats['tren_naik'] ? 'text-emerald-700 dark:text-emerald-400' : 'text-rose-700 dark:text-rose-400' }}">
            <i class="fa-solid {{ $stats['tren_naik'] ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }} text-xl mt-1"></i>
            <div>
                <p class="text-xs font-black uppercase mb-1">Analisis Sistem</p>
                <p class="text-[11px] font-bold leading-relaxed opacity-80">
                    Sistem mendeteksi 
                    <span class="underline decoration-2 font-black">{{ $stats['tren_naik'] ? 'Kenaikan' : 'Penurunan' }}</span> 
                    stabilitas terapi sebesar <span class="font-black">{{ $stats['analisis_persen'] }}%</span> 
                    ({{ $stats['analisis_selisih'] }} poin) dibanding bulan lalu.
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const gtx = document.getElementById('globalTrendChart').getContext('2d');
    
    // Data dari Laravel
    const dataSesi = {
        labels: @json($chartSesiLabels),
        values: @json($chartSesiValues),
        subtitle: "Rata-rata 10 Sesi Terakhir"
    };

    const dataBulan = {
        labels: @json($chartBulanLabels),
        values: @json($chartBulanValues),
        subtitle: "Progress Rata-rata 6 Bulan Terakhir"
    };

    // Plugin untuk Garis Vertikal saat Hover
    const verticalLinePlugin = {
        id: 'verticalLine',
        afterDraw: chart => {
            if (chart.tooltip?._active?.length) {
                let x = chart.tooltip._active[0].element.x;
                let yAxis = chart.scales.y;
                let ctx = chart.ctx;
                ctx.save();
                ctx.beginPath();
                ctx.setLineDash([5, 5]);
                ctx.moveTo(x, yAxis.top);
                ctx.lineTo(x, yAxis.bottom);
                ctx.lineWidth = 1.5;
                ctx.strokeStyle = 'rgba(16, 185, 129, 0.4)';
                ctx.stroke();
                ctx.restore();
            }
        }
    };

    // Inisialisasi Chart (Default: Sesi)
    let globalTrendChart = new Chart(gtx, {
        type: 'line',
        plugins: [verticalLinePlugin],
        data: {
            labels: dataSesi.labels,
            datasets: [{
                data: dataSesi.values,
                borderColor: '#10B981',
                borderWidth: 4,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#10B981',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                backgroundColor: (context) => {
                    const gradient = gtx.createLinearGradient(0, 0, 0, 250);
                    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.25)');
                    gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');
                    return gradient;
                }
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    displayColors: false,
                    titleFont: { size: 10, weight: 'bold' },
                    bodyFont: { size: 13, weight: '900' },
                    callbacks: { label: (c) => ` Skor: ${c.parsed.y}` }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    max: 100,
                    grid: { color: 'rgba(241, 245, 249, 0.5)' },
                    ticks: { color: '#94a3b8', font: { size: 10, weight: 'bold' } }
                },
                x: { 
                    grid: { display: false }, 
                    ticks: { color: '#94a3b8', font: { size: 10, weight: 'bold' } } 
                }
            }
        }
    });

    // Fungsi Switch Grafik
    function switchChart(type) {
        const btnSesi = document.getElementById('btnSesi');
        const btnBulan = document.getElementById('btnBulan');
        const subtitle = document.getElementById('chartSubtitle');

        if (type === 'sesi') {
            globalTrendChart.data.labels = dataSesi.labels;
            globalTrendChart.data.datasets[0].data = dataSesi.values;
            subtitle.innerText = dataSesi.subtitle;
            
            // UI Toggle
            btnSesi.classList.add('bg-white', 'dark:bg-gray-700', 'shadow-sm', 'text-emerald-600');
            btnSesi.classList.remove('text-gray-400');
            btnBulan.classList.remove('bg-white', 'dark:bg-gray-700', 'shadow-sm', 'text-emerald-600');
            btnBulan.classList.add('text-gray-400');
        } else {
            globalTrendChart.data.labels = dataBulan.labels;
            globalTrendChart.data.datasets[0].data = dataBulan.values;
            subtitle.innerText = dataBulan.subtitle;

            // UI Toggle
            btnBulan.classList.add('bg-white', 'dark:bg-gray-700', 'shadow-sm', 'text-emerald-600');
            btnBulan.classList.remove('text-gray-400');
            btnSesi.classList.remove('bg-white', 'dark:bg-gray-700', 'shadow-sm', 'text-emerald-600');
            btnSesi.classList.add('text-gray-400');
        }
        globalTrendChart.update();
    }
</script>
@endsection