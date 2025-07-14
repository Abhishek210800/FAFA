<?php

namespace App\Models;

use App\Models\BaseModel;

class SupportMessage extends BaseModel
{
    protected $fillable = ['name', 'email', 'issue_type', 'message', 'is_read'];

    protected $casts = ['is_read' => 'boolean',];
}

