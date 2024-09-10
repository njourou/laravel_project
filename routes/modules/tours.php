<?php
use App\Http\Controllers\TourController;

Route::apiResource('/', TourController::class);
Route::get('/total', [TourController::class, 'getTotalTours']);
Route::get('/{id}', [TourController::class, 'show']);
Route::get('/{id}', [TourController::class, 'show']);

Route::put('/{id}', [TourController::class, 'update']);
Route::delete('/{id}', [TourController::class, 'destroy']);
Route::get('/total', [TourController::class, 'getTotalTours']);