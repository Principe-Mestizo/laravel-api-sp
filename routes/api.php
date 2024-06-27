<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TypeUserController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::group([
    'prefix' => 'auth'
], function($router){
    Route::post('/login', [AuthController::class, 'login']);
});


Route::group(['prefix' => 'seminario'], function($router){


    Route::apiResource('/usuarios', UserController::class);

});