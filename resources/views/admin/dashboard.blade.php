@extends('admin.layouts.main')

@section('content')
<div class="min-h-screen bg-[#F8FAFC] p-4 md:p-8">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">Dashboard <span class="text-blue-600">Admin</span></h1>
            <p class="text-slate-500 mt-1 flex items-center gap-2">
                <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Monitoring real-time tumbuh kembang siswa
            </p>
        </div>
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-3 bg-white p-3 rounded-2xl shadow-sm border border-slate-100">
                <div class="h-10 w-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Hari Ini</p>
                    <p class="text-sm font-bold text-slate-700">{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        {{-- Card Stat 1 --}}
        <div class="group bg-white rounded-[2rem] p-7 shadow-sm border border-slate-100 relative overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <p class="text-slate-500 font-medium mb-1">Total Siswa</p>
                <h3 class="text-4xl font-black text-slate-800">{{ $jumlahSiswa }}</h3>
                <div class="mt-4 flex items-center text-blue-600 text-[11px] font-bold uppercase tracking-wider">
                    <span class="bg-blue-100 px-2 py-1 rounded-lg mr-2">Aktif</span>
                    <span>Anak Berkebutuhan Khusus</span>
                </div>
            </div>
        </div>

        {{-- Card Stat 2 --}}
        <div class="group bg-white rounded-[2rem] p-7 shadow-sm border border-slate-100 relative overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <p class="text-slate-500 font-medium mb-1">Guru Pelaksana</p>
                <h3 class="text-4xl font-black text-slate-800">{{ $jumlahGuru }}</h3>
                <div class="mt-4 flex items-center text-emerald-600 text-[11px] font-bold uppercase tracking-wider">
                    <span class="bg-emerald-100 px-2 py-1 rounded-lg mr-2">Expert</span>
                    <span>Terapis Bersertifikasi</span>
                </div>
            </div>
        </div>

        {{-- Card Stat 3 --}}
        <div class="group bg-white rounded-[2rem] p-7 shadow-sm border border-slate-100 relative overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <p class="text-slate-500 font-medium mb-1">Sesi Terlaksana</p>
                <h3 class="text-4xl font-black text-slate-800">{{ $totalSesi }}</h3>
                <div class="mt-4 flex items-center text-purple-600 text-[11px] font-bold uppercase tracking-wider">
                    <span class="bg-purple-100 px-2 py-1 rounded-lg mr-2">Update</span>
                    <span>Total Rekapitulasi Sesi</span>
                </div>
            </div>
        </div>

       {{-- Card Stat 4 (Sesi Menunggu) --}}
<div class="group bg-white rounded-[2rem] p-7 shadow-sm border border-slate-100 relative overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
    <div class="absolute -right-4 -top-4 w-24 h-24 bg-amber-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
    <div class="relative z-10">
        <p class="text-slate-500 font-medium mb-1">Sesi Belom Terlaksana</p>
        <h3 class="text-4xl font-black text-slate-800">{{ $sesiBelumTerlaksana }}</h3>
        <div class="mt-4 flex items-center text-amber-600 text-[11px] font-bold uppercase tracking-wider">
            <span class="bg-amber-100 px-2 py-1 rounded-lg mr-2">Antrean</span>
            <span>Jadwal Hari Ini</span>
        </div>
    </div>
</div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Chart Section --}}
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">Grafik Perkembangan Siswa</h2>
                    <p class="text-sm text-slate-400 font-medium">Analisis efektivitas terapi periode ini</p>
                </div>
                {{-- Toggle Filter --}}
                <div class="flex p-1.5 bg-slate-100 rounded-2xl w-full sm:w-auto">
                    <button onclick="updateChartType('sesi')" id="btn-sesi" class="chart-toggle-btn active flex-1 sm:flex-none px-4 py-2 rounded-xl text-xs font-bold transition-all">
                        Per Sesi
                    </button>
                    <button onclick="updateChartType('bulanan')" id="btn-bulanan" class="chart-toggle-btn flex-1 sm:flex-none px-4 py-2 rounded-xl text-xs font-bold transition-all text-slate-500 hover:text-slate-700">
                        Bulanan
                    </button>
                </div>
            </div>
            <div class="relative h-[380px] w-full">
                <canvas id="developmentChart"></canvas>
            </div>
        </div>

        {{-- Queue Section --}}
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 flex flex-col">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">Jadwal Hari Ini</h2>
                <span class="bg-indigo-50 text-indigo-600 text-[10px] font-black px-2 py-1 rounded-lg uppercase">{{ count($jadwalHariIni) }} Sesi</span>
            </div>

            <div class="space-y-4 flex-1 overflow-y-auto pr-2 custom-scrollbar" style="max-height: 400px;">
                @forelse($jadwalHariIni as $j)
                <div class="group relative bg-slate-50 hover:bg-white border border-transparent hover:border-indigo-100 p-4 rounded-[1.5rem] transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/5">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center font-bold text-white shadow-md">
                                    {{ substr($j->siswa->nama_siswa, 0, 1) }}
                                </div>
                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></div>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm group-hover:text-indigo-600 transition-colors">{{ $j->siswa->nama_siswa }}</h4>
                                <div class="flex flex-col gap-0.5 mt-1">
                                    <span class="text-[11px] text-slate-500 flex items-center gap-1">
                                        <i class="far fa-clock text-indigo-400"></i> {{ $j->jam_mulai }} WIB
                                    </span>
                                    <span class="text-[11px] text-slate-500 font-medium">
                                        {{ $j->jenis_terapi }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <span class="text-[9px] font-black uppercase tracking-tighter bg-white border border-slate-200 px-2 py-1 rounded-lg text-slate-600">
                                {{ $j->ruang_terapi ?? 'R. Umum' }}
                            </span>
                            <button class="opacity-0 group-hover:opacity-100 transition-opacity p-1.5 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white">
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-calendar-day text-slate-200 text-3xl"></i>
                    </div>
                    <p class="text-slate-400 font-medium text-sm italic">Jadwal masih kosong</p>
                </div>
                @endforelse
            </div>

            <div class="mt-6">
                <a href="{{ url('admin/jadwal-terapi') }}"
                   class="group/btn w-full py-4 bg-slate-900 hover:bg-indigo-600 text-white text-xs font-bold rounded-2xl transition-all duration-300 flex items-center justify-center gap-3 shadow-lg shadow-slate-200 hover:shadow-indigo-200 overflow-hidden relative">
                    {{-- Efek Cahaya Running (Glass Effect) --}}
                    <div class="absolute inset-0 w-1/2 h-full bg-gradient-to-r from-transparent via-white/10 to-transparent -skew-x-[20deg] group-hover/btn:animate-[shimmer_1.5s_infinite] -left-full"></div>

                    <span class="relative z-10">Lihat Semua Jadwal</span>
                    <i class="fas fa-arrow-right text-[10px] group-hover/btn:translate-x-1 transition-transform relative z-10"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animasi shimmer dan scrollbar tetap dipertahankan */
    @keyframes shimmer {
        100% { left: 150%; }
    }
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #CBD5E1; }

    /* Toggle Button Theme: Indigo */
    .chart-toggle-btn {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .chart-toggle-btn.active {
        background-color: white !important;
        color: #4f46e5 !important; /* Indigo 600 */
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.1), 0 2px 4px -1px rgba(79, 70, 229, 0.06) !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('developmentChart').getContext('2d');
    let currentChart;

    // Data dari Controller
    const dataSesi = {
        labels: {!! json_encode($chartSesiLabels) !!},
        values: {!! json_encode($chartSesiValues) !!}
    };

    const dataBulanan = {
        labels: {!! json_encode($chartBulanLabels) !!},
        values: {!! json_encode($chartBulanValues) !!}
    };

    function initChart(labels, data) {
        if (currentChart) currentChart.destroy();

        // Gradient Indigo Premium
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)'); // Indigo 600
        gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

        currentChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Skor Rata-rata',
                    data: data,
                    borderColor: '#4f46e5', // Indigo 600
                    borderWidth: 3,
                    fill: true,
                    backgroundColor: gradient,
                    tension: 0.4,
                    // Styling Point (Titik)
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#4f46e5',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: '#4f46e5',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                animation: {
                    duration: 800,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 13, weight: '700' },
                        bodyFont: { size: 12 },
                        displayColors: false,
                        callbacks: {
                            label: (context) => ` Skor: ${context.parsed.y}`
                        }
                    }
                },
                scales: {
                    y: {
                        min: 0,
                        max: 100,
                        grid: {
                            display: true,
                            color: '#f1f5f9', // Garis horizontal halus
                            drawBorder: false,
                        },
                        ticks: {
                            stepSize: 20,
                            color: '#94a3b8',
                            font: { family: 'Inter', weight: '500' }
                        }
                    },
                    x: {
                        grid: {
                            display: true, // Garis vertikal diaktifkan biar keren
                            color: '#f8fafc', 
                            drawBorder: false,
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: { family: 'Inter', weight: '500' }
                        }
                    }
                }
            }
        });
    }

    function updateChartType(type) {
        document.querySelectorAll('.chart-toggle-btn').forEach(btn => {
            btn.classList.remove('active', 'text-indigo-600');
            btn.classList.add('text-slate-500');
        });

        const activeBtn = document.getElementById('btn-' + type);
        activeBtn.classList.add('active');
        activeBtn.classList.remove('text-slate-500');

        if(type === 'sesi') {
            initChart(dataSesi.labels, dataSesi.values);
        } else {
            initChart(dataBulanan.labels, dataBulanan.values);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        initChart(dataSesi.labels, dataSesi.values);
    });
</script>

<style>
    /* Tambahan agar toggle tombol terlihat lebih "clickable" */
    .chart-toggle-btn {
        transition: all 0.3s ease;
    }
    .chart-toggle-btn.active {
        color: #059669 !important; /* Emerald 600 */
    }
</style>
@endsection
