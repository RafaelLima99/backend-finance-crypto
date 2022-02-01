<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinsUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'symbol',
        'investment',
        'price_purchase',
    ];
}
