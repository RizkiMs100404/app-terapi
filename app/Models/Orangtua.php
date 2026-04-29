<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orangtua extends Model
{
    protected $table = 'orangtua';
    protected $fillable = [
        'id_user',
        'id_tahun_ajaran',
        'nama_ibu',
        'nomor_hp_aktif',
        'pekerjaan'
    ];

    public function user() { return $this->belongsTo(User::class, 'id_user'); }
    public function tahunAjaran() { return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran'); }
    public function anak() { return $this->hasMany(Siswa::class, 'id_orangtua'); }
}
