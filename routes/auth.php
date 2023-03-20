<?php

use App\Http\Controllers\Auth\AuthenticateController;
use Illuminate\Support\Facades\Route;

Route::post('/authenticate', [AuthenticateController::class, 'authenticate'])
    ->middleware('guest');
Route::get('/authenticate/verification/{user}', [AuthenticateController::class, 'verify'])
    ->name('api.authenticate.verification');
