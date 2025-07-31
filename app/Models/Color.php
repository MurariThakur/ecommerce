<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'name',
        'color_code',
        'status',
        'is_deleted'
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    /**
     * Scope to get only active colors
     */
    public function scopeActive($query)
    {
        return $query->where('status', true)->where('is_deleted', false);
    }

    /**
     * Scope to get only non-deleted colors
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('is_deleted', false);
    }

    /**
     * Toggle status between active (1) and inactive (0)
     */
    public function toggleStatus()
    {
        $this->status = !$this->status;
        $this->save();
    }

    /**
     * Check if color is active
     */
    public function isActive()
    {
        return $this->status == 1;
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    /**
     * Soft delete color
     */
    public function softDelete()
    {
        $this->is_deleted = true;
        $this->save();
    }

    /**
     * Restore soft deleted color
     */
    public function restore()
    {
        $this->is_deleted = false;
        $this->save();
    }

    /**
     * Relationship with Products
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get active products only
     */
    public function activeProducts()
    {
        return $this->hasMany(Product::class)->active();
    }
}
