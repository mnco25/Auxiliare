<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'investment_id',
        'user_id',
        'amount',
        'transaction_type',
        'transaction_status',
        'payment_gateway',
    ];
}