<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class CourtMast extends BaseModel
{
    protected $table = 'court_mast';
    protected $primaryKey = 'AG_Courtcode';
    public $incrementing = false;
    protected $keyType = 'string';
     public $timestamps = false;

    protected $fillable = ['AG_Courtcode', 'Court_Name', 'Count_code', 'Date_updated'];
}

