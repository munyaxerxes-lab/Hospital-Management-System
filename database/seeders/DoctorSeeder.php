<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('doctor')->insert([
    [
        'user_id' => 3,
        'hospital_id' => 1,
        'license_number' => 'DOC-001',
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}
