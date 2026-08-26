<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $table = "medicine";
    protected $fillable = [
        'name',
        'type',
        'stock',
        'expiry_date',
        'price',
        'description',
        'status',
        'image',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'price' => 'decimal:2',
    ];
}