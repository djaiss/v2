<?php

use App\Domains\Auth\Web\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('register', [RegisterController::class, 'index'])->name('register.index');
Route::post('register', [RegisterController::class, 'store'])->name('register.store');

Route::get('login', [LoginController::class, 'index'])->name('login.index');
