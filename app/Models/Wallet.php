<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    public $fillable = [
        'user_id',
        'virtual_account',
        'balance',
        'encrypted_at'
    ];
}
