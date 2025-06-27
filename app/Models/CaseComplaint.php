<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CaseComplaint extends Model
{
   protected $fillable = [
    'court', 'court_id', 'judge_id', 'plaintiff', 'defendant', 'case_number', 'reference_date', 'order_file', 'case_file', 'status'
];

}
