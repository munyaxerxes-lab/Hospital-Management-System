<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('delivery')->insert([
    [
        'order_id' => 1,
        'agent_id' => 1,
        'delivery_address' => 'Bonaberi, Douala',
        'latitude' => 4.0750,
        'longitude' => 9.6820,
        'status' => 'assigned',
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}
