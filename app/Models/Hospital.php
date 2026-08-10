<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    //
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
    public function pharmacists()
    {
        return $this->hasMany(Pharmacist::class);
    }
    public function lab_technicians()
    {
        return $this->hasMany(lab_technician::class);
    }
}
