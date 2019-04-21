<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */
//Login
Route::post('auth/login', ['as' => 'login', 'middleware' => 'web', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('logout', 'Auth\AuthController@logOut');

//Reset Password
Route::post('password/email', 'Auth\PasswordController@postEmail');

//Home
Route::get('/', ['as' => 'home', 'middleware' => 'web', 'uses' => 'HomeController@index']);

Route::group(['prefix' => 'home', 'middleware' => 'web'], function () {

    Route::get('/', 'HomeController@index');

    Route::post('/', ['as' => 'dashboard.box', 'uses' => 'HomeController@box']);

});

//Profile
Route::get('profile', ['as' => 'profile', 'middleware' => 'web', 'uses' => 'UsersController@profile']);
Route::put('profile/update/{id}', ['as' => 'profile.update', 'middleware' => 'web', 'uses' => 'UsersController@update']);

//Images
Route::get('img/{type}/{file?}', ['as' => 'imageload', 'middleware' => 'web', 'uses' => 'FileController@img'])->where('file', '(.*)');

//Maintenance
Route::group(['roles' => ['admin'], 'middleware' => ['web', 'roles']], function ()
{
    Route::resource('banks', 'BanksController');

    Route::resource('cities', 'CitiesController');

    Route::resource('paymentsFrequency', 'PaymentsFreqController');

    Route::get('banks/{id}/delete', ['as' => 'banks.delete', 'uses' => 'BanksController@destroy']);

    Route::get('banks/{id}/condition/{status}', ['as' => 'banks.change_status', 'uses' => 'BanksController@changeStatus']);

    Route::get('cities/{id}/delete', ['as' => 'cities.delete', 'uses' => 'CitiesController@destroy']);

    Route::get('cities/{id}/condition/{status}', ['as' => 'cities.change_status', 'uses' => 'CitiesController@changeStatus']);

    Route::get('paymentsFrequency/{id}/delete', ['as' => 'payments_frecuency.delete', 'uses' => 'PaymentsFreqController@destroy']);
});

//Users Controller
Route::group(['roles' => ['admin', 'supervisor'], 'middleware' => ['web', 'roles']], function () {

    //employees
    Route::resource('employees', 'UsersController');

    Route::get('employees/{id}/delete', ['as' => 'employee.delete', 'uses' => 'UsersController@destroy']);

    Route::get('employees/{id}/condition/{status}', ['as' => 'employee.change_status', 'uses' => 'UsersController@changeStatus']);

    //Customers
    Route::get('customers', ['as' => 'customers.index', 'uses' => 'CustomersController@index']);

    Route::get('customers/create', ['as' => 'customers.create', 'uses' => 'CustomersController@create']);

    Route::get('customers/{id}/edit/step/{tab}', ['as' => 'customers.edit', 'uses' => 'CustomersController@edit']);

    Route::get('customers/{id}/edit/step/{tab}/document/{document_id}', ['as' => 'customers.edit_document', 'uses' => 'CustomersController@edit']);

    Route::get('customers/download/document/{document_id}', ['as' => 'customers.download_document', 'uses' => 'CustomersController@downloadDocument']);

    Route::get('customers/delete/document/{document_id}', ['as' => 'customers.delete_document', 'uses' => 'CustomersController@deleteDocument']);

    Route::post('customers', ['as' => 'customers.store', 'uses' => 'CustomersController@store']);

    Route::put('customers/{id}', ['as' => 'customers.update', 'uses' => 'CustomersController@update']);

    Route::get('customers/{id}/delete', ['as' => 'customers.delete', 'uses' => 'CustomersController@destroy']);

    Route::get('customers/{id}/condition/{status}', ['as' => 'customers.change_status', 'uses' => 'CustomersController@changeStatus']);

    //Loans
    Route::resource('loans', 'LoansController');

    Route::get('loans/status/{loan_id}/{status}', ['as' => 'loans.status', 'uses' => 'LoansController@changeStauts']);

    //Installments
    Route::resource('installments', 'InstallmentsController');

    Route::post('installments/loan', 'InstallmentsController@installmentsByLoan');

    Route::get('installments/{id}/delete', ['as' => 'installments.delete', 'uses' => 'InstallmentsController@destroy']);

    Route::get('installments/{id}/paid', ['as' => 'installments.paid', 'uses' => 'InstallmentsController@sendInstallmentToPayment']);


    //Payments
    Route::resource('payments', 'PaymentsController');

    Route::get('payments/loansByUser/{id}', ['as' => 'payments.loans', 'uses' => 'PaymentsController@loansByUser']);

    Route::post('payments/paymentSummary/', ['as' => 'payments.paymentSummary', 'uses' => 'PaymentsController@paymentSummary']);

    Route::post('payments/penaltyRate/', ['as' => 'payments.penaltyRate', 'uses' => 'PaymentsController@penaltyRate']);

    Route::get('payments/add/{loan_id}', ['as' => 'payments.add', 'uses' => 'PaymentsController@create']);

    Route::get('payments/{id}/delete', ['as' => 'payments.delete', 'uses' => 'PaymentsController@destroy']);

    //Surcharges
    Route::resource('surcharges', 'SurchargesController');

    Route::get('surcharges/create/{loan_id}', ['as' => 'surcharges.create', 'uses' => 'SurchargesController@create']);

    Route::get('surcharges/{id}/delete', ['as' => 'surcharges.delete', 'uses' => 'SurchargesController@destroy']);

});

//search
Route::group(['prefix' => 'search', 'roles' => ['admin', 'supervisor', 'adviser'], 'middleware' => ['web', 'roles']], function ()
{
    // User
    Route::get('users', ['as' => 'search.users', 'uses' => 'UsersController@search']);

    Route::get('banks', ['as' => 'search.banks', 'uses' => 'BanksController@search']);

    Route::get('cities', ['as' => 'search.cities', 'uses' => 'CitiesController@search']);

    Route::get('usersByLoans', ['as' => 'search.usersByLoans', 'uses' => 'UsersController@byLoans']);
});

Route::group(['prefix' => 'calendar', 'roles' => ['admin', 'supervisor'], 'middleware' => ['web', 'roles']], function ()
{
    //holydays
    Route::resource('holydays', 'HolydaysController');

    Route::get('holydays/{id}/delete', ['as' => 'holydays.delete', 'uses' => 'HolydaysController@destroy']);
});

/*Route::get('/cache', function() {
    $exitCode = Artisan::call('cache:clear');
    echo 'done';
});*/
