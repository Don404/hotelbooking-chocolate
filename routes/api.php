<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\RoomController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;




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


Route::middleware('auth:sanctum')->group(function () {
    // Create a new room
    Route::post('/rooms', [RoomController::class, 'store']);
    // Create a new customer
    Route::post('/customers', [CustomerController::class, 'store']);
    // Create a new booking
    Route::post('/bookings', [BookingController::class, 'store']);
    // Record a payment
    Route::post('/payments', [PaymentController::class, 'store']);
});

// User Login
Route::post('/login', [AuthController::class, 'login'])->name('login');

// List all rooms
Route::get('/rooms', [RoomController::class, 'index']);

// Get details of a specific room
Route::get('/rooms/{id}', [RoomController::class, 'show']);

// List all customers
Route::get('/customers', [CustomerController::class, 'index']);

// List all bookings
Route::get('/bookings', [BookingController::class, 'index']);



