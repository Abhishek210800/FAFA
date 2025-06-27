<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    // A city belongs to a state
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
