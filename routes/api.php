<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
Route::group(['prefix' => config('app.version')], function () {
    // Auth routes
    Route::prefix('auth')->group(base_path('routes/modules/auth.php'));
    
    // Destinations routes
    Route::prefix('destinations')->group(base_path('routes/modules/destinations.php'));

    // Tours routes
    Route::prefix('tours')->group(base_path('routes/modules/tours.php'));

    // Bookings routes
    Route::prefix('bookings')->group(base_path('routes/modules/bookings.php'));
    Route::prefix('tours-destination')->group(base_path('routes/modules/tours-destination.php'));


});

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('users')->group(base_path('routes/modules/users.php'));
    
    // Fetch authenticated user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

