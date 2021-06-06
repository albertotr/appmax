<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/auth', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/logout', function (Request $request) {
        Session::put(['user_attempt' => 1]);
        $request->user()->currentAccessToken()->delete();
    });
});

Route::get('/{any}', function () {
    return view('welcome');
});
