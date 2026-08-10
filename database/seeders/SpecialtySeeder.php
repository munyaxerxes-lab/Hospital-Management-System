<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
         DB::table('specialties')->insert([
            ['name' => 'Cardiology'],
            ['name' => 'Pediatrics'],
            ['name' => 'General Medicine'],
            ['name' => 'Dermatology'],
            ['name' => 'Gynecology'],
            ['name' => 'Neurology'],
        ]);
    }
}
