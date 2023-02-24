<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccountInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'referral_code',
        'account_limit',
        'balance',
    ];
}
