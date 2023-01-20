<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostPublicController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
//Route::post('/login','App\Http\Controllers\AuthController@login');


Route::group(['middleware' => ['auth:sanctum']], function(){

    //User
    Route::get('/user',[AuthController::class, 'user']);
    Route::post('/logout',[AuthController::class, 'logout']);

   // Route::get('/posts',[PostController::class, 'index']); // get all post
   // Route::post('/posts',[PostController::class,'store']); //create post
   // Route::get('/posts/{id}',[PostController::class,'show']); // get single post
   // Route::put('/posts/{id}',[PostController::class,'update']); //update post
   // Route::delete('/posts/{id}',[PostController::class,'destroy']); //delete post
});

Route::get('/posts',[PostPublicController::class, 'index']);
Route::post('/posts',[PostPublicController::class,'store']);
Route::get('/posts/{id}',[PostPublicController::class,'show']);
Route::put('/posts/{id}',[PostPublicController::class,'update']);
Route::delete('/posts/{id}',[PostPublicController::class,'delete']);

Route::get('storage/{path}', [PostPublicController::class,'show1'])->where('path', '.+');
