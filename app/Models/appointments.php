<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;

class appointments extends Model
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

    public function doctor_schedule()
    {
        return $this->belongsTo(doctor_schedule::class, 'schedule_id');
    }

    public function payment()
    {
        return $this->belongsTo(payment::class, 'payment_id');
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
                $doctorName = $appointment->doctor?->doctor_name ?? 'your doctor';
                $title = 'Consultation schedule updated';
                $message = "Your consultation with Dr. {$doctorName} was rescheduled.";
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
