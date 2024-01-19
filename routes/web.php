<?php

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDataController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserDataController::class, 'createForm'])->name('show.form');
Route::post('/', [UserDataController::class, 'submitForm'])->name('submit.form');
Route::get('/login', [UserDataController::class, 'loginInterface'])->name('show.login');
Route::post('/login', [UserDataController::class, 'loginForm'])->name('login.form');
Route::post('/logout', [UserDataController::class, 'logout']);

Route::get('/room', [RoomController::class, 'index']);
Route::post('/room', [RoomController::class, 'createRoom'])->name('add.room');
Route::get('/room/{id}', [RoomController::class, 'showRoom']);

Route::post('/room/{id}', [ImageController::class, 'upload'])->name('upload');
Route::post('/room/{id}/approve', [ImageController::class, 'approve'])->name('approve');
Route::post('/room/{id}/reject', [ImageController::class, 'reject'])->name('reject');

Route::get('/room/{id}/add', [RoomController::class, 'showMembers']);
Route::post('/room/{id}/add', [RoomController::class, 'addMembers'])->name('add.member');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'googleLogin']);
