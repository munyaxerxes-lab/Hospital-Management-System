<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('appointments')->insert([
    [
        'patient_id' => 1,
        'doctor_id' => 1 ,
        'schedule_id' => 1,
        'payment_id' => 1,
        'reason' => 'Routine medical consultation',
        'status' => 'confirmed',
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}
