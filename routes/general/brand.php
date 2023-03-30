<?php

use App\Http\Controllers\General\BrandController;
use Illuminate\Support\Facades\Route;

Route::prefix('/brand')->group(function () {
    Route::get('/', [BrandController::class, 'index']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/', [BrandController::class, 'store']);
        Route::patch('/{id}', [BrandController::class, 'update']);
        Route::delete('/{id}', [BrandController::class, 'trash']);
        Route::put('/{id}/restore', [BrandController::class, 'restore']);
    });

});
