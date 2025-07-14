<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Respondent extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'mediation_id',
        'name',
        'father',
        'dob',
        'gender',
        'address',
        'state_id',
        'city_id',
        'district',
        'pincode',
        'mobile',
        'email',
        'id_proof',
        'defendant_type'
    ];

    public function mediation()
    {
        return $this->belongsTo(Mediation::class);
    }

    
    public function complainantState()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function complainantCity()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
