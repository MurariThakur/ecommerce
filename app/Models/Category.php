<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'status',
        'isdelete'
    ];

    protected $casts = [
        'status' => 'boolean',
        'isdelete' => 'boolean',
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
     * Scope to get only active categories
     */
    public function scopeActive($query)
    {
        return $query->where('status', true)->where('isdelete', false);
    }

    /**
     * Scope to get only non-deleted categories
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('isdelete', false);
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
     * Check if category is active
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
     * Soft delete category
     */
    public function softDelete()
    {
        $this->isdelete = true;
        $this->save();
    }

    /**
     * Restore soft deleted category
     */
    public function restore()
    {
        $this->isdelete = false;
        $this->save();
    }

    /**
     * Relationship with Subcategories
     */
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    /**
     * Get active subcategories only
     */
    public function activeSubcategories()
    {
        return $this->hasMany(Subcategory::class)->active();
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
