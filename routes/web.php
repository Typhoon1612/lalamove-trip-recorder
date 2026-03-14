<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TripController;

// The pages we can view
Route::get('/', [HomeController::class, 'index']);
Route::get('/trips', [TripController::class, 'index']);

// The secret backdoor to catch our form submissions
Route::post('/trips/store', [TripController::class, 'store'])->name('trips.store');

// NEW: The path to throw away a mistake!
Route::delete('/trips/{id}', [TripController::class, 'destroy'])->name('trips.destroy');

Route::get('/trips/export', [TripController::class, 'export'])->name('trips.export');