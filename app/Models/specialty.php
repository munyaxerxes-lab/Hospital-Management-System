<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class specialty extends Model
{
    protected $table = 'specialties';

    protected $fillable = [
        'user_id',
        'hospital_id',
        'name',
        'license_number',
        'years_of_experience',
        'bio',
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
}
