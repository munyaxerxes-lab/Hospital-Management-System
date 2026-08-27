<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabRequest extends Model
{
    protected $table = 'lab_reqests';

    protected $fillable = [
        'request_number',
        'user_id',
        'patient_id',
        'payment_id',
        'total_amount',
        'status',
        'payment_status',
        'payment_method',
        'sample_type',
        'scheduled_date',
        'scheduled_time',
        'address',
        'notes',
        'result_document',
        'result_file_name',
        'result_file_type',
        'result_notes',
        'result_uploaded_at',
        'delivered_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'scheduled_date' => 'date',
        'result_uploaded_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function items()
    {
        return $this->hasMany(lab_request_items::class, 'lab_request_id');
    }

    public function results()
    {
        return $this->hasMany(lab_results::class, 'request_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
