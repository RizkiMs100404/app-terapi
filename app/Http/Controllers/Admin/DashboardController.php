<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\GuruTerapis;
use App\Models\JadwalTerapi;
use App\Models\RekamTerapi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    Carbon::setLocale('id');

    $jumlahSiswa = Siswa::count();
    $jumlahGuru = GuruTerapis::count();
    $totalSesi = RekamTerapi::where('status_kehadiran', 'Hadir')->count();

    // Jadwal Terapi Hari Ini
    $hariIni = Carbon::now()->translatedFormat('l');
    $jadwalHariIni = JadwalTerapi::with(['siswa', 'guru.user'])
        ->where('hari', $hariIni)
        ->orderBy('jam_mulai', 'asc')
        ->get();

    // --- DATA GRAFIK ---

    // A. Data Per Sesi (Ambil 10 sesi terakhir untuk melihat progres detail)
    $sesiData = RekamTerapi::select('skor_grafik', 'tanggal_pelaksanaan')
        ->where('status_kehadiran', 'Hadir')
        ->orderBy('tanggal_pelaksanaan', 'desc')
        ->take(10)
        ->get()
        ->reverse(); // Supaya urutan di grafik dari lama ke baru

    $chartSesiLabels = $sesiData->map(function($d) {
        return Carbon::parse($d->tanggal_pelaksanaan)->format('d/m');
    });
    $chartSesiValues = $sesiData->pluck('skor_grafik');

    // B. Data Bulanan (Rata-rata skor per bulan)
    $bulananData = RekamTerapi::select(
            DB::raw('AVG(skor_grafik) as rata_skor'),
            DB::raw("DATE_FORMAT(tanggal_pelaksanaan, '%M') as bulan"),
            DB::raw("MIN(tanggal_pelaksanaan) as tgl")
        )
        ->where('status_kehadiran', 'Hadir')
        ->groupBy('bulan')
        ->orderBy('tgl', 'asc')
        ->take(6)
        ->get();

    $chartBulanLabels = $bulananData->pluck('bulan');
    $chartBulanValues = $bulananData->map(fn($d) => round($d->rata_skor, 1));

    return view('admin.dashboard', compact(
        'jumlahSiswa', 'jumlahGuru', 'totalSesi', 'jadwalHariIni',
        'chartSesiLabels', 'chartSesiValues',
        'chartBulanLabels', 'chartBulanValues'
    ));
}
}
