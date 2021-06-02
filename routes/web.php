<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function () {
        $user = User::all();
        return response($user);
    });
});

Route::get('/{any}', function () {
    return view('welcome');
});
