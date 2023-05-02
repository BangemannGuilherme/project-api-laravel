<?php

use App\Http\Controllers\InscricoesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('/inscricao', function (Request $request, $id) {
    $inscricao = new InscricoesController;

    return $inscricao->store($request, $id);
})->name('api.inscricao');

Route::post('/eventos', function() {
    $eventos = App\Models\Eventos::all();
    return response()->json($eventos);
});

Route::post('/checkin', function(Request $request) {
    $inscricaoController = new InscricoesController;
    $checkin = $inscricaoController->checkin($request);

    return response()->json($checkin);
})->name('api.checkin');


// Route::get('inscricao', [InscricoesController::class, 'store'])->name('api.inscricao');