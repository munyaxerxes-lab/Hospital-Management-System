<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = "doctors";
    protected $fillable = [
        'doctor_name',
        'specialty',
        'qualification',
        'years_of_experience',
        'consultation_fee',
        'username',
        'status',
        'avatar',
    ];

    protected $casts = [
        'years_of_experience' => 'integer',
        'consultation_fee' => 'decimal:2',
    ];

    public function schedules()
    {
        return $this->hasMany(doctor_schedule::class, 'doctor_id');
    }
}