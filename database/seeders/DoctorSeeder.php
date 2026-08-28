<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            [
                'doctor_name' => 'Dr. John Doe',
                'specialty' => 'Cardiology',
                'qualification' => 'MBBS, MD (Cardiology), FACC',
                'years_of_experience' => 12,
                'consultation_fee' => 25000.00,
                'username' => 'dr.johndoe',
                'status' => 'active',
                'avatar' => '/image/doc.png',
            ],
            [
                'doctor_name' => 'Dr. Sarah Jenkins',
                'specialty' => 'Pediatrics',
                'qualification' => 'MBBS, MD (Pediatrics), DCH',
                'years_of_experience' => 8,
                'consultation_fee' => 15000.00,
                'username' => 'dr.sarahjenkins',
                'status' => 'active',
                'avatar' => '/image/doc2.jpg',
            ],
            [
                'doctor_name' => 'Dr. Michael Chen',
                'specialty' => 'Neurology',
                'qualification' => 'MBBS, DM (Neurology), PhD',
                'years_of_experience' => 15,
                'consultation_fee' => 30000.00,
                'username' => 'dr.michaelchen',
                'status' => 'active',
                'avatar' => '/image/doc3.jpg',
            ],
            [
                'doctor_name' => 'Dr. Jane Smith',
                'specialty' => 'Dermatology',
                'qualification' => 'MBBS, MD (Dermatology)',
                'years_of_experience' => 10,
                'consultation_fee' => 20000.00,
                'username' => 'dr.janesmith',
                'status' => 'active',
                'avatar' => '/image/wlcpic.png',
            ],
            [
                'doctor_name' => 'Dr. David Mbarga',
                'specialty' => 'Orthopedics',
                'qualification' => 'MBBS, MS (Orthopedics)',
                'years_of_experience' => 14,
                'consultation_fee' => 28000.00,
                'username' => 'dr.davidmbarga',
                'status' => 'active',
                'avatar' => '/image/doc.png',
            ],
            [
                'doctor_name' => 'Dr. Grace Enow',
                'specialty' => 'Gynecology & Obstetrics',
                'qualification' => 'MBBS, FWACS (OB-GYN)',
                'years_of_experience' => 11,
                'consultation_fee' => 22000.00,
                'username' => 'dr.graceenow',
                'status' => 'active',
                'avatar' => '/image/doc2.jpg',
            ],
        ];

        foreach ($doctors as $doc) {
            DB::table('doctors')->updateOrInsert(
                ['username' => $doc['username']],
                array_merge($doc, ['updated_at' => now(), 'created_at' => now()])
            );
        }
    }
}

