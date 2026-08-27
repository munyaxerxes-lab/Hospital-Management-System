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
                'category' => 'Parasitology',
                'description' => 'Malaria parasite examination',
                'preparation' => 'No special preparation needed',
                'price' => 3000,
                'image' => '/image/malaria.png',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Full Blood Count',
                'category' => 'Hematology',
                'description' => 'Complete blood cell analysis',
                'preparation' => 'Fasting not required',
                'price' => 5000,
                'image' => '/image/bp.png',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Blood Sugar',
                'category' => 'Biochemistry',
                'description' => 'Blood glucose test',
                'preparation' => '8 hours overnight fasting',
                'price' => 2500,
                'image' => '/image/hypertension.png',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
