<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Patient;

class PharmacySampleSeeder extends Seeder
{
    public function run()
    {
        if (Medicine::count() == 0) {
            Medicine::create([
                'name' => 'Amoxicillin 500mg',
                'type' => 'Capsules',
                'stock' => 120,
                'status' => true,
                'expiry_date' => '2027-05-15',
                'price' => 2500,
                'description' => 'Broad-spectrum antibiotic used to treat bacterial infections.',
                'image' => null
            ]);
            Medicine::create([
                'name' => 'Paracetamol Extra 500mg',
                'type' => 'Tablets',
                'stock' => 85,
                'status' => true,
                'expiry_date' => '2027-11-20',
                'price' => 1000,
                'description' => 'Fast-acting pain reliever and fever reducer.',
                'image' => null
            ]);
            Medicine::create([
                'name' => 'Cough & Chest Syrup 150ml',
                'type' => 'Syrup',
                'stock' => 4,
                'status' => true,
                'expiry_date' => '2026-12-30',
                'price' => 3200,
                'description' => 'Soothing cough formula for chest congestion.',
                'image' => null
            ]);
            Medicine::create([
                'name' => 'Ceftriaxone Injection 1g',
                'type' => 'Injection',
                'stock' => 0,
                'status' => true,
                'expiry_date' => '2027-02-10',
                'price' => 4500,
                'description' => 'Sterile injectable antibiotic for acute infections.',
                'image' => null
            ]);
            Medicine::create([
                'name' => 'Sterile Cotton Wool 500g',
                'type' => 'Cotton',
                'stock' => 50,
                'status' => true,
                'expiry_date' => '2029-01-01',
                'price' => 1500,
                'description' => 'High absorbent pure medical grade cotton.',
                'image' => null
            ]);
        }

        $patientUser = User::where('role_id', 1)->first() ?? User::first();
        if ($patientUser) {
            $patient = Patient::firstOrCreate(['user_id' => $patientUser->id]);
            $med1 = Medicine::first();
            $med2 = Medicine::skip(1)->first();
            $med3 = Medicine::skip(2)->first();

            OrderItem::query()->delete();
            Order::query()->delete();

            // 1. Delivered Order
            $ord1 = Order::create([
                'order_number' => 'ORD-20260827-8492',
                'user_id' => $patientUser->id,
                'patient_id' => $patient->id,
                'total_amount' => 5000,
                'status' => 'delivered',
                'payment_status' => 'paid',
                'payment_method' => 'cash_on_delivery',
                'shipping_address' => 'Room 204, East Ward, MediLink Central',
                'notes' => 'Urgent post-op medication pack',
                'delivered_at' => now()->subHours(2),
            ]);
            if ($med1) {
                OrderItem::create([
                    'order_id' => $ord1->id,
                    'medicine_id' => $med1->id,
                    'quantity' => 2,
                    'unit_price' => $med1->price,
                    'total_price' => $med1->price * 2,
                ]);
            }

            // 2. Pending Order
            $ord2 = Order::create([
                'order_number' => 'ORD-20260827-9104',
                'user_id' => $patientUser->id,
                'patient_id' => $patient->id,
                'total_amount' => 4200,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => 'momo',
                'shipping_address' => 'Hospital Pharmacy Counter Pickup',
                'notes' => 'Prescription verification required',
                'delivered_at' => null,
            ]);
            if ($med2) {
                OrderItem::create([
                    'order_id' => $ord2->id,
                    'medicine_id' => $med2->id,
                    'quantity' => 1,
                    'unit_price' => $med2->price,
                    'total_price' => $med2->price * 1,
                ]);
            }
            if ($med3) {
                OrderItem::create([
                    'order_id' => $ord2->id,
                    'medicine_id' => $med3->id,
                    'quantity' => 1,
                    'unit_price' => $med3->price,
                    'total_price' => $med3->price * 1,
                ]);
            }
        }
    }
}
