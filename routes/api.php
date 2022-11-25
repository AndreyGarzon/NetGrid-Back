<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FavoriteController;

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


Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::group(['prefix' => 'auth', 'middleware' => ['auth:sanctum'],], function () {
    Route::get('user-info', [AuthController::class, 'userInfo']);
    Route::put('user-aditional-info/{id}', [AuthController::class, 'userUpdateOptionalInfo']);
    Route::get('logout', [AuthController::class, 'logout']);
});
Route::group(['middleware' => ['auth:sanctum'],], function () {
    Route::post('favorite', [FavoriteController::class, 'favoriteAdd']);
    Route::get('favorite/{id}', [FavoriteController::class, 'favoriteByUserId']);
});
