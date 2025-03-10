<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeRecord extends Model {
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'amount',
    ];

    public function account() {
        return $this->belongsTo(Account::class);
    }
}
