<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicineCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('medicine_categories')->insert([
            
    ['name' => 'Pain Relief'],
    ['name' => 'Antibiotics'],
    ['name' => 'Vitamins'],
    ['name' => 'Cold and Flu'],
    ['name' => 'Digestive Health'],
]       );
    }
}
