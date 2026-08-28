<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\Doctor;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $patient = DB::table('patient')->first();
        $doctor = DB::table('doctors')->first();

        if (!$patient) {
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('notifications')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $notifications = [
            [
                'patient_id' => $patient->id,
                'doctor_id' => $doctor?->id,
                'appointment_id' => 1,
                'title' => 'Appointment Confirmed',
                'message' => 'Your cardiology consultation with Dr. John Doe is confirmed for tomorrow. Please arrive 15 minutes before your time slot.',
                'type' => 'consultation',
                'is_read' => 0,
                'created_at' => now()->subHours(5),
                'updated_at' => now()->subHours(5),
            ],
            [
                'patient_id' => $patient->id,
                'doctor_id' => null,
                'appointment_id' => null,
                'title' => 'Lab Results Available',
                'message' => 'Your diagnostic lab results for Malaria Parasite and Full Blood Count (LR-20260827-7712) are ready for viewing and download.',
                'type' => 'lab_test',
                'is_read' => 0,
                'created_at' => now()->subHours(8),
                'updated_at' => now()->subHours(8),
            ],
            [
                'patient_id' => $patient->id,
                'doctor_id' => null,
                'appointment_id' => null,
                'title' => 'Pharmacy Order Dispatched',
                'message' => 'Order ORD-20260828-1033 is out for delivery with agent David Etoa (Yamaha Express Motorbike).',
                'type' => 'order',
                'is_read' => 1,
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(1),
            ],
            [
                'patient_id' => $patient->id,
                'doctor_id' => null,
                'appointment_id' => null,
                'title' => 'Preventive Health Reminder',
                'message' => 'Time for your quarterly blood pressure & sugar checkup. Schedule a quick clinic visit or book home sample collection.',
                'type' => 'consultation',
                'is_read' => 1,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(2),
            ],
        ];

        foreach ($notifications as $n) {
            DB::table('notifications')->insert($n);
        }
    }
}
