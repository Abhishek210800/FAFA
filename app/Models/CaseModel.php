<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CaseNumber;

class CaseModel extends Model
{
    protected $table = 'cases';

    protected $fillable = [
        'case_model_id',
        'reference_date',
        'court_id',
        'judge_id',
        'plaintiff',
        'defendant',
        'document_path',
    ];

    public function caseNumber()
    {
        return $this->belongsTo(CaseNumber::class, 'case_model_id');
    }
}
