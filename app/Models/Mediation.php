<?php

namespace App\Models;

use App\Models\BaseModel;

class Mediation extends BaseModel
{
    protected $fillable = [
        'court_id', 'judge_id', 'case_number', 'reference_date', 'mediation_date',
        'order_file', 'case_file','order_summary','case_summary',

        'complainant_name', 'complainant_father', 'complainant_dob', 'complainant_gender',
        'complainant_address', 'complainant_state_id', 'complainant_city_id', 'complainant_district',
        'complainant_pincode', 'complainant_mobile', 'complainant_email', 'complainant_id_proof',

        'defendant_name', 'defendant_father', 'defendant_dob', 'defendant_gender',
        'defendant_address', 'defendant_state_id', 'defendant_city_id', 'defendant_district',
        'defendant_pincode', 'defendant_mobile', 'defendant_email','defandant_id_proof',

        'subject_id', 'issue_id', 'statute_id',
        'complainant_advocate_id', 'defendant_advocate_id', 'mediator_id','status','complainant_type','defendant_type' 
    ];

    public function complainant()
    {
        return $this->hasOne(Complainant::class, 'mediation_id');
    }

    public function respondent()
    {
        return $this->hasOne(Respondent::class, 'mediation_id');
    }


    public function court()
    {
        return $this->belongsTo(CourtMast::class, 'court_id');
    }

    public function judge()
    {
        return $this->belongsTo(JudgeMast::class, 'judge_id');
    }
    public function complainantState()
    {
        return $this->belongsTo(\App\Models\State::class, 'complainant_state_id');
    }

    public function complainantCity()
    {
        return $this->belongsTo(\App\Models\City::class, 'complainant_city_id');
    }
    public function defendantState()
    {
        return $this->belongsTo(\App\Models\State::class, 'defendant_state_id');
    }

    public function defendantCity()
    {
        return $this->belongsTo(\App\Models\City::class, 'defendant_city_id');
    }

    public function complainantAdvocate()
    {
        return $this->belongsTo(\App\Models\Advocate::class, 'complainant_advocate_id');
    }
        public function defendantAdvocate()
    {
        return $this->belongsTo(\App\Models\Advocate::class, 'defendant_advocate_id');
    }

    public function mediator()
    {
        return $this->belongsTo(\App\Models\Mediator::class, 'mediator_id');
    }

    
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function issue()
    {
        return $this->belongsTo(Issue::class, 'issue_id', 'Issue_code');
    }
    public function statute()
    {
        return $this->belongsTo(Statute::class, 'statute_id', 'AG_StatuteCode');
    }

    public function caseModel()
    {
        return $this->belongsTo(CaseModel::class, 'case_number', 'case_number');
    }


}
