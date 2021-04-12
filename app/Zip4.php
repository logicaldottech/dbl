<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zip4 extends Model
{
    protected $fillable = ['city_id', 'zip_4'];
    protected $guarded = [];
    protected $table = 'zips_4';
   
   // hidden pivot data when fetch
    protected $hidden = array('pivot');
}
