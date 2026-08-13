<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PharmacistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('pharmacist')->insert([
    [
        'user_id' => 4,
        'hospital_id' => 1,
        'employee_id' => 'PH-001',
        'position' => 'Pharmacist',
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}
