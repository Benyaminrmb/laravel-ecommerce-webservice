<?php


use App\Http\Controllers\General\CategoryController;

//Route::resource('/', CategoryController::class,['only' => ['index','show']]);
Route::prefix('/category')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::middleware('auth:api')->group(function () {
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('/{category}', [CategoryController::class, 'update']);
        Route::put('/{category}/restore', [CategoryController::class, 'restore']);
     });
});
