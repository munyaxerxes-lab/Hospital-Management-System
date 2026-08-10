<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function runs(): void
    {
        // User::factory(10)->create();

        //User::factory()->create([
          //  'name' => 'Test User',
            //'email' => 'test@example.com',
        //]);

        $this->call(MedicineSeeder::class);
    }
     public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            HospitalSeeder::class,
            SpecialtySeeder::class,
            MedicineCategorySeeder::class,
            LabTestSeeder::class,

            UserSeeder::class,

            PatientSeeder::class,
            DoctorSeeder::class,
            PharmacistSeeder::class,
            LaboratoryTechnicianSeeder::class,
            DeliveryAgentSeeder::class,

            DoctorSpecialtySeeder::class,
            DoctorScheduleSeeder::class,

            PaymentSeeder::class,
            AppointmentSeeder::class,

            MedicineSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            DeliverySeeder::class,

            LabRequestSeeder::class,
            LabRequestItemSeeder::class,
            Lab_ResultSeeder::class,
        ]);
    }
}
