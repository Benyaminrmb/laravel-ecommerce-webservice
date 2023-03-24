<?php


use App\Http\Controllers\General\CategoryController;

Route::resource('/', CategoryController::class,['only' => ['index','show']]);
Route::resource('/', CategoryController::class,['only' => ['store','update','destroy']])
    ->middleware('auth:api');
