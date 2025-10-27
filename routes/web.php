<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenresController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/genres', function () {
    return view('');
});

Route::resource('genres', GenresController::class);
