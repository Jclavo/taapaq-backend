<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class CustomSpatieRole extends SpatieRole
{
    public $guard_name = 'api';
}