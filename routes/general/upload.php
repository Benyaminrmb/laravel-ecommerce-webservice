<?php

use App\Http\Controllers\General\UploadController;
use Illuminate\Support\Facades\Route;

Route::prefix('/upload')->group(function () {
    Route::get('/{id}', [UploadController::class, 'show']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/', [UploadController::class, 'store']);
        Route::post('/{id}', [UploadController::class, 'update']);
        Route::delete('/{id}', [UploadController::class, 'softDelete']);
        Route::delete('/{id}/delete', [UploadController::class, 'delete']);
        Route::post('/{id}/restore', [UploadController::class, 'restore']);
    });
});
