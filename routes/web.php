<?php

use App\Domains\Auth\Web\Controllers\ApplicationController;
use App\Domains\Home\Web\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ApplicationController::class, 'index'])->name('application.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home.index');
});

require __DIR__.'/auth.php';
