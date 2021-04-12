<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function getCountries(){
      $country = DB::connection('mysql2')->table('countries')
      ->select('id','name','alpha_3')
      ->get();

      return response()->json($country);
    }
}
