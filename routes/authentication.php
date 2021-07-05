<?php

use App\Http\Controllers\ForgotPassword;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'login'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('user.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/recuperar-senha', [ForgotPassword::class, 'recovery'])->name('user.password.recovery');
Route::get('/redefinir-senha/{token}', [ForgotPassword::class, 'resetView'])->name('user.password.reset.view');
Route::post('/redefinir-senha', [ForgotPassword::class, 'reset'])->name('user.password.reset');
