<?php

use App\Http\Controllers\CompetitorController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\UserController;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'users'], function () {

    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::put('/setPassword', [UserController::class, 'setPassword']);
    Route::get('/getUser/{name}', [UserController::class, 'getUser']);
    Route::put('/setSpecialization', [UserController::class, 'setSpecialization']);
    Route::get('/getSpecialization/{academic_year}/{user_name}', [UserController::class, 'getSpecialization']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/logout', [UserController::class, 'logout']);
        Route::put('/resetPassword', [UserController::class, 'resetPassword']);
        Route::put('/editUser', [UserController::class, 'edit']);
        Route::get('/currentUser', [UserController::class, 'current']);
        Route::put('/refreshToken', [UserController::class, 'refresh']);
    });
});

Route::group([
    'prefix' => 'competitors',
    'middleware' => 'auth:api'
], function () {
    Route::post('/addCompetitor', [CompetitorController::class, 'addCompetitor']);
    Route::delete('/deleteCompetitor', [CompetitorController::class, 'deleteCompetitor']);
    Route::get('/getCompetitors/{academic_year}/{specialization}', [CompetitorController::class, 'getCompetitors']);
    Route::get('/getOrderOfMyClass/{academic_year}/{specialization}', [CompetitorController::class, 'getOrderOfMyClass']);
});

Route::group(['prefix' => 'materials'], function () {

    Route::put('/editDegree', [MaterialController::class, 'editDegree']);
    Route::get('/getMaterials/{academic_year}/{specialization}', [MaterialController::class, 'getMaterialsForYearAndSpecialization']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/addDegree', [MaterialController::class, 'addDegree']);
        Route::get('/getDegree/{material}', [MaterialController::class, 'getDegreeForMaterial']);
        Route::get('/getDegrees/{academic_year}/{specialization}', [MaterialController::class, 'getDegreesForAcademicYear']);
        Route::get('/getGBA/{academic_year}', [MaterialController::class, 'getGBA']);
        Route::post('/calcGBA', [MaterialController::class, 'calcGBA']);
    });
});