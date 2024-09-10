<?php

use App\Http\Controllers\DestinationController;

Route::get('/', [DestinationController::class, 'index']);
Route::get('/{id}', [DestinationController::class, 'show']);
Route::post('/', [DestinationController::class, 'store']);
Route::put('/{id}', [DestinationController::class, 'update']);
Route::delete('/{id}', [DestinationController::class, 'destroy']);
Route::get('/total', [DestinationController::class, 'getTotalDestinations']);
