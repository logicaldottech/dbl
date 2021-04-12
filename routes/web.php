<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/tosave', 'HomeController@index')->name('home');
    Route::get('/saved', 'HomeController@index')->name('home');
    // Route::get('/industrysearch', 'HomeController@index')->name('home');
    Route::get('/', 'HomeController@index')->name('home');

    Route::post('/user-with-credit', 'CreditController@userWithCredit');

    Route::get('/credits', 'CreditController@index')->name('credits');

    Route::get('/purchase', 'CreditController@purchase')->name('purchase');

    Route::post('/credits', 'CreditController@credit')->name('credit');
    Route::get('/merchant', 'CreditController@merchantone');

    Route::get('/transaction-success', 'CreditController@success')->name('credit-success');

    Route::post('/debit', 'CreditController@debit')->name('debit');

    //deduct credit in export csv by lead_id
    Route::post('/get-credits', 'CreditController@exportCustomByCompany');
    Route::post('/get-credits-custom', 'CreditController@exportByCompany');

    //deduct credit in export csv by contact_id               j
    Route::post('/get-credits-contact', 'CreditController@exportByContacts');
    Route::post('/get-credits-contact-custom', 'CreditController@exportCustomByContacts');

    //export functionality for company
    Route::post('/export-excel', 'downloadController@export');
    Route::post('/export-all', 'downloadController@exportall');

    //export functionality for contacts
    Route::post('/export-excel-contacts', 'downloadController@exportContacts');
    Route::post('/export-all-contacts', 'downloadController@exportallContacts');
    // route for check status of the payment
  	Route::get('status', 'PaymentController@getPaymentStatus');
// geek code
    Route::post('save-search', 'SearchController@saveSearch')->name('save-search');

    Route::post('/saved-search-list', 'SearchController@getSearchLists')->name('saved-search-view');

    Route::post('/get-search-single', 'SearchController@getSearchSingle')->name('saved-search-view');

    Route::post('/delete-saved-search', 'SearchController@deleteSearchView')->name('delete-search-view');
//geek code
    // Download Views
    Route::get('/downloads', 'DownloadController@getDownloads')->name('my-download-view');

    Route::get('/download-export', 'DownloadController@exportDownloads');


    Route::get('/pay', 'CreditController@proceedpayment')->name('pay');

    Route::post('/pay', 'CreditController@proceedpayment')->name('pay');

    Route::get('/test', 'CreditController@get_discount_level')->name('test');

    Route::get('/profile', 'HomeController@viewProfile');

    Route::post('/get-user-data', 'HomeController@viewUserProfile');

    // route for update user data by user_id
    Route::post('/update-user-data', 'HomeController@updateUserData');

    Route::post('/update-user-password', 'HomeController@updateUserpassword');




});

Route::get('register', 'UserController@index')->name('register');

Route::post('user-store', 'UserController@userPostRegistration')->name('post_register');
Route::post('/export-all', 'downloadController@exportall');

Route::get('login', 'UserController@userLoginIndex')->name('login');

Route::post('login', 'UserController@userPostLogin')->name('post_login');

Route::get('dashboard', 'UserController@dashboard')->name('dashboard');

Route::get('logout', 'UserController@logout')->name('logout');

Route::get('password/reset', 'auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');

Route::post('password/email', 'auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

Route::get('password/reset/{token}', 'auth\ResetPasswordController@showResetForm')->name('password.reset.token');

Route::post('password/reset', 'auth\ResetPasswordController@reset')->name('password.update');

// Route::get('password-reset', 'PasswordController@resetForm')->name('password.reset'); //I did not create this controller. it simply displays a view with a form to take the email
// Route::post('password-reset', 'PasswordController@sendPasswordResetToken')->name('password.email');
// Route::get('reset-password/{token}', 'PasswordController@showPasswordResetForm')->name('password.reset.token');;
// Route::post('reset-password/{token}', 'PasswordController@resetPassword')->name('password.update');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/search', 'SearchController@search');

// country
Route::get('add_countries', 'importCsvController@addCountry');


Route::get('add_states', 'importCsvController@addStates');


Route::get('add_cities', 'importCsvController@addCities');
