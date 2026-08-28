<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class doctor_schedule extends Model
{
    protected $table = 'doctor_schedule';

    protected $fillable = [
        'doctor_id',
        'date',
        'start_time',
        'end_time',
        'price',
        'status',
        'reason',
    ];

    protected $casts = [
        'date' => 'date',
        'price' => 'decimal:2',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function appointments()
    {
        return $this->hasMany(appointments::class, 'schedule_id');
    }
}
