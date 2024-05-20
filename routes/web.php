<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/signup', 'showSignup')->name('userShowSignup');
        Route::post('/signup', 'signup')->name('userSignup');
        Route::get('/signin', 'showSignin')->name('userShowSignin');
        Route::post('/signin', 'authenticate')->name('authenticate');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/', function () {
            return view('index');
        })->name('home');
        Route::get('/logout', 'logout')->name('logout');
    });
});
