<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;

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
    
}
