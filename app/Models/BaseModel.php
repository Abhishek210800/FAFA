<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model
{
    public function getConnectionName()
    {
        if (Auth::check() && Auth::user()->user_type === 'training') {
            return 'training';
        }

        return config('database.default'); 
    }
}
