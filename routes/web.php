<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenresController;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/books', function () {
    return view('books');
});

Route::get('/genres', function () {
    return view('genres');
});


Route::get('/students', function () {
    return view('students');
});

Route::resource('genres', GenresController::class);
