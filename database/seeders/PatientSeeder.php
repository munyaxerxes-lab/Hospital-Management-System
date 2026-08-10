<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('patient')->insert([
    [
        'user_id' => 2,
        'gender' => 'Male',
        'dob' => '2000-05-15',
        'address' => 'Bonaberi, Douala',
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}
