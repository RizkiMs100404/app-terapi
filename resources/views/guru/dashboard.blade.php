@extends('guru.layouts.main')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">
                Selamat Pagi, <span class="text-emerald-600 underline decoration-emerald-200 underline-offset-8">{{ explode(' ', Auth::user()->name)[0] }}!</span> 👋
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">Semangat memberikan pelayanan terbaik untuk siswa SLBN B Garut hari ini.</p>
        </div>
        <div class="flex items-center gap-3 bg-white dark:bg-gray-900 p-2 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800">
            <div class="bg-emerald-50 dark:bg-emerald-900/20 p-2 rounded-xl">
                <i class="fa-solid fa-calendar text-emerald-600"></i>
            </div>
            <div class="pr-4">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Hari Ini</p>
                <p class="text-sm font-bold text-gray-700 dark:text-gray-200">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="group relative overflow-hidden bg-white dark:bg-gray-900 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-xl transition-all duration-500">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 dark:bg-emerald-900/10 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative">
                <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-2xl flex items-center justify-center mb-4 shadow-inner">
                    <i class="fa-solid fa-users text-emerald-600 text-xl"></i>
                </div>
                <h3 class="text-gray-500 dark:text-gray-400 font-bold text-sm uppercase tracking-widest">Total Siswa Binaan</h3>
                <p class="text-4xl font-black text-gray-900 dark:text-white mt-1">{{ $stats['total_siswa'] }}</p>
            </div>
        </div>

        <div class="group relative overflow-hidden bg-emerald-600 p-6 rounded-[2rem] shadow-lg shadow-emerald-200 dark:shadow-none hover:-translate-y-1 transition-all duration-500">
            <div class="relative text-white">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mb-4">
                    <i class="fa-solid fa-clock text-white text-xl"></i>
                </div>
                <h3 class="text-emerald-100 font-bold text-sm uppercase tracking-widest">Sesi Terapi Hari Ini</h3>
                <p class="text-4xl font-black mt-1">{{ $stats['sesi_hari_ini'] }} <span class="text-lg font-medium opacity-80 text-emerald-100 italic">Sesi</span></p>
            </div>
        </div>

        <div class="group relative overflow-hidden bg-white dark:bg-gray-900 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-xl transition-all duration-500">
            <div class="relative">
                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fa-solid fa-chart-pie text-orange-600 text-xl"></i>
                </div>
                <h3 class="text-gray-500 dark:text-gray-400 font-bold text-sm uppercase tracking-widest">Laporan Selesai</h3>
                <div class="flex items-end gap-2">
                    <p class="text-4xl font-black text-gray-900 dark:text-white mt-1">{{ $stats['laporan_selesai'] }}%</p>
                    <div class="mb-2 w-full h-2 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                        <div class="h-full bg-orange-500 rounded-full" style="width: {{ $stats['laporan_selesai'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-[2rem] border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 dark:border-gray-800 flex justify-between items-center">
                <h2 class="text-xl font-black text-gray-800 dark:text-white">Jadwal Terapi Terdekat</h2>
                <a href="#" class="text-sm font-bold text-emerald-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-gray-800/50">
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Waktu</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Siswa</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Jenis Terapi</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach($jadwal as $j)
                        <tr class="hover:bg-emerald-50/30 dark:hover:bg-emerald-900/5 transition-colors group">
                            <td class="px-6 py-4 font-bold text-emerald-600 text-sm">{{ $j['waktu'] }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 flex-shrink-0 overflow-hidden">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($j['siswa']) }}&background=random" alt="">
                                    </div>
                                    <span class="font-bold text-gray-700 dark:text-gray-300 text-sm">{{ $j['siswa'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-500">{{ $j['tipe'] }}</td>
                            <td class="px-6 py-4">
                                @if($j['status'] == 'Selesai')
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400 rounded-full text-xs font-bold uppercase">Selesai</span>
                                @elseif($j['status'] == 'Menunggu')
                                    <span class="px-3 py-1 bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-400 rounded-full text-xs font-bold uppercase italic animate-pulse">Sedang Berlangsung</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 rounded-full text-xs font-bold uppercase">Mendatang</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-gradient-to-br from-emerald-600 to-teal-700 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-xl shadow-emerald-200 dark:shadow-none">
                <i class="fa-solid fa-quote-left absolute top-4 right-4 text-white/10 text-6xl"></i>
                <div class="relative">
                    <p class="text-emerald-100 text-xs font-bold uppercase tracking-[0.2em] mb-4">Misi Hari Ini</p>
                    <h4 class="text-lg font-bold leading-relaxed italic">"Setiap kemajuan kecil siswa adalah kemenangan besar bagi masa depan mereka."</h4>
                    <div class="mt-8 pt-6 border-t border-white/10">
                         <a href="{{ url('/guru/input-hasil') }}" class="flex items-center justify-center gap-3 bg-white text-emerald-600 px-6 py-3 rounded-2xl font-black text-sm hover:shadow-lg hover:scale-105 transition-all">
                             <i class="fa-solid fa-plus"></i> Input Hasil Terapi
                         </a>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-[2rem] p-6 border border-gray-100 dark:border-gray-800 shadow-sm">
                <h3 class="font-black text-gray-800 dark:text-white mb-4">Aktivitas Terakhir</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-4 group cursor-pointer">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center group-hover:rotate-12 transition-transform">
                            <i class="fa-solid fa-check text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-700 dark:text-gray-300">Laporan Budi S. Terkirim</p>
                            <p class="text-[10px] text-gray-400 font-medium">2 Jam yang lalu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection