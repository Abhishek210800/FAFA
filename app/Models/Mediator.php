<?php

namespace App\Models;

use App\Models\BaseModel;

class Mediator extends BaseModel
{
    protected $table = 'mediator_mast'; 

    protected $fillable = ['name', 'qualification', 'address', 'emailId','mobile' ];

    public function mediations()
    {
        return $this->hasMany(Mediation::class, 'mediator_id');
    }
}
