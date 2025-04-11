<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OnlineBankingAccount extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'client_id',
        'username',
        'password',
        'status',
        'last_login',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

}
