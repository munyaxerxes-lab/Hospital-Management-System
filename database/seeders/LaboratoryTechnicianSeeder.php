<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaboratoryTechnicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('lab_technician')->insert([
    [
        'user_id' => 5,
        'hospital_id' => 1,
        'employee_id' => 'LAB-001',
        'position' => 'Laboratory Technician',
        'created_at' => now(),
        'updated_at' => now(),
    ],
        ]);
    }
}
