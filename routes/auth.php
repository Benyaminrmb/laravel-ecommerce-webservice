<?php

use App\Http\Controllers\Auth\AuthenticateController;
use Illuminate\Support\Facades\Route;

Route::post('/authenticate', [AuthenticateController::class, 'authenticate'])->middleware('guest');

Route::post('/authenticate/verification', [AuthenticateController::class, 'verify'])
    ->middleware('auth:api')
    ->name('api.authenticate.verification');

Route::put('/authenticate/password/', [AuthenticateController::class, 'setPassword'])
    ->middleware('auth:api')
    ->name('api.authenticate.setPassword');
