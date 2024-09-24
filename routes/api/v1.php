
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\BookController;
use App\Http\Controllers\API\V1\RentalController;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\StatsController;


Route::post('/login', [AuthController::class, 'login']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/search', [BookController::class, 'search']);
    Route::post('/rentals', [RentalController::class, 'store']);
    Route::put('/rentals/return/{id}', [RentalController::class, 'returnBook']);
    Route::get('/rentals/history', [RentalController::class, 'history']);
    Route::get('/stats/most-overdue-book', [StatsController::class, 'mostOverdueBook']);
    Route::get('/stats/most-popular-book', [StatsController::class, 'mostPopularBook']);
    Route::get('/stats/least-popular-book', [StatsController::class, 'leastPopularBook']);

});