<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChatController;

Route::get('/', [AuthController::class, 'registration'])->name('register');
Route::post('registerPost', [AuthController::class, 'registerPost'])->name('registerPost');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('loginPost', [AuthController::class, 'loginPost'])->name('loginPost');

Route::middleware('auth')->group(function () {
    Route::get('home', [HomeController::class, 'home'])->name('home');
    Route::get('/chat/{id}', [HomeController::class, 'chat'])->name('chat');
    Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('sendMessage');
    Route::post('/get-messages', [ChatController::class, 'getMessages'])->name('getMessages');
    Route::post('/search-users', [HomeController::class, 'searchUsers'])->name('search-users');
    Route::get('/get-users', [HomeController::class, 'getUsers'])->name('get-users');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
