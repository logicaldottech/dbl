<?php
//geek code
namespace App;

use Illuminate\Database\Eloquent\Model;

class NaicsIndustry extends Model
{
  protected $connection = 'mysql2';

    protected $fillable = ['code', 'title','level'];

}
