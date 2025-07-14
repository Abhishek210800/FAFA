<?php

namespace App\Models;

use App\Models\BaseModel;

class Issue extends BaseModel
{
    protected $table = 'issue_mast';
    protected $primaryKey = 'Issue_Code';
    public $incrementing = false;   // Set to false so we can manually assign the primary key
    public $timestamps = false;     // No created_at/updated_at

    protected $fillable = ['Issue_Code', 'IssueName', 'Sub_Code', 'Date_updated'];
}
