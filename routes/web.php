<?php

use App\Http\Controllers\Admin\{
    BookController as AdminBookController,
    ClassroomController,
    GenresController,
    StudentsController,
    LoginController as AdminLoginController,
    BorrowRequestsController as AdminBorrowRequestsController
};
use App\Http\Controllers\Client\{
    HomeController,
    BookController as ClientBookController,
    LoginController as ClientLoginController,
    BorrowBookController as ClientBorrowBookController
};
use Illuminate\Support\Facades\Route;

Route::view('/login', 'pages.client.login')->name('login');
Route::post('/login', [ClientLoginController::class, 'login'])->name('client.login');
Route::post('/guest', [ClientLoginController::class, 'continueAsGuest'])->name('client.guest');

// Client routes - no middleware needed
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/logout', [ClientLoginController::class, 'logout'])->name('client.logout');

// Books Routes (Client)
Route::prefix('books')->name('books.')->group(function () {
    Route::get('/{year}/{genre}/{id}', [ClientBookController::class, 'preview'])
        ->where(['year' => '[0-9]+', 'id' => '[0-9]+'])
        ->name('preview');
    Route::get('/api/{year}/{genre}/{id}/pdf', [ClientBookController::class, 'servePdf'])
        ->where(['year' => '[0-9]+', 'id' => '[0-9]+'])
        ->name('serve');
});

Route::prefix('borrow')->name('borrow.')->group(function () {
    Route::post('/create', [ClientBorrowBookController::class, 'store'])->name('store');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::view('/login', 'pages.admin.login')->name('login');
        Route::post('/login', [AdminLoginController::class, 'login']);
    });

    Route::middleware('auth:admin')->group(function () {
        // Dashboard
        Route::view('/', 'pages.admin.dashboard')->name('dashboard');

        // Logout
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

        // Books Routes (Admin)
        Route::prefix('books')->name('books.')->group(function () {
            Route::get('/', [AdminBookController::class, 'index'])->name('index');
            Route::post('/', [AdminBookController::class, 'store'])->name('store');
            Route::delete('/delete', [AdminBookController::class, 'bulkDelete'])->name('bulkDelete');
            Route::get('/{year}/{genre}/{id}', [AdminBookController::class, 'preview'])
                ->where(['year' => '[0-9]+', 'id' => '[0-9]+'])
                ->name('preview');
            Route::get('/api/{year}/{genre}/{id}/pdf', [AdminBookController::class, 'servePdf'])
                ->where(['year' => '[0-9]+', 'id' => '[0-9]+'])
                ->name('serve');
        });

        // Genres Routes
        Route::prefix('genres')->name('genres.')->group(function () {
            Route::get('/', [GenresController::class, 'index'])->name('index');
            Route::post('/', [GenresController::class, 'store'])->name('store');
            Route::delete('/delete', [GenresController::class, 'bulkDelete'])->name('delete');
        });

        // Classroom Routes
        Route::prefix('classrooms')->name('classrooms.')->group(function () {
            Route::get('/', [ClassroomController::class, 'index'])->name('index');
            Route::post('/create', [ClassroomController::class, 'store'])->name('store');
            Route::delete('/delete', [ClassroomController::class, 'bulkDelete'])->name('bulkDelete');
        });

        // Students Routes
        Route::prefix('students')->name('students.')->group(function () {
            Route::get('/', [StudentsController::class, 'index'])->name('index');
            Route::post('/', [StudentsController::class, 'store'])->name('store');
            Route::post('/import', [StudentsController::class, 'import'])->name('import');
            Route::delete('/', [StudentsController::class, 'bulkDelete'])->name('delete');
            Route::put('/reset', [StudentsController::class, 'passwordReset'])->name('reset');
        });

        // Borrow request Routes
        Route::prefix('borrow-requests')->name('borrow-requests.')->group(function () {
            Route::get('/', [AdminBorrowRequestsController::class, 'index'])->name('index');
            Route::put('/borrow-requests/{id}', [AdminBorrowRequestsController::class, 'update'])->name('update');
        });
    });
});
