<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hearing extends Model
{
    protected $fillable = ['court_case_id', 'hearing_date'];
}
