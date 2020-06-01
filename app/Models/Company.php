<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The projects that belong to the company.
     */
    public function projects()
    {
        return $this->belongsToMany('App\Models\Project')
                    ->using('App\Models\CompanyProject')
                    ->withTimestamps()
                    ->withPivot('id');
    }
}
