<?php

namespace App\Models;

use App\Models\BaseModel;


class CaseComplaint extends BaseModel
{
   protected $fillable = [
    'court', 'court_id', 'judge_id', 'plaintiff', 'defendant', 'case_number', 'reference_date', 'order_file', 'case_file', 'status'
];

}
