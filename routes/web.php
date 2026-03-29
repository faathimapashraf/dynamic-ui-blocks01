<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UiBlockController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']); // POST instead of GET

Route::get('/client', [ClientController::class, 'dashboard'])->middleware('auth');

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
    Route::get('/admin/blocks', [UiBlockController::class, 'index']);
    Route::post('/admin/blocks', [UiBlockController::class, 'store']);
    Route::post('/admin/blocks/{id}', [UiBlockController::class, 'update']);
    Route::delete('/admin/blocks/{id}', [UiBlockController::class, 'destroy']);
});