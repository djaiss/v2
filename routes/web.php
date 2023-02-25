<?php

use App\Domains\Auth\Web\Controllers\ApplicationController;
use App\Domains\Home\Web\Controllers\HomeController;
use App\Domains\Settings\ManageLocale\Web\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ApplicationController::class, 'index'])->name('application.index');
Route::get('/locale/{locale}', [LocaleController::class, 'update'])->name('locale.update');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home.index');
});

require __DIR__.'/auth.php';
