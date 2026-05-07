<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\JadwalTerapi;
use App\Models\RekamTerapi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Inisialisasi User & Ortu
        $user = Auth::user();
        $ortu = $user->profilOrangtua; 

        if (!$ortu) {
            return redirect('/')->with('error', 'Profil orang tua tidak ditemukan.');
        }

        // 2. Handle Switch Anak (Active Child)
        $selectedAnakId = session('selected_anak_id');
        if (!$selectedAnakId) {
            $firstAnak = $ortu->siswa()->first();
            if ($firstAnak) {
                $selectedAnakId = $firstAnak->id;
                session(['selected_anak_id' => $selectedAnakId]);
            }
        }

        // 3. Ambil Data Anak
        $anak = Siswa::where('id_orangtua', $ortu->id)->find($selectedAnakId);

        if (!$anak) {
            return view('orangtua.dashboard', [
                'aspek_perkembangan' => ['labels' => [], 'skor' => []],
                'jadwal_hari_ini' => [],
                'chartSesiLabels' => [],
                'chartSesiValues' => [],
                'chartBulanLabels' => [],
                'chartBulanValues' => [],
                'tanggal_hari_ini' => Carbon::now()->isoFormat('dddd, D MMMM YYYY')
            ]);
        }

        Carbon::setLocale('id');
        $hariIni = Carbon::now()->isoFormat('dddd');

        // 4. LOGIC RADAR CHART (Analisis Capaian Terapi)
        $labelsRadar = ['Wicara', 'Okupasi', 'Perilaku', 'Sensori Integrasi', 'Fisioterapi', 'Psikologi'];
        $skorRadar = [];
        foreach ($labelsRadar as $jenis) {
            $avgSkor = RekamTerapi::whereHas('jadwal', function($q) use ($anak, $jenis) {
                $q->where('id_siswa', $anak->id)->where('jenis_terapi', $jenis);
            })->avg('skor_grafik');
            $skorRadar[] = $avgSkor ? round($avgSkor) : 0;
        }

        // 5. LOGIC TREN KOLEKTIF (Line Chart)
        // A. Per Sesi (10 Sesi Terakhir si Anak)
        $sesiData = RekamTerapi::whereHas('jadwal', function($q) use ($anak) {
                $q->where('id_siswa', $anak->id);
            })
            ->select(DB::raw('DATE(tanggal_pelaksanaan) as tanggal'), DB::raw('AVG(skor_grafik) as rata_skor'))
            ->where('status_kehadiran', 'Hadir')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->take(10)
            ->get()
            ->reverse();

        $chartSesiLabels = $sesiData->map(fn($d) => Carbon::parse($d->tanggal)->format('d/m'));
        $chartSesiValues = $sesiData->map(fn($d) => round($d->rata_skor, 1));

        // B. Bulanan (6 Bulan Terakhir si Anak)
        $bulananData = RekamTerapi::whereHas('jadwal', function($q) use ($anak) {
                $q->where('id_siswa', $anak->id);
            })
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

        // 6. JADWAL HARI INI (Ganti Jurnal Harian)
        $jadwalHariIni = JadwalTerapi::with(['guru.user', 'rekamTerapi' => function($q) {
                $q->where('tanggal_pelaksanaan', Carbon::today());
            }])
            ->where('id_siswa', $anak->id)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('orangtua.dashboard', [
            'anak' => $anak,
            'tanggal_hari_ini' => Carbon::now()->isoFormat('dddd, D MMMM YYYY'),
            'aspek_perkembangan' => [
                'labels' => $labelsRadar,
                'skor' => $skorRadar 
            ],
            'jadwal_hari_ini' => $jadwalHariIni,
            'chartSesiLabels' => $chartSesiLabels,
            'chartSesiValues' => $chartSesiValues,
            'chartBulanLabels' => $chartBulanLabels,
            'chartBulanValues' => $chartBulanValues
        ]);
    }

    public function switchAnak($id)
    {
        $user = Auth::user();
        $ortu = $user->profilOrangtua;
        $cekAnak = Siswa::where('id', $id)->where('id_orangtua', $ortu->id)->exists();
        if ($cekAnak) { 
            session(['selected_anak_id' => $id]); 
        }
        return redirect()->back();
    }
}