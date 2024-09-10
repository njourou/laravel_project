<?php
use App\Http\Controllers\UserController;

Route::get('/count', [UserController::class, 'countUsers']);
Route::delete('/{id}', [UserController::class, 'deleteUser']);
