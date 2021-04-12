<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompanyDivision;

class DivisionController extends Controller
{
    public function index(){

      $data = CompanyDivision::All();

    	return response()->json($data);
    }
}
