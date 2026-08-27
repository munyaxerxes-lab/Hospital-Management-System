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

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function carts()
    {
        return $this->hasMany(cart::class);
    }
}