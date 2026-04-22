<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'enyidavid87@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Slimfrenzy234_?@#'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Editor
        User::updateOrCreate(
            ['email' => 'editor@sproutplex.com'],
            [
                'name' => 'Editor',
                'password' => Hash::make('Slimfrenzy234_?@#'),
                'role' => 'editor',
                'is_active' => true,
            ]
        );
    }
}