<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JadwalTerapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data profil guru
        $guru = Auth::user()->guruTerapis;

        if (!$guru) {
            return redirect()->back()->with('error', 'Profil Guru tidak ditemukan.');
        }

        // 2. Mapping Hari Indonesia
        $mapHari = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];

        // 3. Tentukan Tanggal & Hari Acuan
        // Jika ada filter tanggal, pakai itu. Jika tidak, pakai Carbon::now() (Real-time hari ini).
        $tanggalDipilih = $request->filled('tanggal') ? $request->tanggal : Carbon::now()->format('Y-m-d');
        $hariInggris = Carbon::parse($tanggalDipilih)->format('l');
        $hariAcuan = $mapHari[$hariInggris];

        // 4. Mulai Query
        $query = JadwalTerapi::with(['siswa', 'tahunAjaran', 'rekamTerapi'])
            ->where('id_guru', $guru->id);

        /**
         * LOGIKA FILTER:
         * Prioritas 1: Jika ada search, kita cari nama/nis tanpa batasan hari (opsional, tergantung keinginan).
         * Prioritas 2: Jika tidak search atau filter spesifik, gunakan $hariAcuan (bisa hari ini atau hari dari input tanggal).
         */

        if ($request->filled('search')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        // Tetap filter berdasarkan hari kecuali jika Abang ingin hasil search muncul di semua hari
        if (!$request->filled('search') || $request->filled('tanggal')) {
            $query->where('hari', $hariAcuan);
        }

        // 5. Eksekusi
        $jadwal = $query->orderBy('jam_mulai', 'asc')->get();

        return view('guru.jadwal.index', [
            'jadwal' => $jadwal,
            'hariIni' => $hariAcuan,
            'tanggalAktif' => $tanggalDipilih // Kirim balik ke view agar input date terisi
        ]);
    }
}
