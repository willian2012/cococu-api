<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityParticipantsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectParticipantsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
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
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [UserController::class, 'store']);
Route::get('images', [ImageController::class, 'index']);
Route::get('products', [ProductController::class, 'index']);
Route::get('projects', [ProjectController::class, 'index']);
Route::get('activities', [ActivityController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('avatar/{user_id}', [UserController::class, 'uploadAvatar']);
    Route::put('changepassword/{user_id}', [UserController::class, 'changePassword']);
    Route::resource('users', UserController::class)->only(['index', 'store', 'show', 'destroy']);
    Route::post('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('logout', [AuthController::class, 'logout']);
    Route::resource('roles', RoleController::class);
    Route::resource('product', ProductController::class)->only(['index', 'store', 'show', 'destroy']);
    Route::post('product/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::resource('image', ImageController::class)->only(['index', 'store', 'show', 'destroy']);
    Route::post('image/{id}', [ImageController::class, 'update'])->name('image.update');
    Route::resource('project', ProjectController::class)->only(['index', 'store', 'show', 'destroy']);
    Route::post('project/{id}', [ProjectController::class, 'update'])->name('project.update');
    Route::resource('activity', ActivityController::class)->only(['index', 'store', 'show', 'destroy']);
    Route::post('activity/{id}', [ActivityController::class, 'update'])->name('activity.update');
    Route::resource('participantproject', ProjectParticipantsController::class);
    Route::resource('participantactivity', ActivityParticipantsController::class);
    Route::get('participantactivities/{user_id}', [ActivityParticipantsController::class, 'getActivitiesForUser']);
    Route::get('participantprojects/{user_id}', [ProjectParticipantsController::class, 'getProjectsForUser']);
});

