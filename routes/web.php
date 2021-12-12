<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RecapitulationController;

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

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::resource('pengguna', UserController::class);
Route::post('pengguna-update-list', [UserController::class, 'updateList'])->name('pengguna.update-list');
Route::post('pengguna-delete-list', [UserController::class, 'deleteList'])->name('pengguna.delete-list');
Route::get('pengguna-rfid-temp', [UserController::class, 'rfidTemp'])->name('pengguna.rfid-temp');

Route::resource('rekapitulasi', RecapitulationController::class);
Route::post('rekapitulasi-update-list', [RecapitulationController::class, 'updateList'])->name('rekapitulasi.update-list');
Route::post('rekapitulasi-delete-list', [RecapitulationController::class, 'deleteList'])->name('rekapitulasi.delete-list');
