<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\KepalaDinas\DashboardController;
use App\Http\Controllers\KepalaDinas\MonitoringController;
use App\Http\Controllers\KepalaDinas\LaporanPengangkutanController;

Route::middleware(['auth', 'role:kepala'])
    ->prefix('kepala')
    ->name('kepala.')
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

                Route::get(
                    '/',
                    [LaporanPengangkutanController::class, 'index']
                )->name('index');

                Route::get(
                    '/print',
                    [LaporanPengangkutanController::class, 'print']
                )->name('print');

                Route::get(
                    '/pdf',
                    [LaporanPengangkutanController::class, 'pdf']
                )->name('pdf');

            });

    });