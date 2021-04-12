<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['state_id', 'city'];

    // hidden pivot data when fetch
    protected $hidden = array('pivot');

    protected $visible = ['name', 'state_id'];
    //
}
