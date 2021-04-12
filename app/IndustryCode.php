<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndustryCode extends Model
{
  protected $connection = 'mysql2';
  protected $fillable = ['naics_code_id, naics_industry_id'];

  protected $visible = ['naics_code_id', 'naics_industry_id'];

  protected $table = "industry_code";
}
