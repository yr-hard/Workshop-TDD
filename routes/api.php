<?php

use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController; // Add this line
use App\Http\Controllers\Api\Tweet\CreateCommentController;
use App\Http\Controllers\Api\Tweet\CreateTweetController;
use App\Http\Controllers\Api\Tweet\DeleteTweetController;
use App\Http\Controllers\Api\Tweet\EditTweetController;
use App\Http\Controllers\Api\Tweet\ListController;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', RegisterController::class);

Route::post('/login', LoginController::class);

Route::get('tweet/list', ListController::class)->middleware('auth:sanctum');

Route::post('tweet', CreateTweetController::class)->middleware('auth:sanctum');

Route::put('/tweet/{tweet}', EditTweetController::class)->middleware('auth:sanctum');

Route::delete('/tweet/{tweet}', DeleteTweetController::class)->middleware('auth:sanctum');

Route::post('/tweet/{tweet}/comments', CreateCommentController::class)->middleware('auth:sanctum');