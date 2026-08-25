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
        
        $adminRole = Role::where('name','admin')->firstOrFail();

       
      
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
