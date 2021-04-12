<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PscLead extends Model
{
  protected $connection = 'mysql2';
  protected $fillable = ['lead_id, psc_code_id'];

  protected $visible = ['lead_id', 'psc_code_id'];

  protected $table = "psc_lead";
}
