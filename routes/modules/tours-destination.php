<?php 
use App\Http\Controllers\TourDestinationController;

Route::get('/tours-by-destination', [TourDestinationController::class, 'getToursByDestination']);
Route::get('/total-tours', [TourDestinationController::class, 'getTotalTours']);
