<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;

class CardController extends Controller
{
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
                'balance' => $card->balance, // 直接从 Account 读取余额
            ];
        }));
    }
}
