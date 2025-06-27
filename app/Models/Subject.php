<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
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

