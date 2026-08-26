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
         //creatx the admin role entry if the roles table is empty
        DB::table('roles')->insertOrIgnore([
            'id' => 1, // Traditional fallback setup for admin roles
            'name' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //Fetchx the correct role profile from the database dynamically
        $adminRole = Role::where('name', 'admin')->first();

         //Automatx safe entry injection wrapper
        User::updateOrCreate(
            ['email' => 'admin@medilink.com'],
            [
                'name' => 'Hospital Administrator',
                'password' => Hash::make('admin123'),
                'role_id' => $adminRole ? $adminRole->id : 1,
                'email_verified_at' => now(), 
                'otp_code' => null,
                'otp_expires_at' => null,
            ]
        );
    }
}
