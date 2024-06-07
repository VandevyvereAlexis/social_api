<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::apiResource("users", App\Http\Controllers\API\UserController::class);
Route::apiResource("posts", App\Http\Controllers\API\PostController::class);
Route::apiResource("comments", App\Http\Controllers\API\CommentController::class);
