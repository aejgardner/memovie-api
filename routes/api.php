<?php

use App\Policies\UserAccessMoviePolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authorize;
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

// authorization via policies in progress

// Route::group(['prefix' => 'user'], function () {
//     Route::post('register', [AuthController::class, "register"]);
//     Route::post('login', [AuthController::class, "login"]);

//     Route::group(['prefix' => '{user}'], function () {

//         Route::group(['prefix' => 'movies', 'middleware' => 'can:UserAccess,movie'], function () {
//             Route::get("", [Movies::class, "index"]);
//             Route::post("", [Movies::class, "store"]);

//             Route::group(['prefix' => '{movie}', 'middleware' => ['can:UserAccess,movie']], function () {
//                 Route::put("{movie}", [Movies::class, "update"]);
//                 Route::delete("{movie}", [Movies::class, "destroy"]);
//             });
//         });
//     });
// });

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
