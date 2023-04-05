<?php

use App\Http\Controllers\General\UploadController;
use Illuminate\Support\Facades\Route;

Route::prefix('/upload')->group(function () {
    Route::get('/{upload}', [UploadController::class, 'show']);


    Route::middleware('auth:api')->group(function () {
        Route::post('/', [UploadController::class, 'store']);
        Route::post('/{upload}', [UploadController::class, 'update']);
        Route::delete('/{upload}', [UploadController::class, 'trash']);
        Route::delete('/{upload}/delete', [UploadController::class, 'delete'])->withTrashed();
        Route::post('/{upload}/restore', [UploadController::class, 'restore'])->withTrashed();
    });
});
