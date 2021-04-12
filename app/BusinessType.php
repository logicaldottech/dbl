<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{

    protected $connection = 'mysql2';
    protected $fillable = ['business_type'];

    protected $visible = ['business_type'];

    public function leads()
     {
         return $this->belongsToMany('App\Lead','business_type_lead');
     }

}
