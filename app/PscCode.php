<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PscCode extends Model
{
    protected $connection = 'mysql2';
    protected $fillable = ['psc_code'];

    protected $visible = ['psc_code'];


    public function leads()
     {
       return $this->belongsToMany('App\Lead','psc_lead');
     }

     public function psc_description()
      {
        return $this->hasOne('App\PscDescription', 'psc_code_id');
      }
}
