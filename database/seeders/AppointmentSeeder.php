<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\User;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $patient = DB::table('patient')->first();
        if (!$patient) {
            return;
        }

        $doc1 = DB::table('doctors')->where('username', 'dr.johndoe')->first() ?? DB::table('doctors')->first();
        $doc2 = DB::table('doctors')->where('username', 'dr.sarahjenkins')->first() ?? DB::table('doctors')->skip(1)->first() ?? $doc1;
        $doc3 = DB::table('doctors')->where('username', 'dr.michaelchen')->first() ?? DB::table('doctors')->skip(2)->first() ?? $doc1;
        $doc4 = DB::table('doctors')->where('username', 'dr.janesmith')->first() ?? DB::table('doctors')->skip(3)->first() ?? $doc1;

        $sched1 = DB::table('doctor_schedule')->where('doctor_id', $doc1?->id)->first();
        $sched2 = DB::table('doctor_schedule')->where('doctor_id', $doc2?->id)->first();
        $sched3 = DB::table('doctor_schedule')->where('doctor_id', $doc3?->id)->first();
        $sched4 = DB::table('doctor_schedule')->where('doctor_id', $doc4?->id)->first();

        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        DB::table('appointments')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $appointments = [
            [
                'id' => 1,
                'patient_id' => $patient->id,
                'doctor_id' => $doc1?->id ?? 1,
                'schedule_id' => $sched1?->id,
                'payment_id' => null,
                'reason' => 'Routine cardiology consultation and follow-up on hypertension medication.',
                'status' => 'confirmed',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(1),
            ],
            [
                'id' => 2,
                'patient_id' => $patient->id,
                'doctor_id' => $doc2?->id ?? 2,
                'schedule_id' => $sched2?->id,
                'payment_id' => null,
                'reason' => 'Pediatric vaccination assessment and general physical developmental check.',
                'status' => 'confirmed',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subHours(5),
            ],
            [
                'id' => 3,
                'patient_id' => $patient->id,
                'doctor_id' => $doc3?->id ?? 3,
                'schedule_id' => $sched3?->id,
                'payment_id' => null,
                'reason' => 'Neurological evaluation for recurring tension migraines and sleep disturbance.',
                'status' => 'completed',
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(6),
            ],
            [
                'id' => 4,
                'patient_id' => $patient->id,
                'doctor_id' => $doc4?->id ?? 4,
                'schedule_id' => $sched4?->id,
                'payment_id' => null,
                'reason' => 'Dermatology consultation for seasonal contact eczema on left arm.',
                'status' => 'pending',
                'created_at' => now()->subHours(3),
                'updated_at' => now()->subHours(3),
            ],
        ];

        foreach ($appointments as $app) {
            DB::table('appointments')->insert($app);
        }
    }
}

