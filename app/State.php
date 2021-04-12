<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{

  protected $connection = 'mysql2';
  protected $fillable = ['name'];
    // hidden pivot data when fetch
    protected $hidden = array('pivot');




}
