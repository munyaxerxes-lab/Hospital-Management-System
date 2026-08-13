<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabRequest extends Model
{
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function items()
    {
        return $this->hasMany(Lab_Request_Items::class);
    }

    public function results()
    {
        return $this->hasMany(Lab_Results::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
