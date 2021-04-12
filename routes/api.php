<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::resource('leads', 'LeadController');

Route::post('/search', 'SearchController@search');
Route::post('/search_company', 'SearchController@searchCompany');

// Route::get('/export-excel', 'downloadController@export');
// Route::post('/export-all', 'downloadController@exportall');

Route::get('/user', 'UserController@getUser');
Route::post('user-store', 'UserController@userPostRegistration');

// route for get NAICS Industries

Route::post('/get_industries', 'NaicsIndustryController@getIndustries');
// Route::post('/get_industries_cat', 'NaicsIndustryController@getIndustriesCategories');

Route::post('/get_division', 'DivisionController@index');
Route::post('/getContacts', 'downloadController@getContacts');

// Route::post('/get-credits', 'CreditController@index');

Route::post('creditbuy', 'CreditController@merchantone');

Route::get('allindustries', 'NaicsIndustryController@get_all');
Route::get('sectors', 'NaicsIndustryController@get_sectors');
Route::get('subsectors', 'NaicsIndustryController@get_subsectors');
Route::get('industriesgroups', 'NaicsIndustryController@get_industrygroups');

Route::get('industries', 'NaicsIndustryController@get_industries');


// get location
Route::get('getcountries', 'SuggestionController@countries');
