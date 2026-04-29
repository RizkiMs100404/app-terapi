<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke profil Guru
    public function guruTerapis()
    {
        return $this->hasOne(GuruTerapis::class, 'id_user');
    }

    // Relasi ke profil Orang Tua
    public function profilOrangtua()
    {
        return $this->hasOne(Orangtua::class, 'id_user');
    }
}
