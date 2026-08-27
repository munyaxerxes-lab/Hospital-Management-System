<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lab_request_items extends Model
{
    protected $table = 'lab_request_items';

    protected $fillable = [
        'lab_request_id',
        'lab_test_id',
        'test_name',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function request()
    {
        return $this->belongsTo(LabRequest::class, 'lab_request_id');
    }

    public function test()
    {
        return $this->belongsTo(lab_test::class, 'lab_test_id');
    }
}
