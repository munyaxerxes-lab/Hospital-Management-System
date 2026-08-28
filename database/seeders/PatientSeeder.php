<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patientUsers = [
            [
                'email' => 'patient@medilink.com',
                'gender' => 'Male',
                'dob' => '1992-07-14',
                'address' => 'Boulevard de la Liberté, Akwa, Douala',
            ],
            [
                'email' => 'john@example.com',
                'gender' => 'Male',
                'dob' => '1995-11-20',
                'address' => 'Bonaberi Ancienne Route, Douala',
            ],
            [
                'email' => 'claire.fongang@gmail.com',
                'gender' => 'Female',
                'dob' => '1998-04-03',
                'address' => 'Bastos Avenue, Yaoundé',
            ],
            [
                'email' => 'paul.nguema@gmail.com',
                'gender' => 'Male',
                'dob' => '1988-09-25',
                'address' => 'Molyko Commercial Avenue, Buea',
            ],
            [
                'email' => 'vanessa.ngo@gmail.com',
                'gender' => 'Female',
                'dob' => '2001-12-10',
                'address' => 'Makepe Rhone Poulenc, Douala',
            ],
        ];

        foreach ($patientUsers as $p) {
            $user = User::where('email', $p['email'])->first();
            if ($user) {
                DB::table('patient')->updateOrInsert(
                    ['user_id' => $user->id],
                    [
                        'gender' => $p['gender'],
                        'dob' => $p['dob'],
                        'address' => $p['address'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}

