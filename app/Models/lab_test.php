<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lab_test extends Model
{
    //
    public function lab_test()
    {
        return $this->hasMany(lab_request_items::class);
    }
}
