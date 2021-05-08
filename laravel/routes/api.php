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

Route::group(['middleware' => 'auth:api','prefix'=>'customer'], function () {
    Route::get('/','customerController@index');
    Route::post('/','customerController@create');
    Route::get('/{id}','customerController@detail');
    Route::put('/{id}','customerController@update');
    Route::delete('/{id}','customerController@delete');
});

Route::group(['middleware' => 'auth:api','prefix'=>'prescriptions_detail'], function () {
    Route::get('/','prescriptions_detailController@index');
    Route::post('/','prescriptions_detailController@create');
    Route::get('/{id}','prescriptions_detailController@detail');
    Route::put('/{id}','prescriptions_detailController@update');
    Route::delete('/{id}','prescriptions_detailController@delete'); 
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
