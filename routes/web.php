<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InscricoesController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['web'])->group(function () {
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('login', [AuthController::class, 'auth'])->name('auth');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('registro', [AuthController::class, 'registro'])->name('registro');
    Route::post('registro', [AuthController::class, 'registrar'])->name('registrar');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');

    Route::resource('eventos', EventosController::class);
    Route::resource('inscricao', InscricoesController::class);
});