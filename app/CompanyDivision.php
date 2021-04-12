<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyDivision extends Model
{
   protected $fillable = ['division_number', 'company_division'];
    
   // hidden pivot data when fetch
    protected $hidden = array('pivot');
}
