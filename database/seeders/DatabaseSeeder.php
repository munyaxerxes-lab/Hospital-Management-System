<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            HospitalSeeder::class,
            SpecialtySeeder::class,
            UserSeeder::class,
            AdminUserSeeder::class,
            PatientSeeder::class,
            DoctorSeeder::class,
            DoctorSpecialtySeeder::class,
            DoctorScheduleSeeder::class,
            PharmacistSeeder::class,
            LaboratoryTechnicianSeeder::class,
            DeliveryAgentSeeder::class,
            MedicineCategorySeeder::class,
            PharmacySampleSeeder::class,
            LabTestSeeder::class,
            AppointmentSeeder::class,
            LabRequestSeeder::class,
            Lab_ResultSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}