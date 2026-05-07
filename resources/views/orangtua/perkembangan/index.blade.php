@extends('orangtua.layouts.main')

@section('content')
<div class="min-h-screen p-4 lg:p-10">
    <div class="max-w-7xl mx-auto">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Analisa Perkembangan</h1>
                <p class="text-sm text-slate-500 font-medium mt-1">
                    Laporan dinamis berdasarkan observasi klinis Ananda 
                    <span class="text-indigo-600 font-bold">{{ $anak->nama_siswa }}</span>
                </p>
            </div>
            <div class="flex items-center gap-3 bg-white px-5 py-3 rounded-2xl shadow-sm border border-slate-100">
                <div class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">Sistem Analisis Cerdas</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- KIRI: GRAFIK MEWAH (8 KOLOM) --}}
            <div class="lg:col-span-8 space-y-8">
                {{-- Main Chart Card --}}
                <div class="bg-white p-8 rounded-[3.5rem] shadow-xl shadow-indigo-900/5 border border-slate-50 relative overflow-hidden">
                    {{-- Decorative Background --}}
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-indigo-50/30 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-10">
                            <div>
                                <h3 class="text-xl font-black text-slate-900">Kurva Capaian Terapi</h3>
                                <p class="text-xs text-slate-400 font-medium tracking-wide">Visualisasi perkembangan kemampuan per pertemuan</p>
                            </div>
                        </div>

                        <div class="h-[420px] w-full">
                            <canvas id="chartPerkembangan"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Mini Stats --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm transition-all hover:border-indigo-200">
                        <p class="text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Total Sesi</p>
                        <h4 class="text-3xl font-black text-slate-900">{{ count($scores) > 0 ? count($scores) - 1 : 0 }}</h4>
                        <p class="text-[10px] text-slate-400 font-medium mt-1 uppercase italic">Pertemuan Tercatat</p>
                    </div>
                    
                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm transition-all hover:border-indigo-200">
                        <p class="text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Skor Aktual</p>
                        <h4 class="text-3xl font-black text-indigo-600">{{ $analisa['persentase'] }}%</h4>
                        <p class="text-[10px] text-slate-400 font-medium mt-1 uppercase italic">Capaian Terakhir</p>
                    </div>

                    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm transition-all hover:border-indigo-200">
                        <p class="text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Status Progress</p>
                        <div class="flex items-center gap-2 {{ $analisa['warna'] == 'rose' ? 'text-rose-500' : 'text-emerald-500' }}">
                            <i class="fa-solid {{ $analisa['warna'] == 'rose' ? 'fa-circle-down' : 'fa-circle-up' }} text-xl"></i>
                            <span class="text-lg font-black uppercase">{{ $analisa['warna'] == 'rose' ? 'Perlu Atensi' : 'Meningkat' }}</span>
                        </div>
                        <p class="text-[10px] text-slate-400 font-medium mt-1 uppercase italic">Trend Sistem</p>
                    </div>
                </div>
            </div>

            {{-- KANAN: ANALYTIC RESULT (4 KOLOM) --}}
            <div class="lg:col-span-4 space-y-6">
                
                {{-- Status Card --}}
                @php
                    $theme = [
                        'emerald' => ['bg' => 'bg-emerald-600', 'shadow' => 'shadow-emerald-900/20'],
                        'blue'    => ['bg' => 'bg-blue-600', 'shadow' => 'shadow-blue-900/20'],
                        'indigo'  => ['bg' => 'bg-indigo-600', 'shadow' => 'shadow-indigo-900/20'],
                        'rose'    => ['bg' => 'bg-rose-600', 'shadow' => 'shadow-rose-900/20'],
                        'slate'   => ['bg' => 'bg-slate-600', 'shadow' => 'shadow-slate-900/20']
                    ][$analisa['warna']] ?? ['bg' => 'bg-slate-600', 'shadow' => 'shadow-slate-900/20'];
                @endphp

                <div class="{{ $theme['bg'] }} {{ $theme['shadow'] }} p-10 rounded-[3.5rem] text-white shadow-2xl relative overflow-hidden group">
                    {{-- Decorative Icon --}}
                    <div class="absolute -bottom-10 -right-10 opacity-10">
                        <i class="fa-solid fa-notes-medical text-[12rem]"></i>
                    </div>
                    
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-[9px] font-black uppercase tracking-widest border border-white/20 mb-8">
                            <i class="fa-solid fa-chart-line"></i>
                            Recommended Analysis
                        </div>
                        
                        <h2 class="text-4xl font-black mb-4 leading-tight">{{ $analisa['status'] }}</h2>
                        <p class="text-xs leading-relaxed opacity-90 font-medium mb-10 italic">
                            "{{ $analisa['pesan'] }}"
                        </p>
                        
                        <div class="p-6 bg-white/10 backdrop-blur-md rounded-3xl border border-white/10">
                            <p class="text-[9px] font-black uppercase opacity-60 mb-2 tracking-widest">Rekomendasi Ahli</p>
                            <p class="text-sm font-bold leading-tight">{{ $analisa['rekomendasi'] }}</p>
                        </div>
                    </div>
                </div>

                {{-- Estimasi Sesi Card --}}
                <div class="bg-white p-8 rounded-[3rem] shadow-xl shadow-indigo-900/5 border border-slate-100 overflow-hidden relative group transition-all hover:shadow-indigo-900/10">
                    <div class="flex items-center gap-5 relative z-10">
                        <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm border border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500">
                            <i class="fa-solid fa-calendar-check text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Estimasi Sesi Berikutnya</p>
                            <p class="text-lg font-black text-slate-900">{{ $analisa['estimasi_tgl'] }}</p>
                        </div>
                    </div>
                </div>

                {{-- Saran Pendampingan DINAMIS dari Database --}}
                <div class="bg-slate-900 p-8 rounded-[3rem] text-white relative overflow-hidden shadow-2xl">
                    <div class="absolute top-0 right-0 p-6 opacity-10">
                        <i class="fa-solid fa-comments text-5xl text-indigo-400"></i>
                    </div>
                    <p class="text-[10px] font-black text-indigo-400 uppercase mb-4 tracking-[0.2em]">Catatan Terapis (Sesi Terakhir)</p>
                    <p class="text-[11px] leading-relaxed text-slate-300 italic mb-4">
                        @if($historyTerapi->count() > 0 && !empty($historyTerapi->last()->catatan_terapis))
                            "{{ $historyTerapi->last()->catatan_terapis }}"
                        @else
                            "Belum ada catatan khusus dari terapis untuk sesi terakhir ini."
                        @endif
                    </p>
                    <div class="pt-4 border-t border-slate-800 text-[9px] font-bold text-slate-500 uppercase tracking-widest">
                        Diperbarui: {{ $historyTerapi->count() > 0 ? $historyTerapi->last()->updated_at->format('d M Y') : '-' }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Script & Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('chartPerkembangan').getContext('2d');
        
        // Gradient mewah
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(79, 70, 229, 0.45)');
        gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

        const labels = {!! json_encode($labels) !!};
        const scores = {!! json_encode($scores) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Skor Capaian',
                    data: scores,
                    borderColor: '#4f46e5',
                    borderWidth: 5, // Lebih tebal biar mewah
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4, // Smooth curve
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#4f46e5',
                    pointBorderWidth: 4,
                    pointRadius: 7,
                    pointHoverRadius: 10,
                    pointHoverBackgroundColor: '#4f46e5',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 4,
                    spanGaps: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 18,
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 13 },
                        cornerRadius: 15,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return ` Capaian: ${context.raw}%`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { color: '#f1f5f9', borderDash: [5, 5] }, // Grid putus-putus
                        ticks: {
                            font: { size: 11, weight: '700' },
                            color: '#94a3b8',
                            callback: function(v) { return v + '%'; }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 11, weight: '800' },
                            color: '#64748b'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection