<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subcategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category_id',
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
     * Relationship with Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope to get only active subcategories
     */
    public function scopeActive($query)
    {
        return $query->where('status', true)->where('isdelete', false);
    }

    /**
     * Scope to get only non-deleted subcategories
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
     * Check if subcategory is active
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
     * Soft delete subcategory
     */
    public function softDelete()
    {
        $this->isdelete = true;
        $this->save();
    }

    /**
     * Restore soft deleted subcategory
     */
    public function restore()
    {
        $this->isdelete = false;
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
