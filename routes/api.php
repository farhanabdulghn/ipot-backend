<?php

use App\Http\Controllers\Api\V1\MenuController;
use App\Http\Controllers\Api\V1\MenuItemController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\TableController;
use App\Http\Controllers\Api\V1\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/menu', [MenuController::class, 'index']);
    Route::patch('/menu-items/{id}', [MenuItemController::class, 'update']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus']);
    Route::get('/tables/{tableId}/status', [TableController::class, 'status']);
    Route::get('/orders', [OrderController::class, 'index']);
});