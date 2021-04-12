<?php
//geek code
namespace App;

use Illuminate\Database\Eloquent\Model;

class NaicsCode extends Model
{
    protected $connection = 'mysql2';
    protected $fillable = ['code'];

    protected $visible = ['code'];


    public function leads()
     {
         return $this->belongsToMany('App\Lead','naics_lead');
     }

     public function NaicsIndustries(){
       return $this->belongsToMany('App\NaicsIndustry','industry_code', 'naics_code_id', 'naics_industry_id');
     }

}
