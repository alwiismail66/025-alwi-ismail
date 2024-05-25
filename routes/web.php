<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/', 'showHome')->name('home');
    });
});
Route::controller(UserController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/signup', 'showSignup')->name('userShowSignup');
        Route::post('/signup', 'signup')->name('userSignup');
        Route::get('/signin', 'showSignin')->name('userShowSignin');
        Route::post('/signin', 'authenticate')->name('userAuthenticate');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/logout', 'logout')->name('logout');
    });
});

Route::controller(TaskController::class)->name('task.')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::prefix('task')->group(function () {
            Route::get('/add', 'showAdd')->name('showAdd');
            Route::post('/add', 'store')->name('store');
        });
        Route::put('/', 'toggleStatus')->name('toggleStatus');
    });
});
