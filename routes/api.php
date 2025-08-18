<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\BarangayClearanceController;
use App\Http\Controllers\RequestListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/add/barangay/clearance', [BarangayClearanceController::class, 'store']);
Route::delete('/delete/request/{id}', [ApiController::class, 'destroy']);
Route::put('/update/request/lists/{id}', [ApiController::class, 'update']);
Route::get('/transactions', [ApiController::class, 'index']);
Route::get('/processing/request', [ApiController::class, 'processing_request']);
Route::get('/ready_to_pick_up/request', [ApiController::class, 'ready_to_pick_up_request']);
Route::get('/released/request', [ApiController::class, 'released_request']);