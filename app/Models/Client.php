<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model {
    use HasFactory;


    protected $primaryKey = 'client_id';

    protected $fillable = [
        'client_name',
        'client_email',
        'client_phone',
    ];

    public function accounts() {
        return $this->hasMany(Account::class, 'client_id');
    }

    public function cards()
    {
        return $this->hasMany(Card::class, 'client_id');
    }
}
