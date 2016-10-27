<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('welcome');
    })->middleware('guest');
	
	//Consignors
	Route::get('/consignors', 'ConsignorController@index');
	Route::post('/consignor', 'ConsignorController@store');
	Route::delete('/consignor/{id}', 'ConsignorController@delete');
	
	//Items
	Route::get('/items', 'ItemController@index');
	Route::get('/ajax/items/{id}', 'ItemController@ajaxGet');
	Route::post('/item', 'ItemController@store');
	Route::put('/ajax/item/update', 'ItemController@ajaxUpdate');
	Route::put('/ajax/stock/update', 'ItemController@ajaxUpdateStock');
	Route::delete('/item', 'ItemController@ajaxDelete');
	
	
	//Transactions
	Route::get('/transactions', 'TransactionController@index');
	Route::post('/transaction', 'TransactionController@store');
	Route::delete('/ajax/transaction/delete', 'TransactionController@ajaxDelete');
	
	//Users
	Route::get('/users', 'UserController@index');
	Route::post('/user', 'UserController@store');

	//Reports
	Route::get('/reports', 'ReportsController@index');
	
    Route::auth();

});
