<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lab_test extends Model
{
    protected $fillable = [
        'name',
        'category',
        'price',
        'description',
        'preparation',
        'image',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'status' => 'boolean',
    ];
}