<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryAgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('delivery_agents')->insert([
    [
        'user_id' => 6,
        'vehicle_type' => 'Motorbike',
        'status' => 'available',
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}
