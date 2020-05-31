<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'page_id'
    ];

    /**
     * Get the module that owns the resource
     */
    public function module()
    {
        return $this->belongsTo('App\Models\Module');
    }
}
