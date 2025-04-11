<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;

class AccountController extends Controller
{
     // 1. 创建账户
     public function store(Request $request) {
        $request->validate([
            'client_id'      => 'required|exists:clients,client_id',
            'account_number' => 'required|digits:12|unique:accounts',
            'balance_amount' => 'numeric|min:0',
        ]);

        $account = Account::create($request->all());

        return response()->json($account, 201);
    }

    // 2. 获取账户余额
    public function balance($id) {
        $account = Account::find($id);
        return $account ? response()->json(['balance' => $account->balance_amount]) : response()->json(['error' => 'Account not found'], 404);
    }

    // 3. 充值账户
    public function deposit(Request $request, $id) {
        $request->validate(['amount' => 'required|numeric|min:1.00']);

        $account = Account::find($id);
        if (!$account) return response()->json(['error' => 'Account not found'], 404);

        $account->balance_amount += $request->amount;
        $account->save();

        return response()->json(['message' => 'Deposit successful', 'new_balance' => $account->balance_amount]);
    }

    // 4. 扣款（支付）
    public function withdraw(Request $request, $id) {
        $request->validate(['amount' => 'required|numeric|min:1.00']);

        $account = Account::find($id);
        if (!$account) return response()->json(['error' => 'Account not found'], 404);

        if ($account->balance_amount < $request->amount) {
            return response()->json(['error' => 'Insufficient funds'], 400);
        }

        $account->balance_amount -= $request->amount;
        $account->save();

        return response()->json(['message' => 'Payment successful', 'new_balance' => $account->balance_amount]);
    }
}
