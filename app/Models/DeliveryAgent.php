<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryAgent extends Model
{
    protected $table = 'delivery_agents';

    protected $fillable = [
        'user_id',
        'status',
        'vehicle_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'agent_id');
    }
}
