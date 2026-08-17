<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lab_results extends Model
{
    public function request()
    {
        return $this->belongsTo(Lab_Request::class);
    }

    public function laboratoryTechnician()
    {
        return $this->belongsTo(Lab_Technician::class);
    }
}
