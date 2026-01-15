<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run(): void
    {
 
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

     
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);
    }
}
