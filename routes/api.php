<?php


use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\TradeRecordController;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\OnlineBankingAccountController;
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
Route::post('/cards/transfer', [CardController::class, 'cardTransfer']); // 💳 卡片转账


Route::prefix('online-banking')->group(function () {
    Route::post('/register/{client_id}', [OnlineBankingAccountController::class, 'register']); // 注册
    Route::post('/login', [OnlineBankingAccountController::class, 'login']); // 登录
    Route::put('/{account_id}/update-password', [OnlineBankingAccountController::class, 'updatePassword']); // 修改密码
    Route::get('/{account_id}', [OnlineBankingAccountController::class, 'getAccountInfo']); // 获取账户信息
});

