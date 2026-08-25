<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,      // Step 1: Seeds 'patient' and 'admin' roles into database
            AdminUserSeeder::class, // Step 2: Generates a secure custom admin account
        ]);
    }
}