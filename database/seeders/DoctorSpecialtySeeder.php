<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSpecialtySeeder extends Seeder
{
    public function run(): void
    {
        $mappings = [
            ['username' => 'dr.johndoe', 'specialty' => 'Cardiology'],
            ['username' => 'dr.johndoe', 'specialty' => 'General Medicine'],
            ['username' => 'dr.sarahjenkins', 'specialty' => 'Pediatrics'],
            ['username' => 'dr.michaelchen', 'specialty' => 'Neurology'],
            ['username' => 'dr.janesmith', 'specialty' => 'Dermatology'],
            ['username' => 'dr.janesmith', 'specialty' => 'General Medicine'],
            ['username' => 'dr.davidmbarga', 'specialty' => 'Orthopedics'],
            ['username' => 'dr.graceenow', 'specialty' => 'Gynecology & Obstetrics'],
        ];

        foreach ($mappings as $m) {
            $doc = DB::table('doctors')->where('username', $m['username'])->first();
            $spec = DB::table('specialties')->where('name', $m['specialty'])->first();

            if ($doc && $spec) {
                DB::table('doctor_specialties')->updateOrInsert(
                    ['doctor_id' => $doc->id, 'specialty_id' => $spec->id],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }
}


