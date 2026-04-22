<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_siswa' => 124,
            'total_terapis' => 18,
            'jadwal_hari_ini' => 42,
            'laporan_baru' => 12,
            // Data Dummy untuk Grafik
            'chart_labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            'chart_data' => [65, 78, 82, 75, 90, 95] // Persentase rata-rata perkembangan
        ];

        return view('admin.dashboard', $data);
    }
}