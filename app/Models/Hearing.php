<?php

namespace App\Models;

use App\Models\BaseModel;

class Hearing extends BaseModel
{
    protected $fillable = ['court_case_id', 'hearing_date'];
}
