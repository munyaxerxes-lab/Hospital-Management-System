<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class prescriptions extends Model
{
    //
    public function pharmacist()
    {
        return $this->belongsTo(Pharmacist::class);
    }
    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
}
