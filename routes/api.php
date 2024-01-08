<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\NutrientController;
use App\Http\Controllers\WorkoutController;
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
    Route::get('all', 'allUsers');
    Route::put('update', 'update');
    Route::put('password', 'updatePassword');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('image', 'storeImage');
    Route::post('lvl', 'levelUp');
});

Route::get('/getImage/{filename}', [AuthController::class, 'showImage']);

//Foods
Route::get('/foods', [FoodController::class, 'index']);
Route::post('/foods', [FoodController::class, 'create']);
Route::post('/foods/{id}', [FoodController::class, 'update']);
Route::delete('/foods/{id}', [FoodController::class, 'delete']);

//Nutrient
Route::get('/kcal', [NutrientController::class, 'getNutrientById']);
Route::post('/kcal', [NutrientController::class, 'create']);
Route::post('/kcal/{id}', [NutrientController::class, 'update']);
Route::delete('/kcal/{id}', [NutrientController::class, 'delete']);

//Workout
Route::get('/workout', [WorkoutController::class, 'index']);
Route::post('/workout', [WorkoutController::class, 'store']);
Route::post('/workout/{id}', [WorkoutController::class, 'update']);
Route::delete('/workout/{id}', [WorkoutController::class, 'delete']);

// Post
Route::get('/posts', [PostController::class, 'index']); // all posts
Route::post('/posts', [PostController::class, 'store']); // create post
Route::get('/posts/{id}', [PostController::class, 'show']); // get single post
Route::post('/posts/{id}', [PostController::class, 'update']); // update post
Route::delete('/posts/{id}', [PostController::class, 'destroy']); // delete post

// Comment
Route::get('/posts/{id}/comments', [CommentController::class, 'index']); // all comments of a post
Route::post('/posts/{id}/comments', [CommentController::class, 'store']); // create comment on a post
Route::post('/comments/{id}', [CommentController::class, 'update']); // update a comment
Route::delete('/comments/{id}', [CommentController::class, 'destroy']); // delete a comment

// Like
Route::post('/posts/{id}/likes', [LikeController::class, 'likeOrUnlike']); // like or dislike back a post

//Feedback
Route::get('/feedback', [FeedbackController::class, 'index']);
Route::post('/feedback', [FeedbackController::class, 'store']);
Route::delete('/feedback/{id}', [FeedbackController::class, 'delete']);

//Coaches
Route::get('/coaches', [CoachController::class, 'index']);
Route::post('/coaches', [CoachController::class, 'create']);
Route::post('/coaches/rate/{id}', [CoachController::class, 'updateRate']);
Route::post('/coaches/{id}', [CoachController::class, 'update']);
Route::delete('/coaches/{id}', [CoachController::class, 'delete']);

//Appointments
Route::get('/appointment', [AppointmentController::class, 'indexByUser']);
Route::get('/appointment/{id}', [AppointmentController::class, 'getRatings']);
Route::post('/appointment', [AppointmentController::class, 'store']);
Route::post('/appointment/{id}', [AppointmentController::class, 'update']);
Route::post('/appointment/rate/{id}', [AppointmentController::class, 'updateRate']);