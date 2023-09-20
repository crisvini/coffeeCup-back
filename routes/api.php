<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/users/show', [UserController::class, 'show']);
// Route::get('/users', [UserController::class, 'index']);
// Route::post('/users/store', [UserController::class, 'store']);

Route::apiResource('users', UserController::class);
