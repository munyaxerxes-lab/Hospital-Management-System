<?php

namespace Database\Seeders;

use App\Models\medicine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        medicine::create([
            'name' => 'Paracetamol',
            'description' => 'Pain relief tablets',
            'price' => 1000,
            'stock' => 10,
            'image' => '/image/pharma3.png',
        ]);

        medicine::create([
            'name' => 'Ibuprofen',
            'description' => 'Anti-inflammatory capsules',
            'price' => 1200,
            'stock' => 8,
            'image' => '/image/pharma.png',
        ]);

        medicine::create([
            'name' => 'Amoxicillin',
            'description' => 'Antibiotic capsules',
            'price' => 1500,
            'stock' => 5,
            'image' => '/image/pharma3.png',
        ]);
    }
}
