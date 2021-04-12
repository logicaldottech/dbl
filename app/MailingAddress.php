<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailingAddress extends Model
{
  protected $connection = 'mysql2';

  protected $visible = ['lead_id', 'country_id', 'state_id',  'city_id', 'zip_id'];

   protected $fillable = ['lead_id', 'country_id', 'state_id',  'city_id', 'zip_id'];

}
