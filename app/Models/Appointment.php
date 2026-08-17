<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\DoctorSchedule;
use App\Models\Payment;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'schedule_id',
        'payment_id',
        'reason',
        'status',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctorschedule()
    {
        return $this->belongsTo(DoctorSchedule::class);
    }
    public function payment()
    {
    return $this->belongsTo(Payment::class, 'payment_id');
    }

    protected static function booted()
    {
        static::updated(function ($appointment) {
            $changes = array_diff(array_keys($appointment->getChanges()), ['updated_at']);

            if (empty($changes) || ! $appointment->patient_id) {
                return;
            }

            $title = 'Consultation updated';
            $message = 'Your consultation appointment was updated.';

            if ($appointment->wasChanged('status')) {
                $title = 'Consultation status changed';
                $message = "Your consultation status is now '{$appointment->status}'.";
            }

            if ($appointment->wasChanged('reason')) {
                $title = 'Consultation reason updated';
                $message = "Your consultation reason is now '{$appointment->reason}'.";
            }

            if ($appointment->wasChanged('schedule_id')) {
                $doctorName = $appointment->doctor?->user?->name ?? 'your doctor';
                $title = 'Consultation schedule updated';
                $message = "Your consultation with {$doctorName} was rescheduled.";
            }

            Notification::create([
                'patient_id' => $appointment->patient_id,
                'doctor_id' => $appointment->doctor_id,
                'appointment_id' => $appointment->id,
                'title' => $title,
                'message' => $message,
                'type' => 'consultation',
                'is_read' => false,
            ]);
        });
    }
}
