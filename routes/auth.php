<?php

use App\Http\Controllers\Auth\AuthenticateController;
use Illuminate\Support\Facades\Route;

Route::post('/authenticate', [AuthenticateController::class, 'authenticate'])->middleware('guest');

Route::get('/authenticate/verification/{user}/{entry}', [AuthenticateController::class, 'verify'])->name('api.authenticate.verification');

Route::post('/authenticate/password/set/{id}', [AuthenticateController::class, 'setPassword'])->name('api.authenticate.setPassword');
