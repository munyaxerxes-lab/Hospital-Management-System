<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pharmacist extends Model
{
    protected $table = 'pharmacist';

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

    public function prescriptions()
    {
        return $this->hasMany(prescriptions::class, 'pharmacist_id');
    }
}
