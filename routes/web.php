<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/auth', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
});

Route::get('/{any}', function () {
    return view('welcome');
});
