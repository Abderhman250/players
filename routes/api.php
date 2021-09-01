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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['api','Public_key','Lang']], function () {
    Route::post('login', 'App\Http\Controllers\api\UserApiController@login');
    Route::post('registers', 'App\Http\Controllers\api\UserApiController@store');

 
    Route::group(['middleware' => ['check_Auth_API']], function () {

        Route::put('Click/count', 'App\Http\Controllers\api\clickController@create');

    });
});
