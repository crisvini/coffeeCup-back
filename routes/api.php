<?php

use App\Http\Controllers\AnswersLikeController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\DiscussionsAnswerController;
use App\Http\Controllers\DiscussionsLikeController;
use App\Http\Controllers\FollowedUserController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\UserController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::post('/logout', [UserController::class, 'logout']);
});

Route::post('/login', [UserController::class, 'login']);

// Route::apiResource('users', AnswersLikeController::class);

// Route::apiResource('users', DiscussionController::class);

// Route::apiResource('users', DiscussionsAnswerController::class);

// Route::apiResource('users', DiscussionsLikeController::class);

// Route::apiResource('users', FollowedUserController::class);

// Route::apiResource('users', FollowerController::class);
