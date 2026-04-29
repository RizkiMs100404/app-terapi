<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\RekamTerapi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class SiswaTerapiController extends Controller
{
    public function index(Request $request)
    {
        // Validasi input filter agar tidak error saat user input manual di URL
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $guruId = auth()->user()->guruTerapis->id;

        // Query dasar: Siswa yang memiliki jadwal dengan guru yang login
        $query = Siswa::whereHas('jadwal', function($q) use ($guruId) {
            $q->where('id_guru', $guruId);
        })->withCount('rekamTerapi');

        // Search Engine: Nama atau NIS
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_siswa', 'like', "%{$request->search}%")
                  ->orWhere('nis', 'like', "%{$request->search}%");
            });
        }

        // Filter Berdasarkan Tanggal Pelaksanaan Terapi
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereHas('rekamTerapi', function($q) use ($request) {
                $q->whereBetween('tanggal_pelaksanaan', [$request->start_date, $request->end_date]);
            });
        }

        $siswa = $query->latest()->paginate(9)->withQueryString();

        return view('guru.siswa-terapi.index', compact('siswa'));
    }

    public function show($id)
    {
        $guruId = auth()->user()->guruTerapis->id;

        // Proteksi Data: Pastikan guru hanya bisa akses siswa bimbingannya
        $siswa = Siswa::whereHas('jadwal', function($q) use ($guruId) {
            $q->where('id_guru', $guruId);
        })->with(['orangtua'])->findOrFail($id);

        // Ambil history terapi urut dari yang terlama ke terbaru untuk grafik
        $historyTerapi = RekamTerapi::whereHas('jadwal', function($q) use ($siswa) {
                                $q->where('id_siswa', $siswa->id);
                             })->orderBy('tanggal_pelaksanaan', 'asc')->get();

        $labels = [];
        $scores = [];
        $intervals = [];
        $nextTargetDays = 7; // Default target

        // --- PREPARE DATA GRAFIK HISTORY ---
        foreach ($historyTerapi as $index => $terapi) {
            $labels[] = "Sesi " . $terapi->nomor_sesi;
            $scores[] = $terapi->skor_grafik;

            if ($index > 0) {
                $current = Carbon::parse($terapi->tanggal_pelaksanaan);
                $prev = Carbon::parse($historyTerapi[$index - 1]->tanggal_pelaksanaan);
                $intervals[] = $prev->diffInDays($current);
            } else {
                $intervals[] = 0;
            }
        }

        // --- ULTRA PREMIUM ANALYTIC ENGINE ---
        $rekomendasi = "Wajib 1 Minggu Sekali";

        if ($historyTerapi->count() > 0) {
            $latest = $historyTerapi->last();
            $lastScore = $latest->skor_grafik;
            $kemajuan = $latest->hasil_kemajuan;

            // Mapping Kemajuan ke Bobot Poin
            $bobotKemajuan = [
                'Meningkat Pesat' => 25,
                'Meningkat'      => 15,
                'Tetap'          => 5,
                'Menurun'        => -15
            ];

            $poinKemajuan = $bobotKemajuan[$kemajuan] ?? 0;

            // RUMUS ANALYSTIC: Bobot Skor Real (70%) + Bobot Tren (30%)
            $finalAnalyticScore = ($lastScore * 0.7) + ($poinKemajuan);

            // Penentuan Rekomendasi & Target Jeda Berikutnya
            if ($finalAnalyticScore >= 90) {
                $rekomendasi = "4 Minggu Sekali (Sangat Mandiri)";
                $nextTargetDays = 28;
            } elseif ($finalAnalyticScore >= 75) {
                $rekomendasi = "3 Minggu Sekali (Progres Sangat Baik)";
                $nextTargetDays = 21;
            } elseif ($finalAnalyticScore >= 60) {
                $rekomendasi = "2 Minggu Sekali (Progres Stabil)";
                $nextTargetDays = 14;
            } elseif ($finalAnalyticScore < 45) {
                $rekomendasi = "1 Minggu Sekali (Intervensi Intensif)";
                $nextTargetDays = 7;
            } else {
                $rekomendasi = "Tetap 1 Minggu Sekali (Konsolidasi)";
                $nextTargetDays = 7;
            }

            // Tambahkan "Ghost Data" untuk Prediksi di Ujung Grafik
            $labels[] = "Target Sesi";
            $scores[] = null; // Line chart berhenti di sini
            $intervals[] = $nextTargetDays; // Bar penanda target hari

            // Tambahkan estimasi tanggal ke teks rekomendasi
            $tglEstimasi = Carbon::parse($latest->tanggal_pelaksanaan)->addDays($nextTargetDays)->format('d M Y');
            $rekomendasi .= " — Estimasi: " . $tglEstimasi;
        }

        return view('guru.siswa-terapi.show', compact(
            'siswa',
            'labels',
            'scores',
            'intervals',
            'rekomendasi'
        ));
    }
}
