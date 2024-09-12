<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReelController;
use Illuminate\Http\Request;
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
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:api')->group(function () {
    Route::post('reels', [ReelController::class, 'uploadReel']);
    Route::get('reels', [ReelController::class, 'getReels']);
});
