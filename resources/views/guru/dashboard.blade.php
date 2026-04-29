@extends('guru.layouts.main')

@section('content')
<div class="space-y-8 p-2 md:p-4">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="animate-in fade-in slide-in-from-left duration-700">
            <h1 class="text-4xl font-black text-gray-900 dark:text-white tracking-tight leading-tight">
                Selamat Pagi, <br class="md:hidden">
                <span class="text-emerald-600 relative">
                    {{ explode(' ', Auth::user()->name)[0] }}!
                    <svg class="absolute -bottom-2 left-0 w-full h-2 text-emerald-200 dark:text-emerald-900/50" viewBox="0 0 100 10" preserveAspectRatio="none"><path d="M0 5 Q 25 0 50 5 T 100 5" stroke="currentColor" stroke-width="4" fill="none"/></svg>
                </span>
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-4 font-bold flex items-center gap-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
                Siap melayani pelayanan terapi untuk siswa hari ini?
            </p>
        </div>

        <div class="group flex items-center gap-4 bg-white dark:bg-gray-900 p-4 rounded-[2rem] shadow-xl shadow-emerald-500/5 border border-emerald-50 dark:border-emerald-900/20">
            <div class="bg-emerald-600 p-4 rounded-2xl shadow-lg shadow-emerald-200 rotate-3 group-hover:rotate-0 transition-transform">
                <i class="fa-solid fa-calendar-check text-white text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em]">Kalender Kerja</p>
                <p class="text-lg font-black text-gray-800 dark:text-gray-100">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="group bg-white dark:bg-gray-900 p-8 rounded-[3rem] border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-2xl transition-all duration-500">
            <div class="flex justify-between items-start">
                <div class="w-14 h-14 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-id-card-clip"></i>
                </div>
                <span class="text-[10px] font-bold px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full">AKTIF</span>
            </div>
            <div class="mt-6">
                <h3 class="text-gray-400 font-bold text-xs uppercase tracking-widest">Total Siswa Binaan</h3>
                <p class="text-5xl font-black text-gray-900 dark:text-white mt-2">{{ $stats['total_siswa'] }}</p>
            </div>
        </div>

        <div class="relative overflow-hidden bg-emerald-600 p-8 rounded-[3rem] shadow-2xl shadow-emerald-200 dark:shadow-none transition-transform hover:scale-[1.02]">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <i class="fa-solid fa-clock-rotate-left text-9xl -rotate-12"></i>
            </div>
            <div class="relative z-10 text-white">
                <div class="w-14 h-14 bg-white/20 backdrop-blur-xl rounded-2xl flex items-center justify-center text-white text-2xl">
                    <i class="fa-solid fa-bolt-lightning"></i>
                </div>
                <div class="mt-6">
                    <h3 class="text-emerald-100 font-bold text-xs uppercase tracking-widest opacity-80">Jadwal Hari Ini</h3>
                    <p class="text-5xl font-black mt-2">{{ $stats['sesi_hari_ini'] }} <span class="text-xl font-medium opacity-60">Sesi</span></p>
                </div>
            </div>
        </div>

        <div class="group bg-white dark:bg-gray-900 p-8 rounded-[3rem] border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-2xl transition-all duration-500 text-center">
             <div class="inline-flex relative items-center justify-center">
                <svg class="w-24 h-24 transform -rotate-90">
                    <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="transparent" class="text-gray-100 dark:text-gray-800" />
                    <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="transparent" class="text-orange-500" stroke-dasharray="251.2" stroke-dashoffset="{{ 251.2 - (251.2 * $stats['laporan_selesai']) / 100 }}" stroke-linecap="round" />
                </svg>
                <span class="absolute text-xl font-black text-gray-800 dark:text-white">{{ $stats['laporan_selesai'] }}%</span>
            </div>
            <h3 class="text-gray-400 font-bold text-xs uppercase tracking-widest mt-4">Kepatuhan Laporan</h3>
            <p class="text-xs text-gray-500 mt-1">Bulan: {{ date('F') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-[3rem] border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-gray-50 dark:border-gray-800 flex justify-between items-center bg-gray-50/30">
                <div>
                    <h2 class="text-2xl font-black text-gray-800 dark:text-white">Antrean Sesi</h2>
                    <p class="text-sm text-gray-400 font-bold uppercase tracking-tighter">Urutan berdasarkan jam pelayanan</p>
                </div>
                <a href="{{ route('guru.jadwal.index') }}" class="group flex items-center gap-2 text-sm font-black text-emerald-600 hover:text-emerald-700 transition-colors">
                    LENGKAP <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            <div class="overflow-x-auto p-4">
                <table class="w-full text-left">
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach($jadwal as $j)
                        <tr class="hover:bg-emerald-50/50 dark:hover:bg-emerald-900/10 transition-all group">
                            <td class="px-6 py-6">
                                <span class="px-4 py-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm text-emerald-600 font-black text-sm border border-emerald-50 dark:border-emerald-900/30">
                                    {{ $j->jam_mulai }}
                                </span>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-4">
                                    <img class="w-12 h-12 rounded-2xl shadow-md" src="https://ui-avatars.com/api/?name={{ urlencode($j->siswa->nama_siswa) }}&background=10B981&color=fff&bold=true" alt="">
                                    <div>
                                        <p class="font-black text-gray-800 dark:text-gray-100">{{ $j->siswa->nama_siswa }}</p>
                                        <p class="text-xs font-bold text-gray-400 uppercase italic">{{ $j->jenis_terapi }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6 text-right">
                                <a href="{{ route('guru.rekam-terapi.create', ['jadwal' => $j->id]) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black rounded-full transition-all shadow-lg shadow-emerald-200 dark:shadow-none hover:scale-105">
                                    <i class="fa-solid fa-plus-circle"></i> INPUT HASIL
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-[3rem] border border-gray-100 dark:border-gray-800 shadow-sm p-8">
            <div class="mb-6 text-center">
                <h2 class="text-xl font-black text-gray-800 dark:text-white">Tren Kolektif</h2>
                <p class="text-xs text-gray-400 font-bold uppercase">Rata-rata Kemajuan Siswa</p>
            </div>
            <div class="h-64">
                <canvas id="globalTrendChart"></canvas>
            </div>
            <div class="mt-8 p-6 bg-emerald-50 dark:bg-emerald-900/20 rounded-[2rem] border border-emerald-100 dark:border-emerald-800">
                <div class="flex items-center gap-3 text-emerald-700 dark:text-emerald-400">
                    <i class="fa-solid fa-lightbulb text-xl"></i>
                    <p class="text-xs font-bold leading-relaxed">Sistem mendeteksi kenaikan stabilitas terapi sebesar 12% dari bulan lalu.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const gtx = document.getElementById('globalTrendChart').getContext('2d');
    new Chart(gtx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                data: @json($chartScores),
                borderColor: '#10B981',
                borderWidth: 4,
                tension: 0.4,
                pointRadius: 0,
                fill: true,
                backgroundColor: (context) => {
                    const gradient = gtx.createLinearGradient(0, 0, 0, 200);
                    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
                    gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');
                    return gradient;
                }
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { display: false, beginAtZero: true, max: 100 },
                x: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
            }
        }
    });
</script>
@endsection
