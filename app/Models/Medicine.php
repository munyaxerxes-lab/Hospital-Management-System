<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    public function medicine()
    {
        return $this->belongsTo(MedicineLab::class);
    }
    public function order_items()
    {
        return $this->hasMany(OrderItem::class, 'medicine_id');
    }
}
