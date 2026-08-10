<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('payments')->insert([
    [
        'patient_id' => 1,
        'amount' => 5000,
        'payment_method' => 'MTN_MOMO',
        'transaction_reference' => 'MTN-001-2026',
        'status' => 'successful',
        'paid_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}
