<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Lab_ResultSeeder extends Seeder
{
    public function run(): void
    {
        $tech = DB::table('lab_technician')->first();
        $req = DB::table('lab_reqests')->where('status', 'completed')->first() ?? DB::table('lab_reqests')->first();

        if ($req && $tech) {
            DB::table('lab_results')->updateOrInsert(
                ['request_id' => $req->id],
                [
                    'laboratory_technician_id' => $tech->id,
                    'created_at' => now()->subHours(8),
                    'updated_at' => now()->subHours(8),
                ]
            );
        }
    }
}

