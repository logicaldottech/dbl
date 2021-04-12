<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhysicalAddress extends Model
{
  protected $connection = 'mysql2';

   protected $fillable = ['lead_id', 'country_id', 'state_id', 'city_id', 'zip_id'];

   public function lead(){
    	return $this->belongsTo('App\Lead');
   }

}
