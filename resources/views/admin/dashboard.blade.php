@extends('admin.layouts.main')

@section('content')
<div class="relative overflow-hidden mb-8 p-8 md:p-12 bg-white border border-gray-100 rounded-[2.5rem] shadow-sm dark:bg-gray-900 dark:border-gray-800 transition-all duration-300 group">

<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <div class="group p-6 bg-white border border-gray-100 rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-300 dark:bg-gray-900 dark:border-gray-800">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-1">Total Siswa</p>
                <h3 class="text-3xl font-black text-gray-900 dark:text-white">{{ $total_siswa }}</h3>
            </div>
            <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl dark:bg-blue-900/20 dark:text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                <i class="fa-solid fa-user-graduate text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-[10px] font-bold text-green-500 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-lg w-fit">
            AKTIF TERDAFTAR
        </div>
    </div>

    <div class="group p-6 bg-white border border-gray-100 rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-300 dark:bg-gray-900 dark:border-gray-800">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-1">Guru Terapis</p>
                <h3 class="text-3xl font-black text-gray-900 dark:text-white">{{ $total_terapis }}</h3>
            </div>
            <div class="p-4 bg-purple-50 text-purple-600 rounded-2xl dark:bg-purple-900/20 dark:text-purple-400 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300">
                <i class="fa-solid fa-user-doctor text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-[10px] font-bold text-purple-500 bg-purple-50 dark:bg-purple-900/20 px-2 py-1 rounded-lg w-fit uppercase">
            Staf Ahli
        </div>
    </div>

    <div class="group p-6 bg-white border border-gray-100 rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-300 dark:bg-gray-900 dark:border-gray-800">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-1">Sesi Hari Ini</p>
                <h3 class="text-3xl font-black text-gray-900 dark:text-white">{{ $jadwal_hari_ini }}</h3>
            </div>
            <div class="p-4 bg-yellow-50 text-yellow-600 rounded-2xl dark:bg-yellow-900/20 dark:text-yellow-400 group-hover:bg-yellow-500 group-hover:text-white transition-all duration-300">
                <i class="fa-solid fa-calendar-check text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-[10px] font-bold text-yellow-600 bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1 rounded-lg w-fit uppercase tracking-widest italic">
            Running Now
        </div>
    </div>

    <div class="group p-6 bg-white border border-gray-100 rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-300 dark:bg-gray-900 dark:border-gray-800">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-1">Laporan Baru</p>
                <h3 class="text-3xl font-black text-gray-900 dark:text-white">{{ $laporan_baru }}</h3>
            </div>
            <div class="p-4 bg-green-50 text-green-600 rounded-2xl dark:bg-green-900/20 dark:text-green-400 group-hover:bg-green-600 group-hover:text-white transition-all duration-300">
                <i class="fa-solid fa-file-waveform text-xl"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-[10px] font-bold text-green-600 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-lg w-fit">
            <span class="animate-pulse mr-1 inline-block w-2 h-2 bg-green-500 rounded-full"></span> NEED REVIEW
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 bg-white dark:bg-gray-900 p-8 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-xl font-black text-gray-900 dark:text-white tracking-tight">Rata-rata Perkembangan Siswa</h2>
                <p class="text-sm text-gray-500 font-medium">Data akumulasi seluruh jenis terapi (2026)</p>
            </div>
            <div class="flex gap-2">
                <button class="px-4 py-2 text-xs font-bold bg-blue-50 dark:bg-blue-900/30 text-blue-600 rounded-xl">Bulanan</button>
                <button class="px-4 py-2 text-xs font-bold text-gray-400 hover:text-gray-600">Tahunan</button>
            </div>
        </div>
        <div class="relative h-[300px]">
            <canvas id="developmentChart"></canvas>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 p-8 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm">
        <h2 class="text-xl font-black text-gray-900 dark:text-white mb-6 tracking-tight">Log Aktivitas Terbaru</h2>
        <div class="space-y-6">
            @for ($i = 1; $i <= 4; $i++)
            <div class="flex items-center gap-4 group cursor-pointer">
                <div class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-gray-800 flex items-center justify-center group-hover:bg-blue-50 transition-colors">
                    <i class="fa-solid fa-circle-dot text-[8px] text-blue-500"></i>
                </div>
                <div class="flex-grow">
                    <p class="text-sm font-bold text-gray-800 dark:text-gray-200">Guru Budi menginput laporan</p>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Siswa: Siti A. • 10 Menit lalu</p>
                </div>
            </div>
            @endfor
        </div>
        <button class="w-full mt-8 py-4 border-2 border-dashed border-gray-100 dark:border-gray-800 rounded-2xl text-sm font-bold text-gray-400 hover:border-blue-200 hover:text-blue-500 transition-all">
            Lihat Semua Aktivitas
        </button>
    </div>
</div>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    .animate-float { animation: float 6s ease-in-out infinite; }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('developmentChart').getContext('2d');
    
    // Gradient Background
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
    gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chart_labels) !!},
            datasets: [{
                label: 'Tingkat Perkembangan (%)',
                data: {!! json_encode($chart_data) !!},
                borderColor: '#2563eb',
                borderWidth: 4,
                fill: true,
                backgroundColor: gradient,
                tension: 0.4, // Membuat garis melengkung premium
                pointBackgroundColor: '#fff',
                pointBorderColor: '#2563eb',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { display: false },
                    ticks: { font: { weight: '600' } }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { weight: '600' } }
                }
            }
        }
    });
</script>
@endpush
@endsection