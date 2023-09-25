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


Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [UserController::class, 'logout']);

    Route::apiResource('users', UserController::class);

    Route::apiResource('answersLikes', AnswersLikeController::class);

    Route::apiResource('discussions', DiscussionController::class);

    Route::apiResource('discussionsAnswers', DiscussionsAnswerController::class);

    Route::apiResource('discussionsLikes', DiscussionsLikeController::class);

    Route::apiResource('followedUsers', FollowedUserController::class);

    Route::apiResource('followers', FollowerController::class);
});
