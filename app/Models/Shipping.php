<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = [
        'name',
        'price',
        'status',
        'is_deleted'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'status' => 'boolean',
        'is_deleted' => 'boolean'
    ];

    public function scopeNotDeleted($query)
    {
        return $query->where('is_deleted', false);
    }
}
