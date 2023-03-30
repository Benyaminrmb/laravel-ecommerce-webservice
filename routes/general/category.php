<?php

use App\Http\Controllers\General\CategoryController;
use Illuminate\Support\Facades\Route;

//Route::resource('/', CategoryController::class,['only' => ['index','show']]);
Route::prefix('/category')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('/{id}', [CategoryController::class, 'update']);
        Route::delete('/{id}', [CategoryController::class, 'trash']);
        Route::put('/{id}/restore', [CategoryController::class, 'restore']);
    });

});
