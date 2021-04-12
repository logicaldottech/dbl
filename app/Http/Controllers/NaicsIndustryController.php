<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NaicsIndustry;
use App\NaicsCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

use Illuminate\Support\Str;

class NaicsIndustryController extends Controller
{


  public function get_all(){

    $industries = DB::connection('mysql2')->table('naics_industries')
    ->select('id','title','code','level')
    ->get();
  
    return response()->json($industries);

  }


  public function get_sectors(){

    $sectors = DB::connection('mysql2')->table('naics_industries')
    ->select('title','code')
    ->where('level','Sectors')
    ->get();

    $finalsectors = array();
    $temptitle = array();
    foreach( $sectors as $k => $v  ){
      $temptitle[$v->title][] = $v->code;
      $finalsectors[$v->title] = implode(',',$temptitle[$v->title]);
    }
    return response()->json($finalsectors);
  }

  public function get_subsectors(Request $request){

    $sector = $request->sector;
    $sector = explode(',',$sector);
    //$sector = (int) $sector;
  //  return response()->json($sector);
    $x = 1;
    $subsectors = array();
    foreach( $sector as $k => $s ){
      $subsectors[] = DB::connection('mysql2')->table('naics_industries')
      ->select('title','code','level')
      ->where([
        ['code', 'like', $s.'_%'],
        ['level', 'Subsectors']
        ]
        )->get();
    }

    $finalsubsectors = array();
    foreach( $subsectors as $entry ){
      foreach( $entry as $k => $v ){
        $finalsubsectors[] =$v;
      }
    }
    return response()->json($finalsubsectors);
  }


  public function get_subsectors_by_name(Request $request){

    $name = $request->name;

    $subsectors = DB::connection('mysql2')->table('naics_industries')
    ->select('title','code','level')
    ->where([
      ['title',$name],
      ['level', 'Subsectors']
      ]
      )
    ->get();
    // return $subsector;

    return response()->json($subsectors);
  }


  public function get_industrygroups(Request $request){

    $subsector = $request->subsector;
    $subsector = (int) $subsector;

    $industrygroups = DB::connection('mysql2')->table('naics_industries')
    ->select('title','code','level')
    ->where([
      ['code', 'like', $subsector.'_%'],
      ['level', 'Industry Groups']
      ]
      )
    ->get();
    // return $subsector;

    return response()->json($industrygroups);
  }

  public function get_industries(Request $request){

    $industrygroup = $request->industrygroup;
    $industrygroup = (int) $industrygroup;

    $industries= DB::connection('mysql2')->table('naics_industries')
    ->select('title','code','level')
    ->where([
      ['code', 'like', $industrygroup.'_%'],
      ['level', 'Industries']
      ]
      )
    ->get();
    // return $subsector;

    return response()->json($industries);
  }

}
