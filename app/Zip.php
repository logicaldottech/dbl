<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zip extends Model
{
   protected $connection = 'mysql2';

    protected $fillable = ['city_id', 'value'];

    // hidden pivot data when fetch
    protected $hidden = array('pivot');

    protected $visible = ['value', 'city_id'];


    public function city()
     {
       return $this->belongsTo('App\Zip');

       }


}
