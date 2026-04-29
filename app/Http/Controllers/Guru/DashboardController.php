<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\JadwalTerapi;
use App\Models\RekamTerapi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $guruId = auth()->user()->guruTerapis->id;
        $hariIni = Carbon::now()->translatedFormat('l'); // Senin, Selasa, dst

        // Statistik Real
        $totalSiswa = Siswa::whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId))->count();

        $jadwalHariIni = JadwalTerapi::where('id_guru', $guruId)
            ->where('hari', $hariIni)
            ->with(['siswa'])
            ->get();

        // Hitung Persentase Laporan Selesai (Bulan Ini)
        $totalSesiBulanIni = RekamTerapi::whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId))
            ->whereMonth('tanggal_pelaksanaan', Carbon::now()->month)
            ->count();

        $targetSesiBulanIni = $jadwalHariIni->count() * 4; // Estimasi kasar target
        $persentaseLaporan = $targetSesiBulanIni > 0 ? round(($totalSesiBulanIni / $targetSesiBulanIni) * 100) : 0;

        // Data Grafik Kolektif (Rata-rata skor semua siswa 6 bulan terakhir)
        $chartData = RekamTerapi::whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId))
            ->select(
                DB::raw("DATE_FORMAT(tanggal_pelaksanaan, '%M') as bulan"),
                DB::raw("AVG(skor_grafik) as rata_skor")
            )
            ->groupBy('bulan')
            ->orderBy('tanggal_pelaksanaan', 'asc')
            ->take(6)
            ->get();

        return view('guru.dashboard', [
            'stats' => [
                'total_siswa' => $totalSiswa,
                'sesi_hari_ini' => $jadwalHariIni->count(),
                'laporan_selesai' => $persentaseLaporan,
            ],
            'jadwal' => $jadwalHariIni,
            'chartLabels' => $chartData->pluck('bulan'),
            'chartScores' => $chartData->pluck('rata_skor'),
        ]);
    }
}
