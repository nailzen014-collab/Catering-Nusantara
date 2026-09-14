<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin Katering',
            'email'    => 'admin@cateringnusantara.test',
            'password' => Hash::make('password'), // ganti setelah testing
            'role'     => 'admin',
        ]);
    }
}