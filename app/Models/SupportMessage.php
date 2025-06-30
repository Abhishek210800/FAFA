<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    protected $fillable = ['name', 'email', 'issue_type', 'message', 'is_read'];

    protected $casts = ['is_read' => 'boolean',];
}

