<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class doctor_schedule extends Model
{
    //
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointments::class);
    }
}
