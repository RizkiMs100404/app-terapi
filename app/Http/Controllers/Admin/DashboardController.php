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
        
        // 1. Total Sesi Terlaksana (Sepanjang waktu)
        $totalSesi = RekamTerapi::where('status_kehadiran', 'Hadir')->count();

        // 2. Logika Sesi Belum Terlaksana (Khusus Hari Ini)
        $hariIni = Carbon::now()->translatedFormat('l');
        
        // Ambil jumlah jadwal yang seharusnya ada hari ini
        $jumlahJadwalHariIni = JadwalTerapi::where('hari', $hariIni)->count();
        
        // Ambil jumlah rekam terapi yang sudah diinput hari ini
        $sesiSudahInputHariIni = RekamTerapi::whereDate('tanggal_pelaksanaan', Carbon::today())->count();
        
        // Selisihnya adalah sesi yang belum diabsen/dikerjakan
        $sesiBelumTerlaksana = max(0, $jumlahJadwalHariIni - $sesiSudahInputHariIni);

        // 3. Ambil Data Jadwal untuk List Antrean
        $jadwalHariIni = JadwalTerapi::with(['siswa', 'guru.user'])
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai', 'asc')
            ->get()
            ->map(function ($item) {
                $item->jam_mulai = Carbon::parse($item->jam_mulai)->format('H:i');
                return $item;
            });

        // --- DATA GRAFIK ---

        // A. Data Per Sesi (Rata-rata skor harian dari seluruh siswa - 10 hari terakhir)
        $sesiData = RekamTerapi::select(
                DB::raw('DATE(tanggal_pelaksanaan) as tanggal'),
                DB::raw('AVG(skor_grafik) as rata_skor')
            )
            ->where('status_kehadiran', 'Hadir')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->take(10)
            ->get()
            ->reverse();

        $chartSesiLabels = $sesiData->map(function($d) {
            return Carbon::parse($d->tanggal)->format('d/m');
        });
        $chartSesiValues = $sesiData->map(fn($d) => round($d->rata_skor, 1));

        // B. Data Bulanan (Rata-rata per bulan untuk tahun berjalan)
        $bulananData = RekamTerapi::select(
                DB::raw('MONTH(tanggal_pelaksanaan) as bulan_num'),
                DB::raw("DATE_FORMAT(tanggal_pelaksanaan, '%M') as bulan_name"),
                DB::raw('AVG(skor_grafik) as rata_skor')
            )
            ->where('status_kehadiran', 'Hadir')
            ->whereYear('tanggal_pelaksanaan', date('Y'))
            ->groupBy('bulan_num', 'bulan_name')
            ->orderBy('bulan_num', 'asc')
            ->get();

        $chartBulanLabels = $bulananData->pluck('bulan_name');
        $chartBulanValues = $bulananData->map(fn($d) => round($d->rata_skor, 1));

        return view('admin.dashboard', compact(
            'jumlahSiswa', 
            'jumlahGuru', 
            'totalSesi', 
            'jadwalHariIni',
            'chartSesiLabels', 
            'chartSesiValues',
            'chartBulanLabels', 
            'chartBulanValues',
            'sesiBelumTerlaksana'
        ));
    }
}