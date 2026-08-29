<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicineCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['id' => 1, 'name' => 'Pain Relief & Analgesics'],
            ['id' => 2, 'name' => 'Antibiotics'],
            ['id' => 3, 'name' => 'Antimalarials'],
            ['id' => 4, 'name' => 'Cold, Cough & Respiratory'],
            ['id' => 5, 'name' => 'Vitamins & Dietary Supplements'],
            ['id' => 6, 'name' => 'Digestive & Gastrointestinal'],
            ['id' => 7, 'name' => 'Injections & Infusions'],
            ['id' => 8, 'name' => 'First Aid & Medical Devices'],
        ];

        foreach ($categories as $cat) {
            DB::table('medicine_categories')->updateOrInsert(
                ['id' => $cat['id']],
                array_merge($cat, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}

