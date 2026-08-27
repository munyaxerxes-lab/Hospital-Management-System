<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lab_test extends Model
{
    protected $table = 'lab_tests';

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

    public function requestItems()
    {
        return $this->hasMany(lab_request_items::class, 'lab_test_id');
    }
}