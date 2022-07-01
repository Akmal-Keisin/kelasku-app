<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['guest'])->group(function () {
    Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
    Route::post('/auth/login', [AuthController::class, 'authLogin']);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('/kelasku', UserController::class)->name("get", "home");
    Route::resource('/admin', AdminController::class)->except('show');
    Route::get('/', function () {
        return redirect('/kelasku');
    });
    Route::post('/auth/logout', [AuthController::class, 'authLogout']);
});
