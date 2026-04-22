<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'nama_anak' => 'Budi Santoso',
            // Data untuk Radar Chart (Skala 1-100)
            'aspek_perkembangan' => [
                'labels' => ['Motorik Halus', 'Motorik Kasar', 'Wicara', 'Sosialisasi', 'Kemandirian', 'Kognitif'],
                'skor' => [85, 70, 60, 90, 75, 80]
            ],
            'riwayat' => [
                ['tgl' => '22 Apr', 'sesi' => 'Wicara', 'oleh' => 'Guru Sarah', 'desc' => 'Sudah bisa kontak mata 5 detik'],
                ['tgl' => '20 Apr', 'sesi' => 'Okupasi', 'oleh' => 'Guru Doni', 'desc' => 'Bisa memegang sendok dengan benar'],
            ]
        ];

        return view('orangtua.dashboard', $data);
    }
}