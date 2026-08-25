<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Fetch the correct internal primary ID for the admin role safely
        $adminRole = Role::where('name', 'admin')->firstOrFail();

        // // 2. Inject your special management credentials into the users table
        // User::updateOrCreate(
        //     ['email' => 'admin@medilink.com'], // Checks if this email already exists
        //     [
        //         'name' => 'Hospital Administrator',
        //         'password' => Hash::make('SecureAdminSecret2026!'), // Change to a strong password
        //         'role_id' => $adminRole->id,
        //         'email_verified_at' => now(), // Bypasses public registration OTP steps
        //     ]);

        // User::updateOrCreate(
        //     ['email' => 'munyapanki@gmail.com'], // Checks if this email already exists
        //     [
        //         'name' => 'Hospital Administrator',
        //         'password' => Hash::make('612munyapanki2026!'), // Change to a strong password
        //         'role_id' => $adminRole->id,
        //         'email_verified_at' => now(), // Bypasses public registration OTP steps
        //     ]
           
        // );
        // database/seeders/AdminUserSeeder.php
        User::updateOrCreate(
            ['email' => 'admin@medilink.com'],
            [
                'name' => 'Hospital Administrator',
                'password' => Hash::make('admin123'),
                'role_id' => 3, // Admin role
                'email_verified_at' => now(), //  Keeps the Admin clear of the OTP page
                'otp_code' => null,
                'otp_expires_at' => null,
            ]
        );

    }
}
