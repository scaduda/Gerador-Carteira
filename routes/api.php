<?php

use App\Http\Controllers\RgbmController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function () {
    Route::get('/gerar-rgbm-frente', [RgbmController::class, 'gerarRgbmFrente']);
    Route::get('/gerar-rgbm-verso', [RgbmController::class, 'gerarRgbmVerso']);
    Route::post('/rgbm', [RgbmController::class, 'store']);
    Route::get('rgbm', [RgbmController::class, 'index']);
});
