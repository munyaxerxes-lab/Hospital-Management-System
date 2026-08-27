<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure the admin role exists
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Create or update the default administrator account
        User::updateOrCreate(
            ['email' => 'admin@medilink.com'],
            [
                'name' => 'Hospital Administrator',
                'password' => Hash::make('admin123'),
                'role_id' => $adminRole->id,
                'email_verified_at' => now(), 
                'otp_code' => null,
                'otp_expires_at' => null,
            ]
        );
    }
}
