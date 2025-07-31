<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'status',
        'is_deleted'
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    /**
     * Generate slug automatically from name
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * Scope to get only active brands
     */
    public function scopeActive($query)
    {
        return $query->where('status', true)->where('is_deleted', false);
    }

    /**
     * Scope to get only non-deleted brands
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
     * Check if brand is active
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
     * Soft delete brand
     */
    public function softDelete()
    {
        $this->is_deleted = true;
        $this->save();
    }

    /**
     * Restore soft deleted brand
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
