<?php

use App\Http\Controllers\KasbonController;
use App\Http\Controllers\PegawaiController;
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

Route::get('/pegawai', [PegawaiController::class, 'index']);
Route::post('/pegawai', [PegawaiController::class, 'store']);

Route::get('/kasbon', [KasbonController::class, 'index']);
Route::post('/kasbon', [KasbonController::class, 'store']);
Route::patch('/kasbon/setujui/{id}', [KasbonController::class, 'update']);
Route::post('/kasbon/setujui-masal', [KasbonController::class, 'massUpdate']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
