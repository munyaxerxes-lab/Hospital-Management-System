<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lab_results extends Model
{
    protected $table = 'lab_results';

    protected $fillable = [
        'request_id',
        'laboratory_technician_id',
    ];

    public function request()
    {
        return $this->belongsTo(LabRequest::class, 'request_id');
    }

    public function laboratoryTechnician()
    {
        return $this->belongsTo(lab_technician::class, 'laboratory_technician_id');
    }
}
