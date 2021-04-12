<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailingStreet extends Model
{
  protected $connection = 'mysql2';

    protected $fillable = ['mailing_address_id', 'mailing_address'];

}
