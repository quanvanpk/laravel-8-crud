<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
        Route::post('logout', 'AuthController@logout')->middleware('auth:api');
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::group(['prefix' => 'loans'], function () {
            Route::get('/', 'LoanController@index');
            Route::post('/', 'LoanController@create');
            Route::get('/{id}', 'LoanController@show');
            Route::put('/{id}', 'LoanController@update');
            Route::delete('/{id}', 'LoanController@delete');
        });

        Route::group(['prefix' => 'repayments'], function () {
            Route::get('/{id}', 'LoanRepaymentController@show');
            Route::post('/', 'LoanRepaymentController@create');
        });
    });
});


