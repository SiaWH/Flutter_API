<?php

use App\Http\Controllers\NutrientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('details', 'details');
    Route::get('user', 'user');
    Route::put('update', 'update');
    Route::put('password', 'updatePassword');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('image', 'storeImage');
});

Route::get('/getImage/{filename}', [AuthController::class, 'showImage']);

//Nutrient
Route::post('/kcal/{userId}', [NutrientController::class, 'update']);

// Post
Route::get('/posts', [PostController::class, 'index']); // all posts
Route::post('/posts', [PostController::class, 'store']); // create post
Route::get('/posts/{id}', [PostController::class, 'show']); // get single post
Route::put('/posts/{id}', [PostController::class, 'update']); // update post
Route::delete('/posts/{id}', [PostController::class, 'destroy']); // delete post

// Comment
Route::get('/posts/{id}/comments', [CommentController::class, 'index']); // all comments of a post
Route::post('/posts/{id}/comments', [CommentController::class, 'store']); // create comment on a post
Route::put('/comments/{id}', [CommentController::class, 'update']); // update a comment
Route::delete('/comments/{id}', [CommentController::class, 'destroy']); // delete a comment

// Like
Route::post('/posts/{id}/likes', [LikeController::class, 'likeOrUnlike']); // like or dislike back a post