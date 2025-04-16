<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TodoItemController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('register', 'register')->name('register');
});

Route::middleware('jwt')->group(function () {
    Route::controller(TodoController::class)->prefix('checklist')->group(function () {
        // Get checklist API
        Route::get('/', 'index')->name('checklist.index');
        Route::post('/', 'store')->name('checklist.store');
        Route::get('/{id}', 'show')->name('checklist.show');
        Route::delete('/{id}', 'destroy')->name('checklist.destroy');
        Route::put('/{id}', 'update')->name('checklist.update');
        // Get Checklist Item API
        Route::controller(TodoItemController::class)->prefix('{id}/item')->group(function () {
            Route::get('/', 'index')->name('item.index');
            Route::post('/', 'store')->name('item.store');
            Route::get('/{item_id}', 'show')->name('item.show');
            Route::put('/{item_id}', 'update')->name('item.update');
            Route::put('/rename/{item_id}', 'rename')->name('item.rename');
            Route::delete('/{item_id}', 'destroy')->name('item.destroy');
        });
    });
});
