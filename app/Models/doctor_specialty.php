<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class doctor_specialty extends Model
{
    protected $table = 'doctor_specialties';

    protected $fillable = [
        'doctor_id',
        'specialty_id',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function specialty()
    {
        return $this->belongsTo(specialty::class, 'specialty_id');
    }
}
