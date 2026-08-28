<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patient';

    protected $fillable = [
        'user_id',
        'gender',
        'dob',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(appointments::class, 'patient_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'patient_id');
    }

    public function labRequests()
    {
        return $this->hasMany(LabRequest::class, 'patient_id');
    }

    public function payments()
    {
        return $this->hasMany(payment::class, 'patient_id');
    }
}