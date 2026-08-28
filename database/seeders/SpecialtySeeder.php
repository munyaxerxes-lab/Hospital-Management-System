<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialtySeeder extends Seeder
{
    public function run(): void
    {
        $specialties = [
            ['id' => 1, 'name' => 'Cardiology', 'bio' => 'Cardiovascular diseases, heart conditions, and hypertension care.'],
            ['id' => 2, 'name' => 'Pediatrics', 'bio' => 'Comprehensive infant, child, and adolescent healthcare.'],
            ['id' => 3, 'name' => 'General Medicine', 'bio' => 'Primary care, internal medicine, and overall health wellness.'],
            ['id' => 4, 'name' => 'Dermatology', 'bio' => 'Skin, hair, and nail disorder diagnosis and treatment.'],
            ['id' => 5, 'name' => 'Gynecology & Obstetrics', 'bio' => 'Women reproductive health, prenatal, and maternal care.'],
            ['id' => 6, 'name' => 'Neurology', 'bio' => 'Disorders of the brain, spinal cord, and nervous system.'],
            ['id' => 7, 'name' => 'Orthopedics', 'bio' => 'Musculoskeletal system, bone fractures, joints, and spine care.'],
            ['id' => 8, 'name' => 'Ophthalmology', 'bio' => 'Vision care, eye examinations, and surgical eye treatments.'],
        ];

        foreach ($specialties as $s) {
            DB::table('specialties')->updateOrInsert(
                ['id' => $s['id']],
                array_merge($s, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
