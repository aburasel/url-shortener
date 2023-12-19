<?php

use App\Http\Controllers\Api\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::middleware('guest:api')->group(function () {

    Route::post('/auth/register', [LoginController::class, 'register'])->name('register');

    Route::post('/auth/login', [LoginController::class, 'login'])->name('login');

});
