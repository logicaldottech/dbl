<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

  protected $connection = 'mysql2';
   protected $fillable = ['name','alpha_2','alpha_3'];

   // hidden pivot data when fetch
    protected $hidden = array('pivot');


   public function PhysicalAddress(){
    	return $this->hasOne('App\Physicaladdress');
    }



}
