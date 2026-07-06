<?php

use Illuminate\Support\Facades\Route;

// Dashboard
use App\Http\Controllers\Admin\DashboardController;

// Master Data
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\KendaraanController;
use App\Http\Controllers\Admin\PoolController;
use App\Http\Controllers\Admin\TpaController;
use App\Http\Controllers\Admin\TpsController;
use App\Http\Controllers\Admin\DriverTpsController;
use App\Http\Controllers\Admin\LaporanPengangkutanController;
use App\Http\Controllers\Admin\MonitoringController;
// Optimasi Rute
use App\Http\Controllers\Admin\OptimasiRuteController;

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

         /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [DashboardController::class, 'index']
        )->name('dashboard');
        /*
        |--------------------------------------------------------------------------
        | Master Data
        |--------------------------------------------------------------------------
        */

        Route::resource('driver', DriverController::class);

        Route::resource('kendaraan', KendaraanController::class);

        Route::resource('pool', PoolController::class);

        Route::resource('tpa', TpaController::class);

        Route::resource('tps', TpsController::class);

        /*
        |--------------------------------------------------------------------------
        | Wilayah Driver
        |--------------------------------------------------------------------------
        */

        Route::get(
            'driver-tps',
            [DriverTpsController::class, 'index']
        )->name('driver-tps.index');

        Route::get(
            'driver-tps/{driver}',
            [DriverTpsController::class, 'show']
        )->name('driver-tps.show');

        Route::get(
            'driver-tps/{driver}/edit',
            [DriverTpsController::class, 'edit']
        )->name('driver-tps.edit');

        Route::put(
            'driver-tps/{driver}',
            [DriverTpsController::class, 'update']
        )->name('driver-tps.update');

        /*
        |--------------------------------------------------------------------------
        | Akun Driver
        |--------------------------------------------------------------------------
        */

        Route::get(
            'driver/{driver}/create-account',
            [DriverController::class, 'createAccount']
        )->name('driver.create-account');

        Route::post(
            'driver/{driver}/store-account',
            [DriverController::class, 'storeAccount']
        )->name('driver.store-account');

        Route::post(
            'driver/{driver}/reset-password',
            [DriverController::class, 'resetPassword']
        )->name('driver.reset-password');

        /*
        |--------------------------------------------------------------------------
        | Optimasi Rute
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'optimasi',
            OptimasiRuteController::class
        );

        Route::get(
            'optimasi/driver/{driver}',
            [OptimasiRuteController::class, 'driverInfo']
        )->name('optimasi.driver-info');


        /*
|--------------------------------------------------------------------------
| Monitoring Pengangkutan
|--------------------------------------------------------------------------
*/

Route::prefix('monitoring')
    ->name('monitoring.')
    ->group(function () {

        Route::get(
            '/',
            [MonitoringController::class, 'index']
        )->name('index');

        Route::get(
            '/{pengangkutan}',
            [MonitoringController::class, 'show']
        )->name('show');

    });


    /*
|--------------------------------------------------------------------------
| Laporan Pengangkutan
|--------------------------------------------------------------------------
*/

Route::prefix('laporan')
    ->name('laporan.')
    ->group(function () {

        /*
        |--------------------------------------------------------------
        | Daftar Laporan
        |--------------------------------------------------------------
        */

        Route::get(
            '/',
            [LaporanPengangkutanController::class, 'index']
        )->name('index');

        /*
        |--------------------------------------------------------------
        | Print
        |--------------------------------------------------------------
        */

        Route::get(
            '/print',
            [LaporanPengangkutanController::class, 'print']
        )->name('print');

        /*
        |--------------------------------------------------------------
        | Export PDF
        |--------------------------------------------------------------
        */

        Route::get(
            '/pdf',
            [LaporanPengangkutanController::class, 'pdf']
        )->name('pdf');

    });

    });