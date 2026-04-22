<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Default Admin
        User::create([
            'name'      => 'Administrator SLB',
            'username'  => 'adminSLB',
            'email'     => 'rizki.mustofa100404@gmail.com',
            'password'  => Hash::make('admin123'),
            'role'      => 'admin',
        ]);

        // 2. Buat Default Guru
        User::create([
            'name'      => 'Guru Terapi',
            'username'  => 'guru',
            'email'     => 'guru@gmail.com',
            'password'  => Hash::make('password123'),
            'role'      => 'guru',
        ]);

        // 3. Buat Default Orangtua
        User::create([
            'name'      => 'Wali Murid',
            'username'  => 'orangtua',
            'email'     => 'orangtua@gmail.com',
            'password'  => Hash::make('password123'),
            'role'      => 'orangtua',
        ]);
    }
}