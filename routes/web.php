<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('karyawan', [KaryawanController::class, 'index']);
Route::delete('/karyawan/{id}', 'KaryawanController@destroy')->name('karyawans.destroy');
Route::get('/karyawan/{id}/edit', 'KaryawanController@edit')->name('karyawans.edit');
Route::get('/karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
Route::get('/sisacuti', [KaryawanController::class, 'showSisaCutiWeb']);
