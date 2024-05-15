<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/signup', function () {
    return view('signup');
})->name('signup');
Route::get('/signin', function () {
    return view('signin');
})->name('signin');
