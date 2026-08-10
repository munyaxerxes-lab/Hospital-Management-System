<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabRequestItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lab_request_items')->insert([
    [
        'request_id' => 1,
        'test_id' => 1,
        'quantity' => 1,
    ],
    [
        'request_id' => 1,
        'test_id' => 2,
        'quantity' => 1,
    ],
]);
    }
}
