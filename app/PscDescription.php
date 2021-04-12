<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PscDescription extends Model
{
  protected $connection = 'mysql2';
  protected $fillable = ['psc_code_id, description'];

  protected $visible = ['psc_code_id', 'description'];

  protected $table = "psc_description";
}
