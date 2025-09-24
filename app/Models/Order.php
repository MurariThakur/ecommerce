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
        'expires_at',
        'idempotency_token'
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

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'shipping_method', 'id');
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

    // Scopes
    public function scopeNotDeleted($query)
    {
        return $query->where('isdelete', false);
    }

    public function scopePaid($query)
    {
        return $query->where('is_payment', true);
    }

    public function scopeUnpaid($query)
    {
        return $query->where('is_payment', false);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Helper methods
    public function softDelete()
    {
        $this->update(['isdelete' => true]);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'confirmed' => '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Confirmed</span>',
            'processing' => '<span class="badge badge-info"><i class="fas fa-cog"></i> Processing</span>',
            'shipped' => '<span class="badge badge-primary"><i class="fas fa-shipping-fast"></i> Shipped</span>',
            'delivered' => '<span class="badge badge-success"><i class="fas fa-check"></i> Delivered</span>',
            'cancelled' => '<span class="badge badge-danger"><i class="fas fa-ban"></i> Cancelled</span>',
            'return_requested' => '<span class="badge badge-warning"><i class="fas fa-undo"></i> Return Requested</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge badge-secondary">Unknown</span>';
    }

    public function getPaymentStatusBadgeAttribute()
    {
        return $this->is_payment
            ? '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Paid</span>'
            : '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Unpaid</span>';
    }

    public function getCustomerNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}