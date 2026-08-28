<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $table = 'hospitals';

    protected $fillable = [
        'hospital_name',
        'address',
        'email',
        'phone',
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function pharmacists()
    {
        return $this->hasMany(pharmacist::class);
    }

    public function lab_technicians()
    {
        return $this->hasMany(lab_technician::class);
    }
}
