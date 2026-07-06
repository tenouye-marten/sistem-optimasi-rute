<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('auth.login');
});



Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::put(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::put(
        '/profile/password',
        [ProfileController::class, 'password']
    )->name('profile.password');

});

require __DIR__.'/auth.php';

require __DIR__.'/admin.php';
require __DIR__.'/driver.php';
require __DIR__.'/kepala.php';