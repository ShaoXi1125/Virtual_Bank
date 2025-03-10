<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model {
    use HasFactory;


    protected $table = 'accounts';   // 👈 指定表名
    protected $primaryKey = 'account_id'; // 👈 指定主键
    public $incrementing = true;     // 👈 确保主键是自动递增的（如果适用）
    protected $keyType = 'int';  

    protected $fillable = [
        'account_number',
        'client_id',
        'balance_amount',
        'account_type',
    ];

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class, 'account_id');
    }
}
