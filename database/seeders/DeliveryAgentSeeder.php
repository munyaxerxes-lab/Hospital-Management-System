<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryAgentSeeder extends Seeder
{
    public function run(): void
    {
        $agents = [
            [
                'email' => 'delivery@medilink.com',
                'vehicle_type' => 'Yamaha Express Motorbike (LT-892-AA)',
                'status' => 'available',
            ],
            [
                'email' => 'samuel@iclan.cm',
                'vehicle_type' => 'Toyota Hiace Temperature-Controlled Van (CE-455-BB)',
                'status' => 'available',
            ],
        ];

        foreach ($agents as $agent) {
            $user = User::where('email', $agent['email'])->first();
            if ($user) {
                DB::table('delivery_agents')->updateOrInsert(
                    ['user_id' => $user->id],
                    [
                        'vehicle_type' => $agent['vehicle_type'],
                        'status' => $agent['status'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}

