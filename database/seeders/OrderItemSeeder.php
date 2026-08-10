<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('order_items')->insert([
    [
        'order_id' => 1,
        'medicine_id' => 1,
        'quantity' => 2,
        'unit_price' => 500,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'order_id' => 1,
        'medicine_id' => 3,
        'quantity' => 1,
        'unit_price' => 2500,
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}
