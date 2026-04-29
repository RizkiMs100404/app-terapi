<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamTerapi extends Model
{
    protected $table = 'rekam_terapi';
    protected $fillable = [
        'id_jadwal', 'tanggal_pelaksanaan', 'nomor_sesi', 'hasil_kemajuan',
        'catatan_terapis', 'rekomendasi_lanjutan', 'skor_grafik', 'status_kehadiran', 'file_lampiran'
    ];

    public function jadwal() { return $this->belongsTo(JadwalTerapi::class, 'id_jadwal'); }
    
    public static function listKemajuan()
    {
        return [
            'Menurun' => 'Menurun',
            'Tetap' => 'Tetap / Stabil',
            'Meningkat' => 'Meningkat',
            'Meningkat Pesat' => 'Meningkat Pesat',
        ];
    }
}
