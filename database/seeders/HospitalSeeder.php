<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class HospitalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('hospitals')->insert([
            [
                'hospital_name' => 'ICLAN Hospital',
                'address' => 'Douala, Cameroon',
                'phone' => '+237 600000001',
                'email' => 'info@iclan-hospital.cm',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hospital_name' => 'ICLAN Medical Centre',
                'address' => 'Yaoundé, Cameroon',
                'phone' => '+237 600000002',
                'email' => 'yaounde@iclan-hospital.cm',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}