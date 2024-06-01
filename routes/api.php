<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ItemController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('user', [AuthController::class, 'user']);
//     Route::post('logout', [AuthController::class, 'logout']);
    
//     Route::apiResource('items', ItemController::class);
// });



Route::get('items', [ItemController::class, 'index']);
Route::get('items/{item}', [ItemController::class, 'show']);

// Protected routes for authenticated users
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('items', [ItemController::class, 'store']);
    Route::put('items/{item}', [ItemController::class, 'update']);
    Route::delete('items/{item}', [ItemController::class, 'destroy']);
});
