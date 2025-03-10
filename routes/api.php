<?php


use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\TradeRecordController;
use App\Http\Controllers\Api\CardController;
use Illuminate\Support\Facades\Route;

// Client 相关
Route::get('/clients', [ClientController::class, 'index']);  // 获取所有客户
Route::post('/clients', [ClientController::class, 'store']); // 创建客户
Route::get('/clients/{id}', [ClientController::class, 'show']); // 获取单个客户

//Card 相关
Route::get('/clients/{client_id}/cards', [CardController::class, 'getUserCards']);

// Account 相关
Route::post('/accounts', [AccountController::class, 'store']); // 创建账户
Route::get('/accounts/{id}/balance', [AccountController::class, 'balance']); // 查询余额
Route::post('/accounts/{id}/deposit', [AccountController::class, 'deposit']); // 充值
Route::post('/accounts/{id}/withdraw', [AccountController::class, 'withdraw']); // 扣款

// Trade 交易相关
Route::post('/transfer', [TradeRecordController::class, 'transfer']); // 转账
Route::get('/transactions/{account_id}', [TradeRecordController::class, 'history']); // 获取交易记录

// Card 相关
Route::post('/clients/{client_id}/cards', [CardController::class, 'store']);
Route::get('/clients/{client_id}/cards', [CardController::class, 'getUserCards']);
