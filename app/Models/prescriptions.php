<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class prescriptions extends Model
{
    protected $table = 'prescription';

    protected $fillable = [
        'pharmacist_id',
    ];

    public function pharmacist()
    {
        return $this->belongsTo(pharmacist::class, 'pharmacist_id');
    }

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
}
