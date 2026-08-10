<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('doctor_specialties')->insert([
    [
        'doctor_id' => 1,
        'specialty_id' => 1,
    ],
    [
        'doctor_id' => 1,
        'specialty_id' => 3,
    ],
]);
    }
}
