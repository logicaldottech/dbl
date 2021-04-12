<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

  protected $connection = 'mysql2';

   protected $fillable = ['lead_id', 'first_name', 'last_name', 'contact_order','email_address','business_fax','contact_phone','contact_phone_ext'];

   public function lead(){
    	return $this->belongsTo('App\Lead');
    }

    public function psc_lead(){
      return $this->hasManyThrough('App\PscLead','App\Lead', 'id', 'lead_id');
    }

    public function psc_codes(){
     return $this->belongsToMany('App\PscCode','psc_lead', 'lead_id', 'lead_id');
   }

   public function naics_codes(){
     return $this->belongsToMany('App\NaicsCode','naics_lead','id','lead_id');
   }
}
