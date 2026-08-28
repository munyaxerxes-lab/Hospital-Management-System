<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Patient;
use App\Models\Delivery;
use App\Models\DeliveryAgent;
use Illuminate\Support\Facades\DB;

class PharmacySampleSeeder extends Seeder
{
    public function run()
    {
        $medsData = [
            [
                'id' => 1,
                'name' => 'Amoxicillin 500mg',
                'type' => 'Capsules',
                'category_id' => 2,
                'stock' => 120,
                'status' => true,
                'expiry_date' => '2027-05-15',
                'price' => 2500,
                'description' => 'Broad-spectrum penicillin antibiotic used to treat acute bacterial respiratory and ENT infections.',
                'image' => '/image/pharma3.png'
            ],
            [
                'id' => 2,
                'name' => 'Paracetamol Extra 500mg',
                'type' => 'Tablets',
                'category_id' => 1,
                'stock' => 85,
                'status' => true,
                'expiry_date' => '2027-11-20',
                'price' => 1000,
                'description' => 'Fast-acting pain reliever and antipyretic for headaches, body aches, and fever reduction.',
                'image' => '/image/pharma.png'
            ],
            [
                'id' => 3,
                'name' => 'Artemether-Lumefantrine 80/480mg (Coartem)',
                'type' => 'Tablets',
                'category_id' => 3,
                'stock' => 60,
                'status' => true,
                'expiry_date' => '2027-08-30',
                'price' => 3500,
                'description' => 'First-line Artemisinin-based combination therapy (ACT) for uncomplicated Plasmodium falciparum malaria.',
                'image' => '/image/med.png'
            ],
            [
                'id' => 4,
                'name' => 'Cough & Chest Syrup 150ml',
                'type' => 'Syrup',
                'category_id' => 4,
                'stock' => 35,
                'status' => true,
                'expiry_date' => '2026-12-30',
                'price' => 3200,
                'description' => 'Expectorant and bronchodilator syrup for relief of productive cough and chest congestion.',
                'image' => '/image/pharma3.png'
            ],
            [
                'id' => 5,
                'name' => 'Ceftriaxone Injection 1g',
                'type' => 'Injection',
                'category_id' => 7,
                'stock' => 25,
                'status' => true,
                'expiry_date' => '2027-02-10',
                'price' => 4500,
                'description' => 'Third-generation cephalosporin sterile injectable antibiotic for severe clinical bacterial infections.',
                'image' => '/image/pharma.png'
            ],
            [
                'id' => 6,
                'name' => 'Ibuprofen 400mg',
                'type' => 'Tablets',
                'category_id' => 1,
                'stock' => 50,
                'status' => true,
                'expiry_date' => '2027-09-15',
                'price' => 1800,
                'description' => 'Non-steroidal anti-inflammatory drug (NSAID) for inflammation, arthritis, and muscular discomfort.',
                'image' => '/image/pharma.png'
            ],
            [
                'id' => 7,
                'name' => 'Vitamin C + Zinc 1000mg Effervescent',
                'type' => 'Tablets',
                'category_id' => 5,
                'stock' => 40,
                'status' => true,
                'expiry_date' => '2028-04-10',
                'price' => 4000,
                'description' => 'Immune defense booster formulation with high-potency ascorbic acid and elemental zinc.',
                'image' => '/image/med.png'
            ],
            [
                'id' => 8,
                'name' => 'Omeprazole 20mg Gastro-Resistant',
                'type' => 'Capsules',
                'category_id' => 6,
                'stock' => 45,
                'status' => true,
                'expiry_date' => '2027-10-05',
                'price' => 3000,
                'description' => 'Proton pump inhibitor (PPI) for gastric acid suppression, peptic ulcer, and GERD acid reflux.',
                'image' => '/image/pharma3.png'
            ],
            [
                'id' => 9,
                'name' => 'Ciprofloxacin 500mg',
                'type' => 'Tablets',
                'category_id' => 2,
                'stock' => 30,
                'status' => true,
                'expiry_date' => '2027-06-25',
                'price' => 2800,
                'description' => 'Fluoroquinolone antibiotic for urinary tract, typhoid, and gastrointestinal infections.',
                'image' => '/image/pharma.png'
            ],
            [
                'id' => 10,
                'name' => 'Sterile Cotton Wool 500g',
                'type' => 'Cotton',
                'category_id' => 8,
                'stock' => 50,
                'status' => true,
                'expiry_date' => '2029-01-01',
                'price' => 1500,
                'description' => '100% pure absorbent medical grade surgical cotton for wound dressing and clinical hygiene.',
                'image' => '/image/med.png'
            ],
            [
                'id' => 11,
                'name' => 'Digital Infrared Forehead Thermometer',
                'type' => 'Medical Device',
                'category_id' => 8,
                'stock' => 15,
                'status' => true,
                'expiry_date' => '2030-01-01',
                'price' => 12000,
                'description' => 'Non-contact high accuracy digital clinical thermometer with color-coded LCD fever alarm.',
                'image' => '/image/bp.png'
            ],
            [
                'id' => 12,
                'name' => 'Automatic Upper Arm BP Monitor',
                'type' => 'Medical Device',
                'category_id' => 8,
                'stock' => 10,
                'status' => true,
                'expiry_date' => '2030-01-01',
                'price' => 25000,
                'description' => 'Accurate digital oscillometric blood pressure and pulse rate monitor with irregular heartbeat detector.',
                'image' => '/image/bp.png'
            ],
        ];

        // Seed both `medicine` and `medicines` tables
        foreach ($medsData as $m) {
            DB::table('medicine')->updateOrInsert(
                ['name' => $m['name']],
                [
                    'type' => $m['type'],
                    'stock' => $m['stock'],
                    'status' => $m['status'],
                    'expiry_date' => $m['expiry_date'] . ' 00:00:00',
                    'price' => $m['price'],
                    'description' => $m['description'],
                    'image' => $m['image'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            DB::table('medicines')->updateOrInsert(
                ['name' => $m['name']],
                [
                    'category_id' => $m['category_id'],
                    'description' => $m['description'],
                    'price' => $m['price'],
                    'expiry_date' => $m['expiry_date'],
                    'stock_quantity' => $m['stock'],
                    'stock' => $m['stock'],
                    'image' => $m['image'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $patientUser = User::where('email', 'patient@medilink.com')->first() ?? User::where('role_id', 1)->first() ?? User::first();
        $patient = $patientUser ? Patient::firstOrCreate(['user_id' => $patientUser->id], [
            'gender' => 'Male',
            'dob' => '1992-07-14',
            'address' => 'Boulevard de la Liberté, Akwa, Douala',
        ]) : null;

        $agent = DeliveryAgent::first();

        if ($patient && $patientUser) {
            OrderItem::query()->delete();
            Delivery::query()->delete();
            Order::query()->delete();

            $med1 = DB::table('medicine')->where('name', 'Amoxicillin 500mg')->first();
            $med2 = DB::table('medicine')->where('name', 'Paracetamol Extra 500mg')->first();
            $med3 = DB::table('medicine')->where('name', 'Artemether-Lumefantrine 80/480mg (Coartem)')->first();
            $med4 = DB::table('medicine')->where('name', 'Cough & Chest Syrup 150ml')->first();
            $med7 = DB::table('medicine')->where('name', 'Vitamin C + Zinc 1000mg Effervescent')->first();
            $med10 = DB::table('medicine')->where('name', 'Sterile Cotton Wool 500g')->first();
            $med11 = DB::table('medicine')->where('name', 'Digital Infrared Forehead Thermometer')->first();

            // 1. Delivered Order
            $ord1 = Order::create([
                'order_number' => 'ORD-20260827-8492',
                'user_id' => $patientUser->id,
                'patient_id' => $patient->id,
                'total_amount' => 6000,
                'status' => 'delivered',
                'payment_status' => 'paid',
                'payment_method' => 'cash_on_delivery',
                'shipping_address' => 'Room 204, East Ward, ICLAN Central Hospital Douala',
                'notes' => 'Urgent post-consultation medication package',
                'delivered_at' => now()->subHours(4),
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subHours(4),
            ]);

            if ($med1) {
                OrderItem::create([
                    'order_id' => $ord1->id,
                    'medicine_id' => $med1->id,
                    'quantity' => 2,
                    'unit_price' => $med1->price,
                    'total_price' => $med1->price * 2,
                    'created_at' => now()->subDays(1),
                    'updated_at' => now()->subDays(1),
                ]);
            }

            if ($med2) {
                OrderItem::create([
                    'order_id' => $ord1->id,
                    'medicine_id' => $med2->id,
                    'quantity' => 1,
                    'unit_price' => $med2->price,
                    'total_price' => $med2->price,
                    'created_at' => now()->subDays(1),
                    'updated_at' => now()->subDays(1),
                ]);
            }

            if ($agent) {
                Delivery::create([
                    'order_id' => $ord1->id,
                    'agent_id' => $agent->id,
                    'created_at' => now()->subHours(6),
                    'updated_at' => now()->subHours(4),
                ]);
            }

            // 2. In Transit / Processing Order
            $ord2 = Order::create([
                'order_number' => 'ORD-20260828-1033',
                'user_id' => $patientUser->id,
                'patient_id' => $patient->id,
                'total_amount' => 10700,
                'status' => 'in_transit',
                'payment_status' => 'paid',
                'payment_method' => 'momo',
                'shipping_address' => 'Avenue Charles de Gaulle, Akwa, Douala',
                'notes' => 'Call on arrival: +237 671 234 501',
                'delivered_at' => null,
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(1),
            ]);

            if ($med3) {
                OrderItem::create([
                    'order_id' => $ord2->id,
                    'medicine_id' => $med3->id,
                    'quantity' => 1,
                    'unit_price' => $med3->price,
                    'total_price' => $med3->price,
                    'created_at' => now()->subHours(2),
                    'updated_at' => now()->subHours(2),
                ]);
            }

            if ($med4) {
                OrderItem::create([
                    'order_id' => $ord2->id,
                    'medicine_id' => $med4->id,
                    'quantity' => 1,
                    'unit_price' => $med4->price,
                    'total_price' => $med4->price,
                    'created_at' => now()->subHours(2),
                    'updated_at' => now()->subHours(2),
                ]);
            }

            if ($med7) {
                OrderItem::create([
                    'order_id' => $ord2->id,
                    'medicine_id' => $med7->id,
                    'quantity' => 1,
                    'unit_price' => $med7->price,
                    'total_price' => $med7->price,
                    'created_at' => now()->subHours(2),
                    'updated_at' => now()->subHours(2),
                ]);
            }

            if ($agent) {
                Delivery::create([
                    'order_id' => $ord2->id,
                    'agent_id' => $agent->id,
                    'created_at' => now()->subHours(1),
                    'updated_at' => now()->subHours(1),
                ]);
            }

            // 3. Pending Order
            $ord3 = Order::create([
                'order_number' => 'ORD-20260828-5921',
                'user_id' => $patientUser->id,
                'patient_id' => $patient->id,
                'total_amount' => 13500,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => 'cash_on_delivery',
                'shipping_address' => 'Hospital Pharmacy Express Counter Pickup',
                'notes' => 'First aid kit supplies & digital thermometer',
                'delivered_at' => null,
                'created_at' => now()->subMinutes(30),
                'updated_at' => now()->subMinutes(30),
            ]);

            if ($med11) {
                OrderItem::create([
                    'order_id' => $ord3->id,
                    'medicine_id' => $med11->id,
                    'quantity' => 1,
                    'unit_price' => $med11->price,
                    'total_price' => $med11->price,
                    'created_at' => now()->subMinutes(30),
                    'updated_at' => now()->subMinutes(30),
                ]);
            }

            if ($med10) {
                OrderItem::create([
                    'order_id' => $ord3->id,
                    'medicine_id' => $med10->id,
                    'quantity' => 1,
                    'unit_price' => $med10->price,
                    'total_price' => $med10->price,
                    'created_at' => now()->subMinutes(30),
                    'updated_at' => now()->subMinutes(30),
                ]);
            }
        }
    }
}

