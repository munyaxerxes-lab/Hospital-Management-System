<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('lab_tests')->insert([
    [
        'name' => 'Malaria Test',
        'description' => 'Malaria parasite examination',
        'price' => 3000,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Full Blood Count',
        'description' => 'Complete blood cell analysis',
        'price' => 5000,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Blood Sugar',
        'description' => 'Blood glucose test',
        'price' => 2500,
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}
