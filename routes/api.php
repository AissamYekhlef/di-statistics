<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntityTypeController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\StatisticsController;
use App\Models\EntityType;
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

Route::group([
    'prefix' => 'auth'

], function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});

Route::group([
    'middleware' => 'auth.jwt',

], function () {

    Route::get('/fields', [FieldController::class, 'index']);
    Route::get('/entitytypes', [EntityTypeController::class, 'index']);
    Route::get('/entitytypes/{entityType}', [EntityTypeController::class, 'show']);
    Route::get('/entitytypes/{entityType}/fields', [EntityTypeController::class, 'fields']);

    Route::group([
        'prefix' => 'statistics',
    ], 
    function(){
        // Route::get('fields', [StatisticsController::class, 'index']);
        Route::get('fields/{field}', [StatisticsController::class, 'field_statistics']);
    });

});