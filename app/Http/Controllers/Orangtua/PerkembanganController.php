<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\RekamTerapi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PerkembanganController extends Controller
{
    public function index()
    {
        // 1. Ambil ID Anak dari Session (Multi-anak support)
        $selectedAnakId = session('selected_anak_id');
        if (!$selectedAnakId) {
            return redirect()->route('orangtua.dashboard')
                ->with('error', 'Silakan pilih data anak terlebih dahulu.');
        }

        // 2. Load Data Anak & Rekam Terapi
        // Kita eager load jadwal dan guru agar query efisien
        $anak = Siswa::findOrFail($selectedAnakId);
        
        $historyTerapi = RekamTerapi::whereHas('jadwal', function($q) use ($selectedAnakId) {
                $q->where('id_siswa', $selectedAnakId);
            })
            ->orderBy('tanggal_pelaksanaan', 'asc') // Penting: ASC untuk urutan grafik
            ->get();

        // --- PREPARE DATA UNTUK CHART.JS ---
        $labels = [];
        $scores = [];
        $lastUpdate = null;

        foreach ($historyTerapi as $terapi) {
            $labels[] = "Sesi " . $terapi->nomor_sesi;
            $scores[] = (int)$terapi->skor_grafik;
            $lastUpdate = $terapi->tanggal_pelaksanaan;
        }

        // --- ULTRA PREMIUM ANALYTIC ENGINE ---
        // Default state jika belum ada data
        $analisa = [
            'status' => 'Data Kosong',
            'pesan' => 'Belum ada riwayat terapi yang tercatat untuk memulai proses analisa perkembangan.',
            'rekomendasi' => 'Lengkapi sesi terapi pertama',
            'estimasi_tgl' => '-',
            'warna' => 'slate',
            'icon' => 'fa-layer-group',
            'persentase' => 0
        ];

        if ($historyTerapi->count() > 0) {
            $latest = $historyTerapi->last();
            $lastScore = $latest->skor_grafik;
            $kemajuan = $latest->hasil_kemajuan;

            // Bobot Engine (Sama dengan versi Guru untuk konsistensi data)
            $bobotKemajuan = [
                'Meningkat Pesat' => 25,
                'Meningkat'      => 15,
                'Tetap'           => 5,
                'Menurun'        => -15
            ];

            $poinKemajuan = $bobotKemajuan[$kemajuan] ?? 0;
            
            // Rumus Analytic: Skor Riil (70%) + Bobot Tren (30%)
            $finalAnalyticScore = ($lastScore * 0.7) + ($poinKemajuan);
            $nextTargetDays = 7;

            // Logika Penentuan Status & Warna Premium
            if ($finalAnalyticScore >= 85) {
                $analisa = [
                    'status' => 'Sangat Mandiri',
                    'pesan' => 'Luar biasa! Ananda menunjukkan penguasaan materi yang sangat stabil. Fokus saat ini adalah pengulangan untuk kemandirian penuh.',
                    'rekomendasi' => 'Kontrol 4 Minggu Sekali',
                    'warna' => 'emerald',
                    'icon' => 'fa-award',
                ];
                $nextTargetDays = 28;
            } elseif ($finalAnalyticScore >= 70) {
                $analisa = [
                    'status' => 'Sangat Baik',
                    'pesan' => 'Progres sangat positif. Ananda mulai merespon instruksi dengan cepat tanpa banyak bantuan fisik.',
                    'rekomendasi' => 'Kontrol 3 Minggu Sekali',
                    'warna' => 'blue',
                    'icon' => 'fa-chart-line',
                ];
                $nextTargetDays = 21;
            } elseif ($finalAnalyticScore >= 50) {
                $analisa = [
                    'status' => 'Stabil',
                    'pesan' => 'Perkembangan berjalan konsisten. Dibutuhkan latihan tambahan di rumah sesuai rekomendasi terapis.',
                    'rekomendasi' => 'Kontrol 2 Minggu Sekali',
                    'warna' => 'indigo',
                    'icon' => 'fa-seedling',
                ];
                $nextTargetDays = 14;
            } else {
                $analisa = [
                    'status' => 'Intervensi Intens',
                    'pesan' => 'Ananda memerlukan dukungan penuh dan jadwal yang lebih padat untuk mengejar target perkembangan.',
                    'rekomendasi' => 'Wajib 1 Minggu Sekali',
                    'warna' => 'rose',
                    'icon' => 'fa-kit-medical',
                ];
                $nextTargetDays = 7;
            }

            // Hitung Estimasi Tanggal Sesi Berikutnya
            $analisa['estimasi_tgl'] = Carbon::parse($latest->tanggal_pelaksanaan)
                                        ->addDays($nextTargetDays)
                                        ->isoFormat('DD MMMM YYYY');
            $analisa['persentase'] = $lastScore;

            // Tambahkan "Ghost Data" untuk target di grafik
            $labels[] = "Target";
            $scores[] = null; 
        }

        return view('orangtua.perkembangan.index', compact(
            'anak', 
            'labels', 
            'scores', 
            'analisa', 
            'historyTerapi'
        ));
    }
}