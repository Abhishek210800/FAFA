<?php

namespace App\Models;

use App\Models\BaseModel;

class Subject extends BaseModel
{
    protected $table = 'subjects';

    protected $primaryKey = 'subject_id'; 

    public $incrementing = false; 

    protected $keyType = 'string'; 

    protected $fillable = [
        'subject_id',
        'name',
    ];

    public $timestamps = false;
}

