<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CarteiraController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('gerar-carteira-frente', [CarteiraController::class, 'gerarCarteiraFrente']);
Route::get('gerar-carteira-verso', [CarteiraController::class, 'gerarCarteiraVerso']);
