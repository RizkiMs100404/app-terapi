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
            'name'      => 'Administrator',
            'username'  => 'adminSLB',
            'email'     => 'aprilianihilda2@gmail.com',
            'password'  => Hash::make('admin123'),
            'role'      => 'admin',
        ]);

        // 2. Buat Default Guru
        User::create([
            'name'      => 'Indah Kusmawati',
            'username'  => 'indah',
            'email'     => 'indah@gmail.com',
            'password'  => Hash::make('indah123'),
            'role'      => 'guru',
        ]);

        // 3. Buat Default Orangtua
        User::create([
            'name'      => 'Anton Budiman',
            'username'  => 'anton',
            'email'     => 'anton@gmail.com',
            'password'  => Hash::make('anton123'),
            'role'      => 'orangtua',
        ]);
    }
}
