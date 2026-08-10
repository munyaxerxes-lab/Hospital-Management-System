<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery_Agent extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
