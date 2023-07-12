<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\StoreController;

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

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/stores', [StoreController::class, 'store'])->middleware('auth:sanctum');
Route::get('/stores', [StoreController::class, 'index'])->middleware('auth:sanctum');
Route::put('/stores/{store}', [StoreController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/stores/{store}', [StoreController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('/user/stores', [StoreController::class, 'userStores'])->middleware('auth:sanctum');