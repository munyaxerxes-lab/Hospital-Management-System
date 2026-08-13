<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'role_id' => 1,
            'password' => Hash::make('password'),
        ]);
        $users = [
            [
                'role_id' => 1,
                'name' => 'Admin ICLAN',
                'email' => 'admin@iclan.cm',
                'phone' => '670000001',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'role_id' => 2,
                'name' => 'John Mbi',
                'email' => 'john@example.com',
                'phone' => '670000002',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'role_id' => 3,
                'name' => 'Sarah Ngono',
                'email' => 'sarah@iclan.cm',
                'phone' => '670000003',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'role_id' => 4,
                'name' => 'Peter Fongang',
                'email' => 'peter@iclan.cm',
                'phone' => '670000004',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'role_id' => 5,
                'name' => 'Mary Tambe',
                'email' => 'mary@iclan.cm',
                'phone' => '670000005',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'role_id' => 6,
                'name' => 'David Etoa',
                'email' => 'david@iclan.cm',
                'phone' => '670000006',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($users as $u) {
            DB::table('users')->updateOrInsert([
                'email' => $u['email'],
            ], $u);
        }
        
    }
}
