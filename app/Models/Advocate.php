<?php

namespace App\Models;

use App\Models\BaseModel;

class Advocate extends BaseModel
{
    protected $table = 'advocate_mast'; 

    protected $fillable = ['name', 'bar_number', 'emailId', 'mobile'];

    public function complainantMediations()
    {
        return $this->hasMany(Mediation::class, 'complainant_advocate_id');
    }

    public function defendantMediations()
    {
        return $this->hasMany(Mediation::class, 'defendant_advocate_id');
    }
}
