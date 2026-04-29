@extends('admin.layouts.main')

@section('content')
<div class="min-h-screen p-6 bg-[#F8FAFC]">
    <div class="max-w-7xl mx-auto">
        {{-- Alert Notifikasi --}}
        @if(session('error'))
<div id="alert-error" class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl flex items-center gap-4 transition-all duration-500 animate-bounce">
    <div class="bg-red-500 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg shadow-red-200">
        <i class="fa-solid fa-triangle-exclamation"></i>
    </div>
    <div>
        <h4 class="font-black text-red-800 text-sm uppercase tracking-tight">Oops, Gagal!</h4>
        <p class="text-red-600 text-xs font-bold">{{ session('error') }}</p>
    </div>
</div>
@endif

        <div class="mb-8">
            <h1 class="text-4xl font-black text-slate-900">Laporan <span class="text-blue-600">Perkembangan</span></h1>
            <p class="text-slate-500 font-medium">Analisis kemajuan terapi siswa secara berkala</p>
        </div>

        {{-- Widget Filter & Grafik --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            {{-- Form Filter --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 h-fit">
                <h3 class="font-black text-slate-800 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-filter text-blue-600"></i> Filter Data
                </h3>
                <form action="{{ route('admin.laporan.index') }}" method="GET" class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Siswa</label>
                        <select name="siswa_id" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 focus:ring-2 focus:ring-blue-500 font-bold text-slate-700">
                            <option value="">Semua Siswa</option>
                            @foreach($siswa as $s)
                                <option value="{{ $s->id }}" {{ request('siswa_id') == $s->id ? 'selected' : '' }}>{{ $s->nama_siswa }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Bulan</label>
                            <select name="bulan" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 focus:ring-2 focus:ring-blue-500 font-bold text-slate-700">
                                <option value="">Semua</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->translatedFormat('M') }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Sesi</label>
                            <select name="sesi" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 focus:ring-2 focus:ring-blue-500 font-bold text-slate-700">
                                <option value="">Semua</option>
                                @for($i = 1; $i <= 20; $i++)
                                    <option value="{{ $i }}" {{ request('sesi') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="pt-4 flex gap-2">
                        <button type="submit" class="flex-1 bg-blue-600 text-white font-black py-4 rounded-2xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 uppercase text-xs tracking-widest">
                            Terapkan
                        </button>
                        <a href="{{ route('admin.laporan.index') }}" class="px-5 py-4 bg-slate-100 text-slate-500 rounded-2xl hover:bg-slate-200 transition-all">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    </div>
                </form>
            </div>

            {{-- Grafik Visualisasi --}}
            <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 relative overflow-hidden">
                <div class="flex justify-between items-center mb-8 relative z-10">
                    <div>
                        <h3 class="font-black text-slate-800 italic">Tren Perkembangan</h3>
                        <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest">Visualisasi Skor Terapi (%)</p>
                    </div>
                    <div class="px-4 py-2 bg-blue-50 rounded-xl text-blue-600 font-black text-xs">
                        Avg: {{ number_format($laporan->avg('skor_grafik'), 1) }}%
                    </div>
                </div>

                <div class="h-[250px] w-full">
                    <canvas id="chartLaporan"></canvas>
                </div>
            </div>
        </div>

        {{-- Tabel Hasil Laporan --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden transition-all hover:shadow-xl hover:shadow-slate-200/50">
            <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="font-black text-slate-800 text-xl tracking-tight">Rincian Hasil Terapi Siswa</h3>
                    <p class="text-xs text-slate-400 font-bold italic">Total: {{ $laporan->count() }} Records ditemukan</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.laporan.pdf', request()->all()) }}" class="group flex items-center gap-2 px-6 py-3 bg-red-50 text-red-600 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all shadow-sm">
                        <i class="fa-solid fa-file-pdf text-base"></i> Export PDF
                    </a>
                    <a href="{{ route('admin.laporan.excel', request()->all()) }}" class="group flex items-center gap-2 px-6 py-3 bg-emerald-50 text-emerald-600 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                        <i class="fa-solid fa-file-excel text-base"></i> Export Excel
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Siswa & Terapis</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Sesi</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Tanggal</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Skor</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Rekomendasi Lanjutan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($laporan as $data)
                        <tr class="group hover:bg-blue-50/30 transition-all">
                            <td class="px-8 py-5">
                                <div class="font-black text-slate-800 group-hover:text-blue-700 transition-colors">{{ $data->jadwal->siswa->nama_siswa }}</div>
                                <div class="text-[9px] font-bold text-slate-400 uppercase mt-1 tracking-tighter">Guru: {{ $data->jadwal->guru->user->name }}</div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="bg-blue-600 text-white px-4 py-1.5 rounded-xl text-[10px] font-black shadow-lg shadow-blue-200">SESI {{ $data->nomor_sesi }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="font-bold text-slate-600 text-sm italic">{{ \Carbon\Carbon::parse($data->tanggal_pelaksanaan)->translatedFormat('d F Y') }}</div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl font-black text-sm {{ $data->skor_grafik >= 75 ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                    {{ $data->skor_grafik }}%
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="max-w-[250px]">
                                    <p class="text-xs text-slate-500 font-medium leading-relaxed italic line-clamp-2">"{{ $data->rekomendasi_lanjutan ?? 'Belum ada saran' }}"</p>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center opacity-20">
                                    <i class="fa-solid fa-folder-open text-6xl mb-4"></i>
                                    <p class="font-black uppercase tracking-[0.3em] text-xs">Data Tidak Ditemukan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Script Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartLaporan').getContext('2d');

    // Gradient effect untuk grafik
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
    gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($laporan->map(fn($d) => 'S'.$d->nomor_sesi)) !!},
            datasets: [{
                label: 'Skor Perkembangan',
                data: {!! json_encode($laporan->pluck('skor_grafik')) !!},
                borderColor: '#2563eb',
                borderWidth: 4,
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#2563eb',
                pointBorderWidth: 3,
                pointRadius: 5,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { min: 0, max: 100, grid: { display: false }, ticks: { font: { weight: 'bold' } } },
                x: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
            }
        }
    });

    // Tunggu dokumen selesai loading
    document.addEventListener('DOMContentLoaded', function() {
        const alertError = document.getElementById('alert-error');

        if (alertError) {
            // Set timer 3 detik (3000ms)
            setTimeout(function() {
                // Tambahkan efek transparan
                alertError.style.opacity = '0';
                alertError.style.transform = 'translateY(-20px)';

                // Hapus elemen dari layar setelah efek selesai (detik ke-3.5)
                setTimeout(function() {
                    alertError.remove();
                }, 500);

            }, 3000);
        }
    });
</script>
@endsection
