<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruTerapis extends Model
{
    protected $table = 'guru_terapis';
    protected $fillable = [
        'id_user',
        'id_tahun_ajaran',
        'nip',
        'jenis_kelamin',
        'nomor_hp',
        'keahlian_terapi',
        'status_kerja'
    ];

    protected $casts = [
        'keahlian_terapi' => 'array',
    ];

    public function user() { return $this->belongsTo(User::class, 'id_user'); }
    public function tahunAjaran() { return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran'); }
}
