<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'refund_number',
        'amount',
        'type',
        'status',
        'payment_method',
        'reason',
        'refund_data',
        'processed_at'
    ];

    protected $casts = [
        'refund_data' => 'array',
        'processed_at' => 'datetime'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}