<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\AuthController;
use App\Http\Controllers\API\Movies;

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

Route::group(
    [
        'prefix' => 'user',
        'namespace' => 'User',
    ],
    function () {
        Route::post('register', [AuthController::class, "register"]);
        Route::post('login', [AuthController::class, "login"]);
        Route::post("movie/add", "Movies@store");
        Route::get("movie/get-all/{token}", "Movies@index");
        Route::patch("movie/update/{id}", "Movies@update");
        Route::delete("movie/delete/{id}", "Movies@destroy");
        Route::get("movie/get-single/{id}", "Movies@getSingleData");
    }
);

Route::group(
    [
        'prefix' => 'user',
        'namespace' => 'API',
    ],
    function () {
        Route::post("movies", "Movies@store");
        Route::get("movies", "Movies@index");
        Route::patch("movie/{movie}", "Movies@update");
        Route::delete("movie/{movie}", "Movies@destroy");
        Route::get("movie/{movie}", "Movies@getSingleData");
    }
);
