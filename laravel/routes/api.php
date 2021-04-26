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

Route::group(['middleware' => 'auth:api','prefix'=>'prescription'], function () {
    Route::get('/','prescriptionController@index');
    Route::post('/','prescriptionController@create');
    Route::get('/{id}','prescriptionController@detail');
    Route::put('/{id}','prescriptionController@update');
    Route::delete('/{id}','prescriptionController@delete');
});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

Route::group(['prefix' => 'customer'], function()
{
    Route::post('/', 'customerController@insert');
});