<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    //
    use HasFactory;

    protected $table = 'cards';
    protected $primaryKey = 'card_id';
    protected $fillable = ['client_id', 'account_id', 'card_number', 'card_type', 'expiry_date', 'cvv'];

    protected $hidden = ['cvv'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    // 获取银行卡余额（从 Account 读取）
    public function getBalanceAttribute()
    {
        return $this->account->amount ?? 0.00;
    }
}
