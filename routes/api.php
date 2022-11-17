<?php

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

//Authenticated Employee Routes
Route::apiResource('employees', Api\EmployeeController::class)->middleware('auth:sanctum');

//API route for register new user
Route::post('/auth/register', [App\Http\Controllers\Api\AuthController::class, 'createUser']);
//API route for login user
Route::post('/auth/login', [App\Http\Controllers\Api\AuthController::class, 'loginUser']);
