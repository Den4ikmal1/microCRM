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

Route::prefix('v1')->group(function () {

    Route::middleware('auth:api')->group(function () {
        Route::apiResource('/clients', 'Api\V1\ClientController');
        Route::apiResource('/projects', 'Api\V1\ProjectController');
    });

});