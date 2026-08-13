<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('doctors_schedule')->insert([
    [
        'doctor_id' => 1,
        'date' => '2026-08-12',
        'start_time' => '09:00:00',
        'end_time' => '13:00:00',
        'status' => 'available',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'doctor_id' => 1,
        'date' => '2026-08-13',
        'start_time' => '09:00:00',
        'end_time' => '13:00:00',
        'status' => 'available',
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}
