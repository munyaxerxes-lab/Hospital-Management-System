<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'delivery';

    protected $fillable = [
        'order_id',
        'agent_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function agent()
    {
        return $this->belongsTo(DeliveryAgent::class, 'agent_id');
    }
}
