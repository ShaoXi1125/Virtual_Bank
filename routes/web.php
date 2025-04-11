<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnlineBankingController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/online-banking/login', [OnlineBankingController::class, 'showLoginForm'])->name('online_banking.login');
Route::post('/online-banking/login', [OnlineBankingController::class, 'login']);
Route::get('/online-banking/register', [OnlineBankingController::class, 'showRegisterForm'])->name('online_banking.register');
Route::post('/online-banking/register', [OnlineBankingController::class, 'register']);



Route::get('/online-banking/dashboard', [OnlineBankingController::class, 'dashboard'])
    ->middleware('auth.online_banking')
    ->name('online_banking.dashboard');


    Route::get('/online-banking/logout', [OnlineBankingController::class, 'logout'])->name('online_banking.logout');
