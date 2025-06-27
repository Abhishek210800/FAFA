<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JudgeMast extends Model
{
    protected $table = 'judge_mast';
    protected $primaryKey = 'AGJudgecode';
    public $incrementing = false;
    protected $keyType = 'string'; 

    public $timestamps = false;

    protected $fillable = [
        'AGJudgecode',
        'Judge_Name',
        'AG_Courtcode',
        'Count_code'
    ];
}

