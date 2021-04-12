<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeadMeta extends Model
{
    protected $fillable = ['lead_id', 'fiscal_year_id', 'company_division_id', 'annual_revenue_id'];
}
