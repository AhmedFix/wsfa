<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\CategoryController;

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

Route::post('v1/register', [AuthController::class, 'register']);
Route::post('v1/login', [AuthController::class, 'login']);
Route::post('v1/forgot-password', [AuthController::class, 'forgotPassword']);

Route::middleware('auth:sanctum')->prefix('v1')->group( function () {
  Route::apiResource('recipes', RecipeController::class);
  Route::apiResource('categories', CategoryController::class);
  Route::post('logout', [AuthController::class, 'logout']);
  Route::post('update-password',[AuthController::class, 'updatePassword']);
});
