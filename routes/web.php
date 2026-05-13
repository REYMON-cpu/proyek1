<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/verify', function () {
    return view('verify');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});


Route::post('/review-store', [ReviewController::class, 'store'])->name('review.store');





