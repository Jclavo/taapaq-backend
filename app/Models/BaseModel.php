<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

use App\Traits\LanguageTrait;
use App\Override\QueryBuilder;

class BaseModel extends Eloquent {

    use LanguageTrait;

    public function newEloquentBuilder($query) 
    { 
        return new QueryBuilder($query); 
    }

}