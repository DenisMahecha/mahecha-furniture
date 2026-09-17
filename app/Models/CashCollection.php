<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashCollection extends Model
{
    protected $fillable = [
        'customer_name',
        'amount',
        'received_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'received_at' => 'date',
        ];
    }
}
