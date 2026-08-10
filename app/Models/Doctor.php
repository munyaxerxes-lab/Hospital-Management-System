<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);

    }
    public function doctor_schedule()
    {
        return $this->hasMany(Doctor_schedule::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointments::class);
    }
}
