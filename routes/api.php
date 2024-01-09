<?php

use App\Http\Controllers\Api\KaryawanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('karyawan',[KaryawanController::class, 'index']);
Route::get('karyawan/{id}',[KaryawanController::class, 'show']);
Route::post('karyawan',[KaryawanController::class, 'store']);
Route::put('karyawan/{id}',[KaryawanController::class, 'update']);
Route::delete('karyawan/{id}',[KaryawanController::class, 'destroy']);

//tugas msib ADS
Route::get('tigakaryawan',[KaryawanController::class, 'tigakaryawanpertama']);
Route::get('cutikaryawan',[KaryawanController::class, 'CutiKaryawan']);
Route::get('sisacuti',[KaryawanController::class, 'sisaCutiKaryawan']);

