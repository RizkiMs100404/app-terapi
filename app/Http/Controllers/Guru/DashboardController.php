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
        // Set locale ke Indonesia agar hari & bulan otomatis Indo
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        $guruId = auth()->user()->guruTerapis->id;
        $hariIni = Carbon::now()->translatedFormat('l'); // Senin, Selasa, dst.

        // 1. Total Siswa Binaan
        $totalSiswa = Siswa::whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId))->count();

        // 2. Jadwal Hari Ini + Cek Status Input (Terlaksana/Belum)
        $jadwalHariIni = JadwalTerapi::where('id_guru', $guruId)
            ->where('hari', $hariIni)
            ->with(['siswa', 'rekamTerapi' => function($q) {
                $q->whereDate('tanggal_pelaksanaan', Carbon::today());
            }])
            ->get()
            ->map(function($item) {
                // Atribut buatan untuk status di View
                $item->status_sesi = $item->rekamTerapi->isNotEmpty() ? 'selesai' : 'pending';
                return $item;
            });

        // 3. Hitung Persentase Kepatuhan Laporan (Bulan Ini)
        $totalSesiTerinput = RekamTerapi::whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId))
            ->whereMonth('tanggal_pelaksanaan', Carbon::now()->month)
            ->whereYear('tanggal_pelaksanaan', Carbon::now()->year)
            ->count();
        
        // Target: Total jadwal rutin x 4 minggu
        $targetSesiBulanIni = JadwalTerapi::where('id_guru', $guruId)->count() * 4; 
        $persentaseLaporan = $targetSesiBulanIni > 0 ? min(round(($totalSesiTerinput / $targetSesiBulanIni) * 100), 100) : 0;

        // 4. Logika Analisis Sistem (Dinamis)
        $avgBulanIni = RekamTerapi::whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId))
            ->whereMonth('tanggal_pelaksanaan', Carbon::now()->month)
            ->avg('skor_grafik') ?? 0;

        $avgBulanLalu = RekamTerapi::whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId))
            ->whereMonth('tanggal_pelaksanaan', Carbon::now()->subMonth()->month)
            ->avg('skor_grafik') ?? 0;

        $selisih = $avgBulanIni - $avgBulanLalu;
        $persentaseTren = $avgBulanLalu > 0 ? ($selisih / $avgBulanLalu) * 100 : 0;

        // 5. Data Grafik Kolektif (6 Bulan Terakhir)
        $chartData = RekamTerapi::whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId))
            ->select(
                DB::raw("DATE_FORMAT(tanggal_pelaksanaan, '%M') as bulan"),
                DB::raw("AVG(skor_grafik) as rata_skor"),
                DB::raw("MIN(tanggal_pelaksanaan) as tgl")
            )
            ->where('tanggal_pelaksanaan', '>=', Carbon::now()->subMonths(6))
            ->groupBy('bulan')
            ->orderBy('tgl', 'asc')
            ->get();

        $chartLabels = $chartData->map(fn($d) => Carbon::parse($d->tgl)->translatedFormat('F'));

        return view('guru.dashboard', [
            'stats' => [
                'total_siswa' => $totalSiswa,
                'sesi_hari_ini' => $jadwalHariIni->count(),
                'laporan_selesai' => $persentaseLaporan,
                // Data untuk Box Analisis Sistem
                'analisis_selisih' => round($selisih, 1),
                'analisis_persen' => abs(round($persentaseTren, 1)),
                'tren_naik' => $selisih >= 0,
            ],
            'jadwal' => $jadwalHariIni,
            'chartLabels' => $chartLabels,
            'chartScores' => $chartData->pluck('rata_skor'),
        ]);
    }
}