<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'patient',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'doctor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'pharmacist',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'laboratory_technician',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delivery_agent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
