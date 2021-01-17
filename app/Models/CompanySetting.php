<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'has_cashier', 'payment_type_id'
    ];

     /**
     * Get the company that owns the setting.
     */
    public function person()
    {
        return $this->belongsTo('App\Models\Company');
    }

}
