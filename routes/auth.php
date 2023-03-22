<?php

use App\Http\Controllers\Auth\AuthenticateController;
use Illuminate\Support\Facades\Route;

Route::post('/authenticate', [AuthenticateController::class, 'authenticate'])->middleware('guest');

Route::post('/authenticate/verification', [AuthenticateController::class, 'verify'])
    ->middleware('auth:api')
    ->name('api.authenticate.verification');

Route::post('/authenticate/password/set/{id}', [AuthenticateController::class, 'setPassword'])->name('api.authenticate.setPassword');
