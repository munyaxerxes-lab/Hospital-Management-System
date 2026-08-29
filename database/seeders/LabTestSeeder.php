<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabTestSeeder extends Seeder
{
    public function run(): void
    {
        $tests = [
            [
                'id' => 1,
                'name' => 'Malaria Parasite (QBC & Thick Smear)',
                'category' => 'Parasitology',
                'description' => 'Microscopic detection and parasite density quantification of Plasmodium species in venous blood.',
                'preparation' => 'No special preparation needed. Available 24/7 for acute fever.',
                'price' => 3000.00,
                'image' => '/image/malaria.png',
                'status' => true,
            ],
            [
                'id' => 2,
                'name' => 'Complete Blood Count (CBC / FBC)',
                'category' => 'Hematology',
                'description' => 'Automated differential analysis of red blood cells, white blood cells, hemoglobin, and platelets.',
                'preparation' => 'Fasting not required. Routine venipuncture.',
                'price' => 5000.00,
                'image' => '/image/bp.png',
                'status' => true,
            ],
            [
                'id' => 3,
                'name' => 'Fasting Blood Glucose (Sugar)',
                'category' => 'Biochemistry',
                'description' => 'Quantitative measurement of plasma glucose to screen and monitor diabetes mellitus.',
                'preparation' => 'Requires 8-10 hours of overnight fasting before sample collection.',
                'price' => 2500.00,
                'image' => '/image/hypertension.png',
                'status' => true,
            ],
            [
                'id' => 4,
                'name' => 'Widal Agglutination Test (Typhoid)',
                'category' => 'Serology',
                'description' => 'Qualitative and quantitative detection of Salmonella enterica serotypes Typhi and Paratyphi antibodies.',
                'preparation' => 'No prior fasting required.',
                'price' => 4000.00,
                'image' => '/image/thyphoid.png',
                'status' => true,
            ],
            [
                'id' => 5,
                'name' => 'Lipid Profile Panel',
                'category' => 'Biochemistry',
                'description' => 'Full assessment of Total Cholesterol, HDL, LDL, VLDL, and Triglycerides for cardiovascular risk evaluation.',
                'preparation' => 'Requires 10-12 hours strict fasting before morning blood draw.',
                'price' => 9000.00,
                'image' => '/image/bp.png',
                'status' => true,
            ],
            [
                'id' => 6,
                'name' => 'Comprehensive Liver Function Test (LFT)',
                'category' => 'Biochemistry',
                'description' => 'Serum levels of ALT, AST, Alkaline Phosphatase, Bilirubin (Total & Direct), and Total Protein/Albumin.',
                'preparation' => 'Avoid alcohol 24 hours prior. 8 hours fasting recommended.',
                'price' => 12000.00,
                'image' => '/image/lab1.png',
                'status' => true,
            ],
            [
                'id' => 7,
                'name' => 'Renal / Kidney Function (Urea & Creatinine)',
                'category' => 'Biochemistry',
                'description' => 'Serum blood urea nitrogen (BUN), Creatinine, and estimated Glomerular Filtration Rate (eGFR).',
                'preparation' => 'Adequate hydration. Avoid excessive meat consumption 24h prior.',
                'price' => 10000.00,
                'image' => '/image/lab1.png',
                'status' => true,
            ],
            [
                'id' => 8,
                'name' => 'Urinalysis Routine & Microscopy',
                'category' => 'Microbiology',
                'description' => 'Macroscopic, chemical dipstick, and sediment microscopic analysis of urine sample for infection & renal health.',
                'preparation' => 'Clean-catch midstream morning urine sample preferred.',
                'price' => 2500.00,
                'image' => '/image/malaria.png',
                'status' => true,
            ],
            [
                'id' => 9,
                'name' => 'Hepatitis B Surface Antigen (HBsAg)',
                'category' => 'Serology',
                'description' => 'Immunoassay screening for active Hepatitis B viral infection.',
                'preparation' => 'No special preparation needed.',
                'price' => 4500.00,
                'image' => '/image/lab1.png',
                'status' => true,
            ],
            [
                'id' => 10,
                'name' => 'COVID-19 Real-Time PCR',
                'category' => 'Virology',
                'description' => 'Nasopharyngeal swab molecular amplification test for SARS-CoV-2 with official certificate.',
                'preparation' => 'Do not use nasal sprays within 4 hours before swab.',
                'price' => 15000.00,
                'image' => '/image/lab1.png',
                'status' => true,
            ],
        ];

        foreach ($tests as $t) {
            DB::table('lab_tests')->updateOrInsert(
                ['name' => $t['name']],
                [
                    'category' => $t['category'],
                    'description' => $t['description'],
                    'preparation' => $t['preparation'],
                    'price' => $t['price'],
                    'image' => $t['image'],
                    'status' => $t['status'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}

