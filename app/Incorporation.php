<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incorporation extends Model
{
  protected $connection = 'mysql2';

  protected $fillable = ['lead_id', 'state_id', 'country_id'];

  protected $hidden = array('pivot');

}
