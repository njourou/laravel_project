<?php
use App\Http\Controllers\BookingController;

Route::post('/', [BookingController::class, 'store']);
Route::get('/total', [BookingController::class, 'getTotalBookings']);


Route::get('/{id}', [BookingController::class, 'show']);

Route::put('/{id}', [BookingController::class, 'update']);
Route::delete('/{id}', [BookingController::class, 'destroy']);
Route::get('/', [BookingController::class, 'index']);
