<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'user' => auth()->user(),
            'stats' => [
                'total_siswa' => 12,
                'sesi_hari_ini' => 4,
                'laporan_selesai' => 85, // persentase
            ],
            'jadwal' => [
                ['waktu' => '08:00', 'siswa' => 'Budi Santoso', 'tipe' => 'Terapi Wicara', 'status' => 'Selesai'],
                ['waktu' => '10:30', 'siswa' => 'Siti Aminah', 'tipe' => 'Terapi Okupasi', 'status' => 'Menunggu'],
                ['waktu' => '13:00', 'siswa' => 'Randi Pangestu', 'tipe' => 'Fisioterapi', 'status' => 'Mendatang'],
            ]
        ];

        return view('guru.dashboard', $data);
    }
}