<?php

use App\Http\Controllers\Admin\{
    BookController,
    GenresController,
    StudentsController,
    LoginController
};
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::view('/login', 'pages.admin.login')->name('login');
        Route::post('/login', [LoginController::class, 'login']);
    });

    Route::middleware('auth:admin')->group(function () {
        // Dashboard
        Route::view('/', 'pages.admin.dashboard')->name('dashboard');

        // Logout
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        // Books Routes
        Route::prefix('books')->name('books.')->group(function () {
            Route::get('/', [BookController::class, 'index'])->name('index');
            Route::post('/', [BookController::class, 'store'])->name('store');
            Route::delete('/delete', [BookController::class, 'bulkDelete'])->name('bulkDelete');
            Route::get('/{year}/{genre}/{id}', [BookController::class, 'preview'])
                ->where(['year' => '[0-9]+', 'id' => '[0-9]+'])
                ->name('preview');
            Route::get('/api/{year}/{genre}/{id}/pdf', [BookController::class, 'servePdf'])
                ->where(['year' => '[0-9]+', 'id' => '[0-9]+'])
                ->name('serve');
        });

        // Genres Routes
        Route::prefix('genres')->name('genres.')->group(function () {
            Route::get('/', [GenresController::class, 'index'])->name('index');
            Route::post('/', [GenresController::class, 'store'])->name('store');
            Route::delete('/delete', [GenresController::class, 'bulkDelete'])->name('delete');
        });

        // Students Routes
        Route::prefix('students')->name('students.')->group(function () {
            Route::get('/', [StudentsController::class, 'index'])->name('index');
            Route::post('/', [StudentsController::class, 'store'])->name('import');
            Route::delete('/', [StudentsController::class, 'bulkDelete'])->name('delete');
        });
    });
});
