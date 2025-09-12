<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{

    protected $fillable = [
        'name',
        'type',
        'value',
        'min_order_amount',
        'max_discount_amount',
        'usage_limit',
        'per_user_limit',
        'used_count',
        'expire_date',
        'status'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'expire_date' => 'date',
        'status' => 'boolean'
    ];

    /**
     * Scope for active discounts.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true)
            ->whereDate('expire_date', '>=', now());
    }


}
