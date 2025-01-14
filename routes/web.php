<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\Aktivitas\HariLiburController;
use App\Http\Controllers\Aktivitas\JadwalController;
use App\Http\Controllers\BimbinganKonseling\LaporanDaerahController;
use App\Http\Controllers\BimbinganKonseling\LaporanDesaController;
use App\Http\Controllers\BimbinganKonseling\RekapAbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KurikulumTargetController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MasterData\DivisiController;
use App\Http\Controllers\MasterData\KarakterController;
use App\Http\Controllers\MasterData\KelasController;
use App\Http\Controllers\MasterData\MateriController;
use App\Http\Controllers\MasterData\SatuanController;
use App\Http\Controllers\MasterData\TahunController;
use App\Http\Controllers\MasterData\TanggalController;
use App\Http\Controllers\MasterUser\PermissionController;
use App\Http\Controllers\MasterUser\RoleController;
use App\Http\Controllers\MasterUser\UserController;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\PencapaianTargetController;
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

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(ProfilController::class)->prefix('profil')->group(function () {
        Route::get('index', 'index')->name('profil.index');
        Route::get('update/{id}/{view}', 'update')->name('profil.update');
        Route::put('store', 'store')->name('profil.store');
    });

    Route::prefix('master-data')->group(function () {
        Route::controller(TanggalController::class)->prefix('tanggal')->group(function () {
            Route::get('index', 'index')->name('master_data.tanggal.index');
            Route::post('create', 'create')->name('master_data.tanggal.create');
            Route::post('delete/{id}', 'destroy')->name('master_data.tanggal.destroy');
        });

        Route::controller(MateriController::class)->prefix('materi')->group(function () {
            Route::get('index', 'index')->name('master_data.materi.index');
            Route::post('create', 'create')->name('master_data.materi.create');
            Route::post('delete/{id}', 'destroy')->name('master_data.materi.destroy');
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

        Route::controller(DivisiController::class)->prefix('divisi')->group(function () {
            Route::get('index', 'index')->name('master_data.divisi.index');
            Route::post('create', 'create')->name('master_data.divisi.create');
            Route::post('delete/{id}', 'destroy')->name('master_data.divisi.destroy');
        });

        Route::controller(KelasController::class)->prefix('kelas')->group(function () {
            Route::get('index', 'index')->name('master_data.kelas.index');
            Route::post('create', 'create')->name('master_data.kelas.create');
            Route::post('delete/{id}', 'destroy')->name('master_data.kelas.destroy');
        });
    });

    Route::controller(MuridController::class)->prefix('murid')->group(function () {
        Route::get('index', 'index')->name('murid.index');
        Route::post('create', 'create')->name('murid.create');
        Route::post('delete/{id}', 'destroy')->name('murid.destroy');
        Route::get('export-excel', 'exportExcel')->name('murid.export_excel');
    });

    Route::controller(KurikulumTargetController::class)->prefix('kurikulum-target')->group(function () {
        Route::get('index', 'index')->name('kurikulum_target.index');
        Route::get('create', 'create')->name('kurikulum_target.create');
        Route::get('data-detail', 'getDataDetail')->name('kurikulum_target.data_detail');
        Route::put('store', 'store')->name('kurikulum_target.store');
        Route::delete('delete/{id}', 'destroy')->name('kurikulum_target.destroy');
        Route::get('export-template', 'exportTemplate')->name('kurikulum_target.export_template');
        Route::post('import-data', 'importData')->name('kurikulum_target.import_data');
    });

    Route::controller(PencapaianTargetController::class)->prefix('pencapaian-target')->group(function () {
        Route::get('index', 'index')->name('pencapaian_target.index');
        Route::post('store', 'store')->name('pencapaian_target.store');
    });

    Route::prefix('aktivitas')->group(function () {
        Route::controller(JadwalController::class)->prefix('jadwal')->group(function () {
            Route::get('index', 'index')->name('aktivitas.jadwal.index');
            Route::post('create', 'create')->name('aktivitas.jadwal.create');
            Route::post('delete/{id}', 'destroy')->name('aktivitas.jadwal.destroy');
        });

        Route::controller(HariLiburController::class)->prefix('hari-libur')->group(function () {
            Route::get('index', 'index')->name('aktivitas.hari_libur.index');
            Route::post('create', 'create')->name('aktivitas.hari_libur.create');
            Route::post('delete/{id}', 'destroy')->name('aktivitas.hari_libur.destroy');
        });
    });

    Route::controller(AbsensiController::class)->prefix('absensi')->group(function () {
        Route::get('index', 'index')->name('absensi.index');
        Route::post('store', 'store')->name('absensi.store');
    });

    Route::controller(KegiatanController::class)->prefix('kegiatan')->group(function () {
        Route::get('index', 'index')->name('kegiatan.index');
    });

    Route::controller(LaporanController::class)->prefix('laporan')->group(function () {
        Route::get('index', 'index')->name('laporan.index');
        Route::get('export-excel', 'exportExcel')->name('laporan.export_excel');
    });

    Route::prefix('bimbingan-konseling')->group(function () {
        Route::controller(RekapAbsensiController::class)->prefix('rekap-absensi')->group(function () {
            Route::get('index', 'index')->name('bimbingan_konseling.rekap_absensi.index');
        });
        Route::controller(LaporanDesaController::class)->prefix('laporan-desa')->group(function () {
            Route::get('index', 'index')->name('bimbingan_konseling.laporan_desa.index');
            Route::post('create', 'create')->name('bimbingan_konseling.laporan_desa.create');
            Route::post('delete/{id}', 'destroy')->name('bimbingan_konseling.laporan_desa.destroy');
        });
        Route::controller(LaporanDaerahController::class)->prefix('laporan-daerah')->group(function () {
            Route::get('index', 'index')->name('bimbingan_konseling.laporan_daerah.index');
            Route::post('create', 'create')->name('bimbingan_konseling.laporan_daerah.create');
            Route::post('delete/{id}', 'destroy')->name('bimbingan_konseling.laporan_daerah.destroy');
        });
    });

    Route::prefix('master-user')->group(function () {
        Route::controller(UserController::class)->prefix('user')->group(function () {
            Route::get('index', 'index')->name('master_user.user.index');
            Route::get('create', 'create')->name('master_user.user.create');
            Route::get('update/{id}', 'update')->name('master_user.user.update');
            Route::post('store', 'store')->name('master_user.user.store');
            Route::post('delete/{id}', 'destroy')->name('master_user.user.destroy');
        });

        Route::controller(RoleController::class)->prefix('role')->group(function () {
            Route::get('index', 'index')->name('master_user.role.index');
            Route::post('create', 'create')->name('master_user.role.create');
            Route::post('delete/{id}', 'destroy')->name('master_user.role.destroy');

            Route::get('set-akses/{id}', 'setAkses')->name('master_user.role.set_akses');
            Route::put('store', 'store')->name('master_user.role.store');
        });

        Route::controller(PermissionController::class)->prefix('permission')->group(function () {
            Route::get('index', 'index')->name('master_user.permission.index');
            Route::post('create', 'create')->name('master_user.permission.create');
            Route::post('delete/{id}', 'destroy')->name('master_user.permission.destroy');
        });
    });
});
