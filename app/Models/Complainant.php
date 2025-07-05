<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Complainant extends Model
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
        'complainant_type'
    ];

   public function mediation()
    {
        return $this->belongsTo(Mediation::class);
    }
}
