<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medicine extends Model
{
    public function medicine()
    {
        return $this->belongsTo(medicines::class);
    }
    public function order_items()
    {
        return $this->hasMany(Order_item::class, 'medicine_id');
    }
}
