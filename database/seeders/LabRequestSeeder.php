<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('lab_requests')->insert([
    [
        'patient_id' => 1,
        'payment_id' => 1,
        'requested_at' => now(),
        'status' => 'pending',
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}
