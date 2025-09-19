<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'company',
        'country',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'notes',
        'discount_id',
        'discount_name',
        'discount_amount',
        'shipping_method',
        'shipping_cost',
        'total',
        'payment_method',
        'is_payment',
        'payment_data',
        'isdelete',
        'status',
        'expires_at'
    ];

    protected $casts = [
        'payment_data' => 'array',
        'is_payment' => 'boolean',
        'isdelete' => 'boolean',
        'discount_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
        'expires_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}