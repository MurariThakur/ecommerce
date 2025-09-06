<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'type',
        'value',
        'min_order_amount',
        'max_discount_amount',
        'usage_limit',
        'per_user_limit',
        'used_count',
        'start_date',
        'expire_date',
        'status',
        'applies_to',
        'customer_restriction'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'start_date' => 'date',
        'expire_date' => 'date',
        'status' => 'boolean',
        'applies_to' => 'array', // if stored as JSON
        'customer_restriction' => 'array' // if stored as JSON
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
