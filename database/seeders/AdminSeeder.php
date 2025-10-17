<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@gmail.com'], // condition to avoid duplicate
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'mobile' => '1234567890',
                'email_verified_at' => now(),
                'password' => Hash::make('developer'), // securely hash the password
                'image' => 'default.png',
                'address' => '123 Admin Street',
                'status' => 1,
            ]
        );
    }
}
