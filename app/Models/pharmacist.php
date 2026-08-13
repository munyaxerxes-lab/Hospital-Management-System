<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pharmacist extends Model
{
    //
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
