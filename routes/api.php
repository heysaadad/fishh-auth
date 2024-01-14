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
    Route::post('/register', [AuthenticationController::class, 'Register'])->name('api.auth.register');
    Route::post('/login', [AuthenticationController::class,'Login'])->name('api.auth.login');
    //Route::get('/profile', [AuthenticationController::class,'profile'])->name('api.auth.profile')->middleware('auth:api');
    Route::get('/logout', [AuthenticationController::class,'Logout'])->name('api.auth.logout')->middleware('auth:api');
    Route::post('/send-verification-email/{email}', [AuthenticationController::class,'sendEmailVerificationLink'])->name('api.auth.sendVEmail')->middleware('auth:api');
});

Route::group(["prefix" => 'user'], function () {
    Route::get('/getinterest/{id}', [InterestController::class,'getUserInterests'])->name('api.user.getinterest');
    Route::get('/getprofile/{id}', [ProfileController::class,'getUserProfile'])->name('api.user.getprofile')->middleware('auth:api');
    Route::get('/getmatches/{id}', [MatchController::class,'getUserMatches'])->name('api.user.getmatches')->middleware('auth:api');
    Route::post('/getmessage', [MessageController::class,'getUserMessages'])->name('api.user.getmessage');
    Route::post('/updateprofile/{id}', [UserController::class,'updateUserProfile'])->name('api.user.updateprofile');
    //QUEUE
    // Route::post('/creatematch', [MatchController::class,'createUserMatch']);
});
