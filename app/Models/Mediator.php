<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mediator extends Model
{
    protected $table = 'mediator_mast'; 

    protected $fillable = ['name', 'qualification', 'address', 'emailId','mobile' ];

    public function mediations()
    {
        return $this->hasMany(Mediation::class, 'mediator_id');
    }
}
