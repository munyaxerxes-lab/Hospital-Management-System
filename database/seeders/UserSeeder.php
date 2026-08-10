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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role_id' => 1,
        ]);
        DB::table('users')->insert([
    [
        'role_id' => 1,
        'first_name' => 'Admin',
        'last_name' => 'ICLAN',
        'email' => 'admin@iclan.cm',
        'phone' => '670000001',
        'password' => Hash::make('password'),
        'created_at' => now(),
        'updated_at' => now(),
    ],

    [
        'role_id' => 2,
        'first_name' => 'John',
        'last_name' => 'Mbi',
        'email' => 'john@example.com',
        'phone' => '670000002',
        'password' => Hash::make('password'),
        'created_at' => now(),
        'updated_at' => now(),
    ],

    [
        'role_id' => 3,
        'first_name' => 'Sarah',
        'last_name' => 'Ngono',
        'email' => 'sarah@iclan.cm',
        'phone' => '670000003',
        'password' => Hash::make('password'),
        'created_at' => now(),
        'updated_at' => now(),
    ],

    [
        'role_id' => 4,
        'first_name' => 'Peter',
        'last_name' => 'Fongang',
        'email' => 'peter@iclan.cm',
        'phone' => '670000004',
        'password' => Hash::make('password'),
        'created_at' => now(),
        'updated_at' => now(),
    ],

    [
        'role_id' => 5,
        'first_name' => 'Mary',
        'last_name' => 'Tambe',
        'email' => 'mary@iclan.cm',
        'phone' => '670000005',
        'password' => Hash::make('password'),
        'created_at' => now(),
        'updated_at' => now(),
    ],

    [
        'role_id' => 6,
        'first_name' => 'David',
        'last_name' => 'Etoa',
        'email' => 'david@iclan.cm',
        'phone' => '670000006',
        'password' => Hash::make('password'),
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}
