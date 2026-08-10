<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Lab_ResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('lab_results')->insert([
    [
        'request_id' => 1,
        'laboratory_technician_id' => 1,
        'report_file' => 'lab-results/request-1.pdf',
        'remarks' => 'Results uploaded and reviewed.',
        'uploaded_at' => now(),
    ],
]);
    }
}
