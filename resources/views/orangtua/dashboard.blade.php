@extends('orangtua.layouts.main')

@section('content')
<div class="space-y-8 pb-10">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-white dark:bg-gray-900 p-8 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-xl font-black text-gray-900 dark:text-white">Analisis Perkembangan</h2>
                    <p class="text-sm text-gray-500 font-medium italic">Data berdasarkan evaluasi terapis</p>
                </div>
                <div class="bg-indigo-50 dark:bg-indigo-900/30 px-4 py-2 rounded-2xl">
                    <span class="text-indigo-600 dark:text-indigo-400 text-xs font-black uppercase tracking-wider">Update: Hari Ini</span>
                </div>
            </div>
            
            <div class="relative h-[350px] flex justify-center">
                <canvas id="radarChart"></canvas>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-900 p-8 rounded-[2.5rem] border-l-8 border-indigo-600 shadow-sm">
                <p class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-4">Sesi Selanjutnya</p>
                <div class="flex items-center gap-4">
                    <div class="bg-indigo-50 dark:bg-indigo-900/40 p-4 rounded-2xl text-center">
                        <p class="text-[10px] font-bold text-indigo-400 uppercase leading-none">Apr</p>
                        <p class="text-2xl font-black text-indigo-600 dark:text-indigo-400 leading-none mt-1">24</p>
                    </div>
                    <div>
                        <h4 class="font-black text-gray-800 dark:text-white leading-tight">Terapi Wicara</h4>
                        <p class="text-sm text-gray-500 font-medium">09:00 - 10:30 WIB</p>
                    </div>
                </div>
                <hr class="my-5 border-gray-100 dark:border-gray-800">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-gray-400">Terapis: Guru Sarah</span>
                    <button class="text-xs font-black text-indigo-600 hover:underline">Detail Sesi</button>
                </div>
            </div>

            <a href="#" class="group block p-6 bg-emerald-600 rounded-[2rem] text-white hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200 dark:shadow-none">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-black text-lg">Laporan Mingguan</p>
                        <p class="text-xs text-emerald-100 font-medium">Periode 15 - 22 April 2026</p>
                    </div>
                    <i class="fa-solid fa-cloud-arrow-down text-2xl group-hover:bounce transition-transform"></i>
                </div>
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 p-8 rounded-[2.5rem] border border-gray-100 dark:border-gray-800">
        <h2 class="text-xl font-black text-gray-900 dark:text-white mb-8">Jurnal Harian Terapi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($riwayat as $r)
            <div class="flex gap-4 p-6 bg-gray-50 dark:bg-gray-800/50 rounded-3xl border border-transparent hover:border-indigo-100 dark:hover:border-indigo-900 transition-all group">
                <div class="shrink-0 w-12 h-12 bg-white dark:bg-gray-800 rounded-2xl shadow-sm flex flex-col items-center justify-center border border-gray-100 dark:border-gray-700">
                    <span class="text-[10px] font-black text-indigo-600 leading-none uppercase">{{ explode(' ', $r['tgl'])[1] }}</span>
                    <span class="text-lg font-black text-gray-800 dark:text-white leading-none mt-0.5">{{ explode(' ', $r['tgl'])[0] }}</span>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-sm font-black text-gray-900 dark:text-white">{{ $r['sesi'] }}</span>
                        <span class="text-[10px] bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full font-bold">{{ $r['oleh'] }}</span>
                    </div>
                    <p class="text-sm text-gray-500 font-medium leading-relaxed italic group-hover:text-gray-700 dark:group-hover:text-gray-300">"{{ $r['desc'] }}"</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('radarChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: {!! json_encode($aspek_perkembangan['labels']) !!},
            datasets: [{
                label: 'Capaian Ananda',
                data: {!! json_encode($aspek_perkembangan['skor']) !!},
                fill: true,
                backgroundColor: 'rgba(99, 102, 241, 0.2)', // Indigo 500 dengan opacity
                borderColor: '#6366f1',
                borderWidth: 3,
                pointBackgroundColor: '#6366f1',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#6366f1',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    angleLines: { display: true, color: 'rgba(0,0,0,0.05)' },
                    suggestedMin: 0,
                    suggestedMax: 100,
                    ticks: { display: false },
                    pointLabels: {
                        font: { size: 12, weight: '700', family: 'Inter' },
                        color: '#64748b'
                    }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endpush
@endsection