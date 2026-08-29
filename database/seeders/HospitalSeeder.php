<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HospitalSeeder extends Seeder
{
    public function run(): void
    {
        $hospitals = [
            [
                'id' => 1,
                'hospital_name' => 'ICLAN Central Hospital Douala',
                'address' => 'Boulevard de la Liberté, Akwa, Douala',
                'phone' => '+237 671 234 567',
                'email' => 'douala@iclan-hospital.cm',
            ],
            [
                'id' => 2,
                'hospital_name' => 'ICLAN Medical Center Yaoundé',
                'address' => 'Quartier Bastos, Yaoundé',
                'phone' => '+237 699 876 543',
                'email' => 'yaounde@iclan-hospital.cm',
            ],
            [
                'id' => 3,
                'hospital_name' => 'MediLink Regional Polyclinic Buea',
                'address' => 'Molyko Commercial Avenue, Buea',
                'phone' => '+237 675 112 233',
                'email' => 'buea@medilink.cm',
            ],
        ];

        foreach ($hospitals as $h) {
            DB::table('hospitals')->updateOrInsert(
                ['id' => $h['id']],
                array_merge($h, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}