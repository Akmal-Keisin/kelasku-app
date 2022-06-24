<?php

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\LikeController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/kelasku', [UserApiController::class, 'index']);
    Route::get('/kelasku/{id}', [UserApiController::class, 'show']);
    Route::put('/kelasku', [UserApiController::class, 'update']);
    Route::post('/kelasku/like/add/{id}', [LikeController::class, 'like']);
    Route::post('/kelasku/logout', [AuthApiController::class, 'logout']);
    Route::post('/kelasku/like/{id}', [LikeController::class, 'add']);
});

Route::post('/kelasku/register', [AuthApiController::class, 'register']);
Route::post('/kelasku/login', [AuthApiController::class, 'login']);
