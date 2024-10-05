<?php

use App\Http\Controllers\CompetitorController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'users'], function () {

    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::put('/setPassword', [UserController::class, 'setPassword']);


    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/logout', [UserController::class, 'logout']);
        Route::put('/resetPassword', [UserController::class, 'resetPassword']);
        Route::put('/editUser', [UserController::class, 'edit']);
        Route::get('/showUser', [UserController::class, 'show']);
    });
});

Route::group([
    'prefix' => 'competitors',
    'middleware' => 'auth:api'
], function () {
    Route::post('/addCompetitor', [CompetitorController::class, 'addCompetitor']);
    Route::delete('/deleteCompetitor', [CompetitorController::class, 'deleteCompetitor']);
});
