<?php

namespace App\Models;

use App\Models\BaseModel;

class City extends BaseModel
{
    protected $table = 'cities';

    // A city belongs to a state
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
