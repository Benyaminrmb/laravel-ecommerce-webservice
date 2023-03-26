<?php

use App\Http\Controllers\General\BrandController;

Route::prefix('/brand')->group(function () {
    Route::get('/', [BrandController::class, 'index']);
    Route::middleware('auth:api')->group(function () {
        Route::post('/', [BrandController::class, 'store']);
        Route::put('/{brand}', [BrandController::class, 'update']);
        Route::delete('/{brand}', [BrandController::class, 'trash']);
        Route::put('/{brand}/restore', [BrandController::class, 'restore']);
    });
});
