<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnnualRevenue extends Model
{
   protected $fillable = ['annual_revenue'];

   // hidden pivot data when fetch
    protected $hidden = array('pivot');
   
}
