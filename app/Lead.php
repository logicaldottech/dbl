<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $connection = 'mysql2';


    protected $fillable = ['legal_business_name', 'dba_name', 'corporate_url', 'business_start_date', 'employee_count','fiscal_year','annual_revenue'];



    public function naics_codes(){
      return $this->belongsToMany('App\NaicsCode','naics_lead');
    }

    public function psc_codes(){
      return $this->belongsToMany('App\PscCode','psc_lead');
    }

    public function business_types(){
      return $this->belongsToMany('App\BusinessType','business_type_lead');
    }

    public function contacts()
   {
       return $this->hasMany('App\Contact');
   }

   //Modal for Physical Addresses
    public function countries(){
        return $this->belongstoMany('App\Country', 'physical_addresses', 'lead_id', 'country_id')->select('alpha_3');
    }

    public function countryOfIncorpo(){
        return $this->belongstoMany('App\Country', 'incorporations', 'lead_id', 'country_id');
    }

    public function states(){
        return $this->belongstoMany('App\State', 'physical_addresses', 'lead_id', 'state_id');
    }

     public function stateOfIncorpo(){
        return $this->belongstoMany('App\State', 'incorporations', 'lead_id', 'state_id');
    }

    public function cities(){
        return $this->belongstoMany('App\City', 'physical_addresses', 'lead_id', 'city_id');
    }

    public function zips(){
        return $this->belongstoMany('App\Zip', 'physical_addresses', 'lead_id', 'zip_id');
    }

    public function physicalStreets(){
        return $this->hasMany('App\PhysicalStreet');
    }

   //Modal for Mailing Addresses

   public function mail_countries(){
       return $this->belongstoMany('App\Country', 'mailing_addresses', 'lead_id', 'country_id')->select('alpha_3');
   }

   public function mail_states(){
       return $this->belongstoMany('App\State', 'mailing_addresses', 'lead_id', 'state_id')->select('name');
   }

   public function mail_cities(){
       return $this->belongstoMany('App\City', 'mailing_addresses', 'lead_id', 'city_id')->select('name');
   }

    public function mailZips(){
        return $this->belongstoMany('App\Zip', 'mailing_addresses', 'lead_id', 'zip_id')->select('value');
    }

    public function mailingStreets(){
            return $this->hasMany('App\MailingStreet');
        }


}
