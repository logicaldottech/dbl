<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhysicalStreet extends Model
{
  protected $connection = 'mysql2';

    protected $fillable = ['lead_id', 'address'];
}
