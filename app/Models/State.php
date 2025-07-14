<?php

namespace App\Models;

use App\Models\BaseModel;

class State extends BaseModel
{
    protected $table = 'states';

    // A state has many cities
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
