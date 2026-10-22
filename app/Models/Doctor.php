<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = "doctors";
    protected $fillable = [
        'doctor_name',
        'specialty',
        'qualification',
        'years_of_experience',
        'consultation_fee',
        'username',
        'status',
        'avatar',
    ];

    protected $casts = [
        'years_of_experience' => 'integer',
        'consultation_fee' => 'decimal:2',
    ];

    protected $appends = ['avatar_url'];

    /**
     * Get the full URL for the doctor avatar / profile photo.
     */
    public function getAvatarUrlAttribute(): string
    {
        if (empty($this->avatar)) {
            return asset('image/doc.png');
        }

        if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
            return $this->avatar;
        }

        if (str_starts_with($this->avatar, 'image/') || str_starts_with($this->avatar, '/image/')) {
            return asset(ltrim($this->avatar, '/'));
        }

        if (str_starts_with($this->avatar, 'storage/') || str_starts_with($this->avatar, '/storage/')) {
            return asset(ltrim($this->avatar, '/'));
        }

        return asset('storage/' . ltrim($this->avatar, '/'));
    }

    public function schedules()
    {
        return $this->hasMany(doctor_schedule::class, 'doctor_id');
    }
}