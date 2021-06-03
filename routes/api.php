<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/product', [ProductController::class, 'index']);
    Route::put('/product', [ProductController::class, 'store']);
    Route::post('/product', [ProductController::class, 'create']);
    Route::delete('/product/{product}', [ProductController::class, 'destroy']);
});
