<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Check if user already exists
        if (!User::where('email', 'admin@riceshop.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@riceshop.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]);
        }
        
        // Create another test user if needed
        if (!User::where('email', 'cashier@riceshop.com')->exists()) {
            User::create([
                'name' => 'Cashier User',
                'email' => 'cashier@riceshop.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]);
        }
    }
}