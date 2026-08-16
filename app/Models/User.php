<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }
    public function pharmacist()
    {
        return $this->hasOne(pharmacist::class);
    }
    public function lab_technician()
    {
        return $this->hasOne(lab_technician::class);
    }
    public function delivery_agent()
    {
        return $this->hasOne(DeliveryAgent::class);
}

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'name',
    'email',
    'phone',
    'password',
    'role_id',
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
