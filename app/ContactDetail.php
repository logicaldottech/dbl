<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactDetail extends Model
{
   protected $fillable = ['lead_id', 'contact_id', 'email_address', 'business_fax', 'contact_phone', 'contact_phone_ext'];
    
}
