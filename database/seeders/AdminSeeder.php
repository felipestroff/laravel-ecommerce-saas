<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => config('admin.default_email', 'admin@laravelecommerce.com'),
            'password' => Hash::make(config('admin.default_password', 'password123')),
            'role' => 'admin',
            'is_active' => true,
        ]);
    }
}
