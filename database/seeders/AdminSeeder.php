<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // Create Camat
        $camat = User::create([
            'name' => 'Camat',
            'email' => 'camat@example.com',
            'password' => Hash::make('password'),
        ]);
        $camat->assignRole('camat');

        // Create sample user
        $user = User::create([
            'name' => 'User Contoh',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('user');
    }
}
