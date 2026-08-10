<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lab_request_items extends Model
{
    public function request()
    {
        return $this->belongsTo(Lab_Request::class);
    }

    public function test()
    {
        return $this->belongsTo(Lab_Test::class);
    }
}
