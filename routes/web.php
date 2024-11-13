<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KurikulumTargetController;
use App\Http\Controllers\MasterData\KarakterController;
use App\Http\Controllers\MasterData\KelasController;
use App\Http\Controllers\MasterData\MateriController;
use App\Http\Controllers\MasterData\SatuanController;
use App\Http\Controllers\MasterData\TahunAjaranController;
use App\Http\Controllers\MasterUser\PermissionController;
use App\Http\Controllers\MasterUser\RoleController;
use App\Http\Controllers\MasterUser\UserController;
use App\Http\Controllers\ProfilController;
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
    return view('auth.login');
});

Auth::routes();

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::controller(ProfilController::class)->prefix('profil')->group(function () {
    Route::get('index', 'index')->name('profil.index');
});

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

    Route::controller(TahunAjaranController::class)->prefix('tahun-ajaran')->group(function () {
        Route::get('index', 'index')->name('master_data.tahun_ajaran.index');
        Route::post('create', 'create')->name('master_data.tahun_ajaran.create');
        Route::post('delete/{id}', 'destroy')->name('master_data.tahun_ajaran.destroy');
    });

    Route::controller(KarakterController::class)->prefix('karakter')->group(function () {
        Route::get('index', 'index')->name('master_data.karakter.index');
        Route::post('create', 'create')->name('master_data.karakter.create');
        Route::post('delete/{id}', 'destroy')->name('master_data.karakter.destroy');
    });

    Route::controller(SatuanController::class)->prefix('satuan')->group(function () {
        Route::get('index', 'index')->name('master_data.satuan.index');
        Route::post('create', 'create')->name('master_data.satuan.create');
        Route::post('delete/{id}', 'destroy')->name('master_data.satuan.destroy');
    });
});

Route::controller(KurikulumTargetController::class)->prefix('kurikulum-target')->group(function () {
    Route::get('index', 'index')->name('kurikulum_target.index');
    Route::get('create', 'create')->name('kurikulum_target.create');
    Route::get('data-detail', 'getDataDetail')->name('kurikulum_target.data_detail');
    Route::post('store', 'store')->name('kurikulum_target.store');
    Route::delete('delete/{id}', 'destroy')->name('kurikulum_target.destroy');
    Route::get('export-template', 'exportTemplate')->name('kurikulum_target.export_template');
    Route::post('import-data', 'importData')->name('kurikulum_target.import_data');
});

Route::prefix('master-user')->group(function () {
    Route::controller(UserController::class)->prefix('user')->group(function () {
        Route::get('index', 'index')->name('master_user.user.index');
        Route::post('create', 'create')->name('master_user.user.create');
        Route::post('delete/{id}', 'destroy')->name('master_user.user.destroy');
    });

    Route::controller(RoleController::class)->prefix('role')->group(function () {
        Route::get('index', 'index')->name('master_user.role.index');
        Route::post('create', 'create')->name('master_user.role.create');
        Route::delete('delete/{id}', 'destroy')->name('master_user.role.destroy');
    });

    Route::controller(PermissionController::class)->prefix('permission')->group(function () {
        Route::get('index', 'index')->name('master_user.permission.index');
        Route::post('create', 'create')->name('master_user.permission.create');
        Route::delete('delete/{id}', 'destroy')->name('master_user.permission.destroy');
    });
});
