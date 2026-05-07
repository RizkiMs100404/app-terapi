@extends('guru.layouts.main')

@section('content')
<div class="min-h-screen p-4 lg:p-10">
    <div class="max-w-7xl mx-auto">

        {{-- Top Navigation & Analytic Badge --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <a href="{{ route('guru.siswa-terapi.index') }}" class="group inline-flex items-center text-emerald-600 font-black text-sm uppercase tracking-widest transition-all">
                <i class="fa-solid fa-circle-chevron-left mr-2 text-xl group-hover:-translate-x-2 transition-transform"></i>
                Kembali
            </a>

            {{-- Smart Recommendation Badge --}}
            <div class="inline-flex items-center gap-4 px-6 py-4 bg-white rounded-[2rem] shadow-xl shadow-emerald-900/5 border-2 border-emerald-50">
                <div class="flex -space-x-2">
                    <div class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></div>
                    <div class="w-3 h-3 rounded-full bg-emerald-300 animate-ping opacity-75"></div>
                </div>
                <div class="flex flex-col">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] leading-none mb-1">Analytics Recommendation</span>
                    <span class="text-sm font-black text-emerald-800">{{ $rekomendasi }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            {{-- KIRI: Profil Siswa (Sticky) --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-[3rem] p-8 shadow-2xl shadow-emerald-900/10 border border-white sticky top-10 overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-50 rounded-full opacity-50"></div>

                    <div class="relative text-center mb-8">
                        {{-- Container Foto Profil Siswa --}}
                        <div class="relative w-32 h-32 mx-auto mb-5">
                            {{-- Frame Luar yang Miring --}}
                            <div class="w-full h-full bg-gradient-to-br from-emerald-500 to-teal-600 rounded-[2.5rem] flex items-center justify-center shadow-2xl shadow-emerald-200 transform rotate-3 overflow-hidden p-1">
                                
                                {{-- Bagian Foto/Inisial --}}
                                <div class="w-full h-full rounded-[2.2rem] overflow-hidden flex items-center justify-center bg-emerald-600">
                                    @if($siswa->foto && Storage::disk('public')->exists('foto_siswa/' . $siswa->foto))
                                        <img src="{{ asset('storage/foto_siswa/' . $siswa->foto) }}" 
                                            alt="{{ $siswa->nama_siswa }}" 
                                            class="w-full h-full object-cover transform -rotate-3 scale-125">
                                    @else
                                        <span class="text-white text-4xl font-black transform -rotate-3">
                                            {{ substr($siswa->nama_siswa, 0, 1) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Dekorasi tambahan: Dot Online/Aktif --}}
                            <div class="absolute bottom-1 right-1 w-7 h-7 bg-white rounded-full flex items-center justify-center shadow-lg transform rotate-3">
                                <div class="w-4 h-4 bg-emerald-500 rounded-full animate-pulse"></div>
                            </div>
                        </div>

                        <h2 class="text-2xl font-black text-emerald-950 leading-tight mb-2">{{ $siswa->nama_siswa }}</h2>
                        
                        <div class="flex flex-wrap justify-center gap-2">
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-[9px] font-black uppercase tracking-widest border border-emerald-100">
                                NIS: {{ $siswa->nis }}
                            </span>
                            <span class="px-3 py-1 bg-slate-900 text-white rounded-lg text-[9px] font-black uppercase tracking-widest">
                                {{ $siswa->tingkat }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-4 pt-6 border-t-2 border-dashed border-slate-100">
                        {{-- Info Kelas --}}
                        <div class="flex items-center gap-4 px-4 py-3 bg-emerald-50/50 rounded-2xl border border-emerald-100/50 hover:bg-emerald-50 transition-all group">
                            <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-emerald-500 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-school text-sm"></i>
                            </div>
                            <div>
                                <span class="block text-[9px] font-black text-emerald-400 uppercase tracking-widest">Kelas</span>
                                <p class="text-sm font-black text-emerald-800 leading-none mt-1">Kelas {{ $siswa->kelas }}</p>
                            </div>
                        </div>

                        {{-- Kebutuhan Khusus --}}
                        <div class="group p-4 bg-slate-50 rounded-2xl border border-transparent hover:border-emerald-100 hover:bg-emerald-50 transition-all duration-500">
                            <div class="flex items-center gap-3 mb-1">
                                <i class="fa-solid fa-star-of-life text-emerald-400 text-xs animate-spin-slow"></i>
                                <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Kebutuhan Khusus</span>
                            </div>
                            <p class="text-sm font-black text-slate-700 group-hover:text-emerald-800 transition-colors">
                                {{ $siswa->kebutuhan_khusus }}
                            </p>
                        </div>

                        {{-- Wali Murid --}}
                        <div class="flex items-center gap-4 px-4 py-3 bg-slate-50 rounded-2xl border border-transparent hover:border-slate-200 transition-all">
                            <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-slate-400">
                                <i class="fa-solid fa-hands-holding-child text-emerald-500"></i>
                            </div>
                            <div>
                                <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Wali Murid</span>
                                <p class="text-sm font-black text-slate-700 leading-none mt-1">{{ $siswa->orangtua->nama_ibu }}</p>
                            </div>
                        </div>

                        {{-- Total Sesi --}}
                        <div class="flex items-center gap-4 px-4 py-3 bg-slate-50 rounded-2xl border border-transparent hover:border-slate-200 transition-all">
                            <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-slate-400">
                                <i class="fa-solid fa-chart-simple text-blue-500"></i>
                            </div>
                            <div>
                                <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest">Total Sesi</span>
                                <p class="text-sm font-black text-slate-700 leading-none mt-1">{{ count($scores) }} Pertemuan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KANAN: Grafik Utama --}}
            <div class="lg:col-span-3 space-y-8">
                <div class="bg-white rounded-[3.5rem] p-8 lg:p-12 shadow-2xl shadow-emerald-900/5 border border-white relative overflow-hidden">
                    {{-- Watermark Icon --}}
                    <div class="absolute -top-10 -right-10 opacity-[0.03] rotate-12">
                         <i class="fa-solid fa-chart-line text-[20rem] text-emerald-950"></i>
                    </div>

                    <div class="relative flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <span class="w-8 h-1 bg-emerald-500 rounded-full"></span>
                                <span class="text-emerald-600 text-[10px] font-black uppercase tracking-[0.3em]">Performance Analytics</span>
                            </div>
                            <h3 class="text-4xl font-black text-emerald-950 tracking-tighter">Tren Kemajuan <span class="text-emerald-500 italic">Sesi Terapi</span></h3>
                        </div>

                        {{-- Legend Custom --}}
                        <div class="flex bg-slate-100/50 p-2 rounded-[1.5rem] border border-slate-200 shadow-inner">
                            <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-xl shadow-sm border border-slate-100">
                                <i class="fa-solid fa-line-chart text-emerald-500"></i>
                                <span class="text-[10px] font-black text-slate-600 uppercase">Skor %</span>
                            </div>
                            <div class="flex items-center gap-2 px-4 py-2">
                                <i class="fa-solid fa-calendar-day text-slate-400"></i>
                                <span class="text-[10px] font-black text-slate-400 uppercase">Jeda Hari</span>
                            </div>
                        </div>
                    </div>

                    <div class="relative h-[450px] w-full">
                        @if(count($scores) > 0)
                            <canvas id="premiumWaveChart"></canvas>
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-slate-300">
                                <i class="fa-solid fa-box-open text-6xl mb-4"></i>
                                <p class="font-black text-sm uppercase tracking-widest">Belum ada data sesi</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('premiumWaveChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [
                {
                    label: 'Skor Kemajuan',
                    data: @json($scores),
                    fill: false, // Garis sehelai bersih tanpa background
                    borderColor: '#059669', // Hijau Emerald tajam
                    borderWidth: 2, // Ketebalan sehelai yang elegan
                    tension: 0, // KUNCI: 0 membuat garis lurus kaku antar titik
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#059669',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: '#059669',
                    pointHoverBorderColor: '#fff',
                    spanGaps: false, // Memastikan garis berhenti sebelum bar "Target"
                    yAxisID: 'y'
                },
                {
                    label: 'Jeda Hari',
                    data: @json($intervals),
                    type: 'bar',
                    // Logic warna: Bar history (abu-abu), Bar Target (Emerald solid)
                    backgroundColor: (context) => {
                        const index = context.dataIndex;
                        const total = context.dataset.data.length;
                        return index === total - 1 ? '#10B981' : 'rgba(203, 213, 225, 0.4)';
                    },
                    hoverBackgroundColor: (context) => {
                        const index = context.dataIndex;
                        const total = context.dataset.data.length;
                        return index === total - 1 ? '#059669' : '#94A3B8';
                    },
                    borderRadius: 8,
                    barPercentage: 0.3, // Bar dibuat ramping biar kesan teknisnya kuat
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index',
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#064E3B',
                    titleFont: { size: 14, weight: '900', family: 'Plus Jakarta Sans' },
                    bodyFont: { size: 13, weight: '600' },
                    padding: 15,
                    cornerRadius: 15,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            const isLast = context.dataIndex === context.dataset.data.length - 1;
                            const label = context.dataset.label;

                            if (label === 'Skor Kemajuan') {
                                return context.parsed.y
                                    ? '🚀 PROGRES: ' + context.parsed.y + '%'
                                    : '⏳ TARGET: Menunggu Sesi';
                            } else {
                                return isLast
                                    ? '🎯 RENCANA JEDA: ' + context.parsed.y + ' HARI'
                                    : '📅 JEDA AKTUAL: ' + context.parsed.y + ' HARI';
                            }
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: 'rgba(241, 245, 249, 1)',
                        drawBorder: false,
                        borderDash: [5, 5] // Garis grid putus-putus biar makin cakep
                    },
                    ticks: {
                        stepSize: 25,
                        font: { weight: '800', size: 11 },
                        color: '#94A3B8',
                        callback: value => value + '%'
                    }
                },
                y1: {
                    position: 'right',
                    display: false, // Axis kanan disembunyikan agar visual tetap fokus
                    grid: { drawOnChartArea: false }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { weight: '800', size: 10 },
                        color: '#94A3B8'
                    }
                }
            }
        }
    });
</script>

<style>
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 8s linear infinite;
    }
</style>
@endsection
