<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TripController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/trips', [TripController::class, 'index']);

Route::post('/trips/store', [TripController::class, 'store'])->name('trips.store');