<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lead;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;


class SuggestionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function countries(Request $request)
    {
      $value = $request->value;

      $country = DB::connection('mysql2')->table('countries')
      ->select('id','name','alpha_3')
      ->where('name', 'like', $value.'%')
      ->take(20)
      ->get();

      return response()->json($country);

    }


}
