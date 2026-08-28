<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        $users = [
            // Admin accounts (role_id = 3)
            [
                'name' => 'System Administrator',
                'email' => 'admin@medilink.com',
                'phone' => '+237 670 000 000',
                'role_id' => 3,
                'password' => $password,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'ICLAN Admin',
                'email' => 'admin@iclan.cm',
                'phone' => '+237 670 000 001',
                'role_id' => 3,
                'password' => $password,
                'email_verified_at' => now(),
            ],

            // Patient accounts (role_id = 1)
            [
                'name' => 'John Mbi',
                'email' => 'patient@medilink.com',
                'phone' => '+237 671 234 501',
                'role_id' => 1,
                'password' => $password,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'John Mbi',
                'email' => 'john@example.com',
                'phone' => '+237 671 234 502',
                'role_id' => 1,
                'password' => $password,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Claire Fongang',
                'email' => 'claire.fongang@gmail.com',
                'phone' => '+237 699 123 456',
                'role_id' => 1,
                'password' => $password,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Paul Nguema',
                'email' => 'paul.nguema@gmail.com',
                'phone' => '+237 675 889 900',
                'role_id' => 1,
                'password' => $password,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Vanessa Ngo',
                'email' => 'vanessa.ngo@gmail.com',
                'phone' => '+237 650 334 455',
                'role_id' => 1,
                'password' => $password,
                'email_verified_at' => now(),
            ],

            // Doctor accounts (role_id = 2)
            [
                'name' => 'Dr. John Doe',
                'email' => 'doctor@medilink.com',
                'phone' => '+237 672 111 001',
                'role_id' => 2,
                'password' => $password,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dr. John Doe',
                'email' => 'johndoe@hospital.cm',
                'phone' => '+237 672 111 002',
                'role_id' => 2,
                'password' => $password,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dr. Sarah Jenkins',
                'email' => 'sarah@hospital.cm',
                'phone' => '+237 673 222 003',
                'role_id' => 2,
                'password' => $password,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dr. Michael Chen',
                'email' => 'michael@hospital.cm',
                'phone' => '+237 674 333 004',
                'role_id' => 2,
                'password' => $password,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dr. Jane Smith',
                'email' => 'jane@hospital.cm',
                'phone' => '+237 675 444 005',
                'role_id' => 2,
                'password' => $password,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dr. David Mbarga',
                'email' => 'david.mbarga@hospital.cm',
                'phone' => '+237 676 555 006',
                'role_id' => 2,
                'password' => $password,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dr. Grace Enow',
                'email' => 'grace.enow@hospital.cm',
                'phone' => '+237 677 666 007',
                'role_id' => 2,
                'password' => $password,
                'email_verified_at' => now(),
            ],

            // Pharmacist accounts (role_id = 4)
            [
                'name' => 'Peter Fongang',
                'email' => 'pharmacist@medilink.com',
                'phone' => '+237 678 777 008',
                'role_id' => 4,
                'password' => $password,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Marie Claire',
                'email' => 'marie@iclan.cm',
                'phone' => '+237 679 888 009',
                'role_id' => 4,
                'password' => $password,
                'email_verified_at' => now(),
            ],

            // Lab Technician accounts (role_id = 5)
            [
                'name' => 'Mary Tambe',
                'email' => 'labtech@medilink.com',
                'phone' => '+237 680 999 010',
                'role_id' => 5,
                'password' => $password,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Alain Ngue',
                'email' => 'alain@iclan.cm',
                'phone' => '+237 681 000 011',
                'role_id' => 5,
                'password' => $password,
                'email_verified_at' => now(),
            ],

            // Delivery Agent accounts (role_id = 6)
            [
                'name' => 'David Etoa',
                'email' => 'delivery@medilink.com',
                'phone' => '+237 682 111 012',
                'role_id' => 6,
                'password' => $password,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Samuel Kamga',
                'email' => 'samuel@iclan.cm',
                'phone' => '+237 683 222 013',
                'role_id' => 6,
                'password' => $password,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $u) {
            DB::table('users')->updateOrInsert(
                ['email' => $u['email']],
                array_merge($u, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}

