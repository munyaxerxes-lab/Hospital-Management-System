<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = "doctor";
    protected $fillable = [
        'doctor_name',
        'specialty',
        'qualification',
        'years_of_experience',
        'consultation_fee',
        'username',
        'status',
    ];

    protected $casts = [
        'years_of_experience' => 'integer',
        'consultation_fee' => 'decimal:2',
    ];
}