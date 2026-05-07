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
        // 1. Inisialisasi & Helper
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        $guruId = auth()->user()->guruTerapis->id;
        $hariIni = Carbon::now()->translatedFormat('l');

        // 2. Statistik Ringkas (Stats)
        $totalSiswa = Siswa::whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId))->count();

        $jadwalHariIni = JadwalTerapi::where('id_guru', $guruId)
            ->where('hari', $hariIni)
            ->with(['siswa', 'rekamTerapi' => function($q) {
                $q->whereDate('tanggal_pelaksanaan', Carbon::today());
            }])
            ->get()
            ->map(function($item) {
                $item->status_sesi = $item->rekamTerapi->isNotEmpty() ? 'selesai' : 'pending';
                return $item;
            });

        // 3. Persentase Kepatuhan & Analisis Tren
        $totalSesiTerinput = RekamTerapi::whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId))
            ->whereMonth('tanggal_pelaksanaan', Carbon::now()->month)
            ->whereYear('tanggal_pelaksanaan', Carbon::now()->year)
            ->count();
        
        $targetSesiBulanIni = JadwalTerapi::where('id_guru', $guruId)->count() * 4; 
        $persentaseLaporan = $targetSesiBulanIni > 0 ? min(round(($totalSesiTerinput / $targetSesiBulanIni) * 100), 100) : 0;

        $avgBulanIni = RekamTerapi::whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId))
            ->whereMonth('tanggal_pelaksanaan', Carbon::now()->month)
            ->avg('skor_grafik') ?? 0;

        $avgBulanLalu = RekamTerapi::whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId))
            ->whereMonth('tanggal_pelaksanaan', Carbon::now()->subMonth()->month)
            ->avg('skor_grafik') ?? 0;

        $selisih = $avgBulanIni - $avgBulanLalu;
        $persentaseTren = $avgBulanLalu > 0 ? ($selisih / $avgBulanLalu) * 100 : 0;

        // --- 4. LOGIKA DATA GRAFIK (SWITCHABLE) ---

        // A. Data Per Sesi (10 Hari/Sesi Terakhir)
        $sesiData = RekamTerapi::whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId))
            ->select(
                DB::raw('DATE(tanggal_pelaksanaan) as tanggal'),
                DB::raw('AVG(skor_grafik) as rata_skor')
            )
            ->where('status_kehadiran', 'Hadir')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->take(10)
            ->get()
            ->reverse();

        $chartSesiLabels = $sesiData->map(fn($d) => Carbon::parse($d->tanggal)->format('d/m'));
        $chartSesiValues = $sesiData->map(fn($d) => round($d->rata_skor, 1));

        // B. Data Bulanan (6 Bulan Terakhir)
        $bulananData = RekamTerapi::whereHas('jadwal', fn($q) => $q->where('id_guru', $guruId))
            ->select(
                DB::raw("MONTH(tanggal_pelaksanaan) as bulan_num"),
                DB::raw("AVG(skor_grafik) as rata_skor"),
                DB::raw("MIN(tanggal_pelaksanaan) as tgl")
            )
            ->where('status_kehadiran', 'Hadir')
            ->where('tanggal_pelaksanaan', '>=', Carbon::now()->subMonths(6))
            ->groupBy('bulan_num')
            ->orderBy('tgl', 'asc')
            ->get();

        $chartBulanLabels = $bulananData->map(fn($d) => Carbon::parse($d->tgl)->translatedFormat('F'));
        $chartBulanValues = $bulananData->map(fn($d) => round($d->rata_skor, 1));

        return view('guru.dashboard', [
            'stats' => [
                'total_siswa' => $totalSiswa,
                'sesi_hari_ini' => $jadwalHariIni->count(),
                'laporan_selesai' => $persentaseLaporan,
                'analisis_selisih' => round($selisih, 1),
                'analisis_persen' => abs(round($persentaseTren, 1)),
                'tren_naik' => $selisih >= 0,
            ],
            'jadwal' => $jadwalHariIni,
            // Kirim kedua set data ke view
            'chartSesiLabels' => $chartSesiLabels,
            'chartSesiValues' => $chartSesiValues,
            'chartBulanLabels' => $chartBulanLabels,
            'chartBulanValues' => $chartBulanValues,
        ]);
    }
}