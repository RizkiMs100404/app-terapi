<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalTerapi extends Model
{
    protected $table = 'jadwal_terapi';
    protected $fillable = [
        'id_siswa', 'id_guru', 'id_tahun_ajaran', 'jenis_terapi',
        'hari', 'jam_mulai', 'jam_selesai', 'keterangan', 'ruang_terapi'
    ];

    public function siswa() { return $this->belongsTo(Siswa::class, 'id_siswa'); }
    public function guru() { return $this->belongsTo(GuruTerapis::class, 'id_guru'); }
    public function tahunAjaran() { return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran'); }
    public function rekamTerapi() { return $this->hasMany(RekamTerapi::class, 'id_jadwal'); }

    public static function listJenisTerapi() {
    return ['Wicara', 'Okupasi', 'Perilaku', 'Sensori Integrasi', 'Fisioterapi', 'Psikologi'];
    }

    public static function listHari() {
        return ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    }
}
