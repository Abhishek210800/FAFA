<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CaseModel;

class CaseNumber extends Model
{
    protected $table = 'case_models'; 

    protected $fillable = ['case_number']; 
    public function cases()
    {
        return $this->hasMany(CaseModel::class, 'case_model_id');
    }
}
