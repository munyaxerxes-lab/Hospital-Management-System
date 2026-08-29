<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'name' => 'patient'],
            ['id' => 2, 'doctor' => 'doctor', 'name' => 'doctor'],
            ['id' => 3, 'name' => 'admin'],
            ['id' => 4, 'name' => 'pharmacist'],
            ['id' => 5, 'name' => 'lab_technician'],
            ['id' => 6, 'name' => 'delivery_agent'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['id' => $role['id']],
                [
                    'name' => $role['name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}