<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

Route::post('appointments', [AppointmentController::class, 'store']);
Route::get('appointments', [AppointmentController::class, 'index']);
Route::put('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus']);
Route::get('/appointments/today', [AppointmentController::class, 'todayQueue']);
Route::get('/appointments/all', [AppointmentController::class, 'allQueue']);

Route::get('test', function() {
    return response()->json(['message' => 'API is working']);
}); 