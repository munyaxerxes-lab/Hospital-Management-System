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
        return $this->hasMany(Appointments::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function labRequests()
    {
        return $this->hasMany(Lab_Request::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}