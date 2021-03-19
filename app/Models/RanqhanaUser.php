<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RanqhanaUser extends Model
{
    //Set db connection
    protected $connection = 'ranqhana_DB';

    protected $fillable = [
        'external_user_id', 'login', 'company_project_id'
    ];
}
