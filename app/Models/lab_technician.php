<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lab_technician extends Model
{
    protected $table = 'lab_technician';

    protected $fillable = [
        'user_id',
        'hospital_id',
        'license_number',
        'employee_id',
        'position',
        'years_of_experience',
        'bio',
        'name',
        'email',
        'phone',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function labResults()
    {
        return $this->hasMany(lab_results::class, 'laboratory_technician_id');
    }
}
