<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Account;
use App\Models\TradeRecord;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{

    public function store(Request $request, $client_id)
    {
        // 验证请求参数
        $request->validate([
            'account_id' => 'required|exists:accounts,account_id',
            'card_number' => 'required|string|size:16|unique:cards,card_number',
            'card_type' => 'required|in:debit,credit',
            'expiry_date' => 'required|date|after:today',
            'cvv' => 'required|string|size:3',
        ]);

        // 创建 Card
        $card = Card::create([
            'client_id' => $client_id,
            'account_id' => $request->account_id,
            'card_number' => $request->card_number,
            'card_type' => $request->card_type,
            'expiry_date' => $request->expiry_date,
            'cvv' => $request->cvv,
        ]);

        return response()->json(['message' => 'Card created successfully', 'card' => $card], 201);
    }


    // 获取某个用户的所有银行卡
    public function getUserCards($client_id)
    {
        $cards = Card::where('client_id', $client_id)->with('account')->get();
    
        if ($cards->isEmpty()) {
            return response()->json(['message' => 'No cards found'], 404);
        }
    
        return response()->json($cards->map(function ($card) {
            return [
                'card_id' => $card->card_id,
                'card_number' => $card->card_number,
                'card_type' => $card->card_type,
                'expiry_date' => $card->expiry_date,
                'balance' => optional($card->account)->balance_amount ?? 0.00, // 避免 account 为 null
            ];
        }));
    }

    public function cardTransfer(Request $request)
    {
        $request->validate([
            'card_number' => 'required|string|size:16',
            'cvv' => 'required|string|size:3',
            'amount' => 'required|numeric|min:1',
            'receiver_account_id' => 'required|exists:accounts,account_id',
        ]);

        // 使用 card_number 查找卡片
        $card = Card::with('account')->where('card_number', $request->card_number)->first();

        if (!$card) {
            return response()->json(['message' => 'Card not found'], 404);
        }

        // 验证卡片信息
        if ($card->cvv !== $request->cvv) {
            return response()->json(['message' => 'Invalid CVV'], 403);
        }

        if ($card->expiry_date < now()) {
            return response()->json(['message' => 'Card expired'], 403);
        }

        $receiverAccount = Account::findOrFail($request->receiver_account_id);

        if ($card->account->balance_amount < $request->amount) {
            return response()->json(['message' => 'Insufficient balance'], 400);
        }

        DB::beginTransaction();
        try {
            // 扣款
            $card->account->balance_amount -= $request->amount;
            $card->account->save();

            // 收款
            $receiverAccount->balance_amount += $request->amount;
            $receiverAccount->save();

            // 记录交易
            TradeRecord::create([
                'sender_id' => $card->client_id,
                'receiver_id' => $receiverAccount->client_id,
                'amount' => $request->amount,
            ]);

            DB::commit();
            return response()->json(['message' => 'Transfer successful'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Transfer failed', 'error' => $e->getMessage()], 500);
        }
    }

}
