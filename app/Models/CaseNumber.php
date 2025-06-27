<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CaseModel;

class CaseNumber extends Model
{
    protected $table = 'case_models'; // the table storing case numbers

    protected $fillable = ['case_number']; // adjust if there are more fields

    public function cases()
    {
        return $this->hasMany(CaseModel::class, 'case_model_id');
    }
}
