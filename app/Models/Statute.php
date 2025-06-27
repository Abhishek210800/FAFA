<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statute extends Model
{
    protected $table = 'statute_mast';

    protected $primaryKey = 'AG_StatuteCode';

    public $incrementing = false; 
    protected $keyType = 'double'; 

    public $timestamps = false; 

    protected $fillable = ['AG_StatuteCode', 'Act_Name', 'Date_updated', 'Count_code'];
}

