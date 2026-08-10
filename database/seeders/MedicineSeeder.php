<?php

namespace Database\Seeders;

use App\Models\medicine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
    
    DB::table('medicines')->insert([
    [
        'category_id' => 1,
        'name' => 'Paracetamol 500mg',
        'description' => 'Pain and fever relief',
        'price' => 500,
        'expiry_date' => '2027-12-31',
        'stock_quantity' => 100,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'category_id' => 1,
        'name' => 'Ibuprofen 400mg',
        'description' => 'Pain and inflammation relief',
        'price' => 1000,
        'expiry_date' => '2027-10-31',
        'stock_quantity' => 75,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'category_id' => 3,
        'name' => 'Vitamin C 500mg',
        'description' => 'Vitamin C supplement',
        'price' => 2500,
        'expiry_date' => '2028-03-31',
        'stock_quantity' => 50,
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}
