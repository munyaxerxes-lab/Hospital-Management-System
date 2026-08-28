<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PharmacistSeeder extends Seeder
{
    public function run(): void
    {
        $pharmacists = [
            [
                'email' => 'pharmacist@medilink.com',
                'hospital_id' => 1,
                'license_number' => 'PH-CM-2022-0941',
                'employee_id' => 'EMP-PH-001',
                'position' => 'Chief Pharmacist',
                'years_of_experience' => 9,
                'bio' => 'Senior clinical pharmacist specializing in pharmacological formulations and stock distribution.',
                'address' => 'Akwa, Douala',
            ],
            [
                'email' => 'marie@iclan.cm',
                'hospital_id' => 2,
                'license_number' => 'PH-CM-2023-1180',
                'employee_id' => 'EMP-PH-002',
                'position' => 'Staff Pharmacist',
                'years_of_experience' => 5,
                'bio' => 'Licensed hospital pharmacist focused on outpatient dispensing and patient medication therapy.',
                'address' => 'Bastos, Yaoundé',
            ],
        ];

        foreach ($pharmacists as $p) {
            $user = User::where('email', $p['email'])->first();
            if ($user) {
                DB::table('pharmacist')->updateOrInsert(
                    ['user_id' => $user->id],
                    [
                        'hospital_id' => $p['hospital_id'],
                        'license_number' => $p['license_number'],
                        'employee_id' => $p['employee_id'],
                        'position' => $p['position'],
                        'years_of_experience' => $p['years_of_experience'],
                        'bio' => $p['bio'],
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'address' => $p['address'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}

