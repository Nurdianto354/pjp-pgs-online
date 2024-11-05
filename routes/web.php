<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterData\KelasController;
use App\Http\Controllers\MasterData\MateriController;
use App\Http\Controllers\TargetController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Auth::routes(['register' => false]);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('master-data')->group(function () {
    Route::controller(KelasController::class)->prefix('kelas')->group(function () {
        Route::get('index', 'index')->name('master_data.kelas.index');
        Route::post('create', 'create')->name('master_data.kelas.create');
        Route::post('delete/{id}', 'destroy')->name('master_data.kelas.destroy');
    });

    Route::controller(MateriController::class)->prefix('materi')->group(function () {
        Route::get('index', 'index')->name('master_data.materi.index');
        Route::post('create', 'create')->name('master_data.materi.create');
        Route::post('delete/{id}', 'destroy')->name('master_data.materi.destroy');
    });
});

Route::controller(TargetController::class)->prefix('target')->group(function () {
    Route::get('index', 'index')->name('target.index');
});
