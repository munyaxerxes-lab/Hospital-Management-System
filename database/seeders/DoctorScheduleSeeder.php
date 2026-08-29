<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = DB::table('doctors')->get();
        if ($doctors->isEmpty()) {
            return;
        }

        $timeSlots = [
            ['start' => '08:00:00', 'end' => '10:00:00', 'reason' => 'Morning Consultation Slot'],
            ['start' => '10:30:00', 'end' => '12:30:00', 'reason' => 'Mid-Day Clinic & Follow-ups'],
            ['start' => '14:00:00', 'end' => '16:00:00', 'reason' => 'Afternoon Specialized Review'],
            ['start' => '16:30:00', 'end' => '18:30:00', 'reason' => 'Evening Urgent & Walk-in Slot'],
        ];

        // Clear existing schedules for clean demo state safely
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('doctor_schedule')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $scheduleId = 1;
        // Generate for today (day 0) and next 6 days
        for ($day = 0; $day <= 6; $day++) {
            $currentDate = date('Y-m-d', strtotime("+{$day} days"));

            foreach ($doctors as $docIndex => $doctor) {
                // Select 2-3 slots per doctor per day
                $selectedSlots = array_slice($timeSlots, ($docIndex + $day) % 2, 2);

                foreach ($selectedSlots as $slotIndex => $slot) {
                    $isBooked = ($day === 0 && $slotIndex === 0) || ($day === 1 && $docIndex === 0);
                    
                    DB::table('doctor_schedule')->insert([
                        'id' => $scheduleId++,
                        'doctor_id' => $doctor->id,
                        'date' => $currentDate,
                        'start_time' => $slot['start'],
                        'end_time' => $slot['end'],
                        'price' => $doctor->consultation_fee ?? 20000.00,
                        'status' => $isBooked ? 'booked' : 'available',
                        'reason' => "{$doctor->specialty} - {$slot['reason']}",
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}

