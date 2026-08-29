<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Patient;

class LabRequestSeeder extends Seeder
{
    public function run(): void
    {
        $patientUser = User::where('email', 'patient@medilink.com')->first() ?? User::where('role_id', 1)->first();
        $patient = $patientUser ? Patient::where('user_id', $patientUser->id)->first() : null;

        if (!$patient || !$patientUser) {
            return;
        }

        DB::table('lab_request_items')->delete();
        DB::table('lab_results')->delete();
        DB::table('lab_reqests')->delete();

        $testMalaria = DB::table('lab_tests')->where('name', 'like', '%Malaria%')->first();
        $testCBC = DB::table('lab_tests')->where('name', 'like', '%Complete Blood Count%')->first();
        $testSugar = DB::table('lab_tests')->where('name', 'like', '%Glucose%')->first();
        $testLipid = DB::table('lab_tests')->where('name', 'like', '%Lipid%')->first();
        $testWidal = DB::table('lab_tests')->where('name', 'like', '%Widal%')->first();

        // 1. Completed Lab Request (with simulated results document)
        $req1Id = DB::table('lab_reqests')->insertGetId([
            'request_number' => 'LR-20260827-7712',
            'user_id' => $patientUser->id,
            'patient_id' => $patient->id,
            'payment_id' => null,
            'total_amount' => 8000.00,
            'status' => 'completed',
            'payment_status' => 'paid',
            'payment_method' => 'cash_on_delivery',
            'sample_type' => 'Venous Blood (EDTA Tube)',
            'scheduled_date' => date('Y-m-d', strtotime('-1 day')),
            'scheduled_time' => '08:30 AM',
            'address' => 'ICLAN Central Diagnostic Wing, Akwa, Douala',
            'notes' => 'Patient presented with acute intermittent chills and fatigue. Stat turnaround.',
            'result_document' => null,
            'result_file_name' => 'Lab_Report_LR-20260827-7712.pdf',
            'result_file_type' => 'application/pdf',
            'result_notes' => "Hematology & Parasitology Findings:\n- Malaria Parasite (QBC): POSITIVE (+), Low Density (1,200 parasites/uL).\n- Full Blood Count: Hemoglobin: 13.2 g/dL (Normal: 12.0-16.0), Total WBC: 6,400 /uL, Platelets: 210,000 /uL.\n- Clinical Note: Mild uncomplicated malaria; standard artemisinin-combination regimen advised.",
            'result_uploaded_at' => now()->subHours(8),
            'delivered_at' => now()->subHours(6),
            'created_at' => now()->subDays(1),
            'updated_at' => now()->subHours(6),
        ]);

        if ($testMalaria) {
            DB::table('lab_request_items')->insert([
                'lab_request_id' => $req1Id,
                'lab_test_id' => $testMalaria->id,
                'test_name' => $testMalaria->name,
                'price' => $testMalaria->price,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ]);
        }

        if ($testCBC) {
            DB::table('lab_request_items')->insert([
                'lab_request_id' => $req1Id,
                'lab_test_id' => $testCBC->id,
                'test_name' => $testCBC->name,
                'price' => $testCBC->price,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ]);
        }

        // 2. In Progress / Sample Collected Lab Request
        $req2Id = DB::table('lab_reqests')->insertGetId([
            'request_number' => 'LR-20260828-3310',
            'user_id' => $patientUser->id,
            'patient_id' => $patient->id,
            'payment_id' => null,
            'total_amount' => 11500.00,
            'status' => 'sample_collected',
            'payment_status' => 'paid',
            'payment_method' => 'momo',
            'sample_type' => 'Serum & Plasma (Fasting Blood)',
            'scheduled_date' => date('Y-m-d'),
            'scheduled_time' => '09:00 AM',
            'address' => 'Home Sample Collection: Boulevard de la Liberté, Akwa',
            'notes' => 'Annual cardiovascular & metabolic routine screening.',
            'result_document' => null,
            'result_file_name' => null,
            'result_file_type' => null,
            'result_notes' => null,
            'result_uploaded_at' => null,
            'delivered_at' => null,
            'created_at' => now()->subHours(3),
            'updated_at' => now()->subHours(1),
        ]);

        if ($testSugar) {
            DB::table('lab_request_items')->insert([
                'lab_request_id' => $req2Id,
                'lab_test_id' => $testSugar->id,
                'test_name' => $testSugar->name,
                'price' => $testSugar->price,
                'created_at' => now()->subHours(3),
                'updated_at' => now()->subHours(3),
            ]);
        }

        if ($testLipid) {
            DB::table('lab_request_items')->insert([
                'lab_request_id' => $req2Id,
                'lab_test_id' => $testLipid->id,
                'test_name' => $testLipid->name,
                'price' => $testLipid->price,
                'created_at' => now()->subHours(3),
                'updated_at' => now()->subHours(3),
            ]);
        }

        // 3. Pending Appointment Lab Request
        $req3Id = DB::table('lab_reqests')->insertGetId([
            'request_number' => 'LR-20260828-9481',
            'user_id' => $patientUser->id,
            'patient_id' => $patient->id,
            'payment_id' => null,
            'total_amount' => 4000.00,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => 'cash_on_delivery',
            'sample_type' => 'Serum Blood Draw',
            'scheduled_date' => date('Y-m-d', strtotime('+1 day')),
            'scheduled_time' => '10:15 AM',
            'address' => 'ICLAN Central Diagnostic Wing, Akwa, Douala',
            'notes' => 'Widal agglutination test for suspected enteric fever.',
            'result_document' => null,
            'result_file_name' => null,
            'result_file_type' => null,
            'result_notes' => null,
            'result_uploaded_at' => null,
            'delivered_at' => null,
            'created_at' => now()->subMinutes(45),
            'updated_at' => now()->subMinutes(45),
        ]);

        if ($testWidal) {
            DB::table('lab_request_items')->insert([
                'lab_request_id' => $req3Id,
                'lab_test_id' => $testWidal->id,
                'test_name' => $testWidal->name,
                'price' => $testWidal->price,
                'created_at' => now()->subMinutes(45),
                'updated_at' => now()->subMinutes(45),
            ]);
        }
    }
}

