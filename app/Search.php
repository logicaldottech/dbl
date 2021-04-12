<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $fillable = ['user_id', 'name', 'search'];

    public function users(){

      return $this->belongsTo('App\User');

    }
}
