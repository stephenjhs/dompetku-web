<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@dompetku.test'], // agar tidak duplicate jika di-seed ulang
            [
                'name' => 'Admin DompetKu',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'), // ganti sesuai kebutuhan
                'phone_number' => null,
                'saldo' => 0,
                'saldo_dollar' => 0,
                'role' => 'admin',
            ]
        );
    }
}
