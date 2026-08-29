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

    public function getImageUrlAttribute()
    {
        if (empty($this->image)) {
            return null;
        }

        if (\Illuminate\Support\Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        if (\Illuminate\Support\Str::startsWith($this->image, ['/image/', 'image/'])) {
            return asset(ltrim($this->image, '/'));
        }

        if (\Illuminate\Support\Str::startsWith($this->image, ['/storage/', 'storage/'])) {
            return asset(ltrim($this->image, '/'));
        }

        return asset('storage/' . ltrim($this->image, '/'));
    }

    public function requestItems()
    {
        return $this->hasMany(lab_request_items::class, 'lab_test_id');
    }
}