<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';

    // A state has many cities
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
