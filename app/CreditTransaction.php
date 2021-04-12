<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditTransaction extends Model
{
   protected $fillable = ['user_id', 'transactions', 'action', 'type', 'balance'];
 
}
