<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $fillable = [
        'wallet_id',
        'amount',
        'description',
        'type',
    ];
}
