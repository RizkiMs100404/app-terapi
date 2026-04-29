<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = [
        'id_orangtua', 'id_tahun_ajaran', 'nis', 'nama_siswa', 'jenis_kelamin',
        'tanggal_lahir', 'provinsi', 'kabupaten_kota', 'kecamatan',
        'kelurahan', 'kode_pos', 'alamat_lengkap', 'kebutuhan_khusus'
    ];

    public function orangtua() { return $this->belongsTo(Orangtua::class, 'id_orangtua'); }
    public function tahunAjaran() { return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran'); }
    public function jadwal() { return $this->hasMany(JadwalTerapi::class, 'id_siswa'); }
    public function rekamTerapi()
{
    return $this->hasManyThrough(RekamTerapi::class, JadwalTerapi::class, 'id_siswa', 'id_jadwal');
}
}
