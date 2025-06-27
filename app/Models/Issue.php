<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $table = 'issue_mast';
    protected $primaryKey = 'Issue_Code';
    public $incrementing = false;   // Set to false so we can manually assign the primary key
    public $timestamps = false;     // No created_at/updated_at

    protected $fillable = ['Issue_Code', 'IssueName', 'Sub_Code', 'Date_updated'];
}
