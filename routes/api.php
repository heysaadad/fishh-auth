<?php

use App\Http\Controllers\Api\Auth\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Fishh\InterestController;
use App\Http\Controllers\Api\Fishh\MatchController;
use App\Http\Controllers\Api\Fishh\MessageController;
use App\Http\Controllers\Api\Fishh\ProfileController;
use App\Http\Controllers\Api\User\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(["prefix" => 'auth'], function () {
    Route::post('/register', [AuthenticationController::class, 'Register']);
    Route::post('/login', [AuthenticationController::class,'Login']);
    Route::get('/profile', [AuthenticationController::class,'profile']);
    Route::get('/logout', [AuthenticationController::class,'Logout'])->middleware('auth:api');
});

Route::group(["prefix" => 'user'], function () {
    Route::get('/getinterest/{id}', [InterestController::class,'getUserInterests']);
    Route::get('/getprofile/{id}', [ProfileController::class,'getUserProfile'])->middleware('auth:api');;
    Route::get('/getmatches/{id}', [MatchController::class,'getUserMatches']);
    Route::post('/getmessage', [MessageController::class,'getUserMessages']);
    Route::post('/updateprofile/{id}', [UserController::class,'updateUserProfile']);
    Route::post('/creatematch', [MatchController::class,'createUserMatch']);
});
