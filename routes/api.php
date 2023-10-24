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

Route::controller(UserController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/users/store', 'store');
    Route::post('/send-verification-token', 'sendVerificationToken');
    Route::get('/receive-verification-token/{id}', 'receiveVerificationToken');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/user',  function (Request $request) {
            return $request->user();
        });
        Route::get('/users', 'index');
        Route::get('/users/{id}', 'show');
        Route::put('/users', 'update');
        Route::delete('/users', 'destroy');
        Route::post('/logout', 'logout');
    });

    Route::controller(DiscussionController::class)->group(function () {
        Route::get('/discussions/filtered/{filterId}', 'indexFiltered');
    });

    Route::controller(DiscussionsAnswerController::class)->group(function () {
        Route::get('/discussionsAnswers/filtered/{discussionId}', 'indexFiltered');
    });

    Route::apiResources([
        'users' => UserController::class,
        'answersLikes' => AnswersLikeController::class,
        'discussions' => DiscussionController::class,
        'discussionsAnswers' => DiscussionsAnswerController::class,
        'discussionsLikes' => DiscussionsLikeController::class,
        'followedUsers' => FollowedUserController::class,
        'followers' => FollowerController::class
    ]);
    Route::get('/discussionsAnswers/{discussionId}', [DiscussionsAnswerController::class, 'index']);
});
