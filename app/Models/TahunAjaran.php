<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';
    protected $fillable = ['rentang_tahun', 'semester', 'status_aktif'];

    // List semua relasi yang bergantung pada Tahun Ajaran
    public function siswa() { return $this->hasMany(Siswa::class, 'id_tahun_ajaran'); }
    public function guru() { return $this->hasMany(GuruTerapis::class, 'id_tahun_ajaran'); }
    public function orangtua() { return $this->hasMany(Orangtua::class, 'id_tahun_ajaran'); }
    public function jadwal() { return $this->hasMany(JadwalTerapi::class, 'id_tahun_ajaran'); }
}
