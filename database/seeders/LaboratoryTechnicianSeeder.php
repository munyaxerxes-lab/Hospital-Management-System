<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaboratoryTechnicianSeeder extends Seeder
{
    public function run(): void
    {
        $technicians = [
            [
                'email' => 'labtech@medilink.com',
                'hospital_id' => 1,
                'license_number' => 'LT-CM-2021-0453',
                'employee_id' => 'EMP-LAB-001',
                'position' => 'Lead Medical Laboratory Scientist',
                'years_of_experience' => 10,
                'bio' => 'Certified biomedical laboratory specialist with expertise in hematology, parasitology, and automated immunoassays.',
                'address' => 'Akwa Nord, Douala',
            ],
            [
                'email' => 'alain@iclan.cm',
                'hospital_id' => 2,
                'license_number' => 'LT-CM-2023-0882',
                'employee_id' => 'EMP-LAB-002',
                'position' => 'Clinical Pathology Technician',
                'years_of_experience' => 6,
                'bio' => 'Experienced in clinical chemistry, biochemical analysis, and microbiological sampling.',
                'address' => 'Biyem-Assi, Yaoundé',
            ],
        ];

        foreach ($technicians as $tech) {
            $user = User::where('email', $tech['email'])->first();
            if ($user) {
                DB::table('lab_technician')->updateOrInsert(
                    ['user_id' => $user->id],
                    [
                        'hospital_id' => $tech['hospital_id'],
                        'license_number' => $tech['license_number'],
                        'employee_id' => $tech['employee_id'],
                        'position' => $tech['position'],
                        'years_of_experience' => $tech['years_of_experience'],
                        'bio' => $tech['bio'],
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'address' => $tech['address'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}

