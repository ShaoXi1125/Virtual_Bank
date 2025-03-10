<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\TradeRecord;

class TradeRecordController extends Controller
{
   // 1. 发起转账
   public function transfer(Request $request) {
    $request->validate([
        'sender_id'   => 'required|exists:accounts,account_id',
        'receiver_id' => 'required|exists:accounts,account_id|different:sender_id',
        'amount'      => 'required|numeric|min:0.01',
    ]);

    $sender   = Account::find($request->sender_id);
    $receiver = Account::find($request->receiver_id);

    if ($sender->balance_amount < $request->amount) {
        return response()->json(['error' => 'Insufficient funds'], 400);
    }

    // 开始转账
    $sender->balance_amount -= $request->amount;
    $receiver->balance_amount += $request->amount;

    // 保存数据
    $sender->save();
    $receiver->save();

    // 记录交易
    $trade = TradeRecord::create([
        'sender_id'   => $request->sender_id,
        'receiver_id' => $request->receiver_id,
        'amount'      => $request->amount,
    ]);

        return response()->json(['message' => 'Transfer successful', 'trade' => $trade]);
    }

    // 2. 获取某个账户的交易记录
    public function history($account_id) {
        $records = TradeRecord::where('sender_id', $account_id)->orWhere('receiver_id', $account_id)->get();
        return response()->json($records);
    }
}
