<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\User\AuthController;
use App\Http\Controllers\API\User\Movies;

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

Route::group(['prefix' => 'user'], function () {
    Route::post('register', [AuthController::class, "register"]);
    Route::post('login', [AuthController::class, "login"]);
});

Route::group(['prefix' => 'user/movies'], function () {
    Route::get("", [Movies::class, "index"]);
    Route::post("", [Movies::class, "store"]);
    Route::put("{movie}", [Movies::class, "update"]);
    Route::delete("", [Movies::class, "clear"]);
    Route::delete("{movie}", [Movies::class, "destroy"]);
});
