<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Driver\DashboardController;
use App\Http\Controllers\Driver\RuteController;
use App\Http\Controllers\Driver\PengangkutanController;

Route::middleware(['auth', 'role:driver'])
    ->prefix('driver')
    ->name('driver.')
    ->group(function () {

      Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
)->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Rute Saya
        |--------------------------------------------------------------------------
        */

        Route::prefix('rute')
            ->name('rute.')
            ->group(function () {

                Route::get('/', [RuteController::class, 'index'])
                    ->name('index');

                Route::get('/{optimasi}', [RuteController::class, 'show'])
                    ->name('show');

            });

            

        /*
        |--------------------------------------------------------------------------
        | Pengangkutan
        |--------------------------------------------------------------------------
        */

        Route::prefix('pengangkutan')
            ->name('pengangkutan.')
            ->group(function () {

                // Dashboard Pengangkutan
                Route::get('/', [PengangkutanController::class, 'index'])
                    ->name('index');

                // Mulai Pengangkutan
                Route::post('/{optimasi}/mulai', [PengangkutanController::class, 'mulai'])
                    ->name('mulai');

                // TPS
                Route::get('/tps', [PengangkutanController::class, 'tpsAktif'])
                    ->name('tps');

                Route::get('/tps/{detail}', [PengangkutanController::class, 'showTPS'])
                    ->name('tps.show');

                Route::patch('/tps/{detail}', [PengangkutanController::class, 'updateTPS'])
                    ->name('tps.update');

                // TPA
                Route::get('/tpa', [PengangkutanController::class, 'menujuTPA'])
                    ->name('tpa');

                Route::patch('/tpa/manual', [PengangkutanController::class, 'menujuTPPAManual'])
                    ->name('tpa.manual');

                Route::patch('/tpa/konfirmasi', [PengangkutanController::class, 'konfirmasiTPA'])
                    ->name('tpa.konfirmasi');

                // Selesai Pengangkutan
                Route::patch('/{pengangkutan}/selesai', [PengangkutanController::class, 'selesai'])
                    ->name('selesai');


                    Route::get(
    '/pengangkutan/tps/{detail}',
    [PengangkutanController::class, 'showTps']
)->name('pengangkutan.show-tps');

            });

    });