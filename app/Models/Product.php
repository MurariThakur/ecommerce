<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'subcategory_id',
        'brand_id',
        'old_price',
        'price',
        'short_description',
        'description',
        'additional_information',
        'shipping_return',
        'status',
        'isdelete'
    ];

    protected $casts = [
        'status' => 'boolean',
        'isdelete' => 'boolean',
        'old_price' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    /**
     * Generate slug automatically from title
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
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
     * Relationship with Subcategory
     */
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    /**
     * Relationship with Brand
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Many-to-many relationship with Colors through ProductColor
     */
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_colors');
    }

    /**
     * Direct relationship with ProductColor
     */
    public function productColors()
    {
        return $this->hasMany(ProductColor::class);
    }

    /**
     * Direct relationship with ProductSize
     */
    public function productSizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    /**
     * Get product sizes as array of size names
     */
    public function getSizeNamesAttribute()
    {
        return $this->productSizes->pluck('size_name')->toArray();
    }

    /**
     * Scope to get only active products
     */
    public function scopeActive($query)
    {
        return $query->where('status', true)->where('isdelete', false);
    }

    /**
     * Scope to get only non-deleted products
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
     * Check if product is active
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
     * Soft delete product
     */
    public function softDelete()
    {
        $this->isdelete = true;
        $this->save();
    }

    /**
     * Restore soft deleted product
     */
    public function restore()
    {
        $this->isdelete = false;
        $this->save();
    }

    /**
     * Get discount percentage
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->old_price && $this->old_price > $this->price) {
            return round((($this->old_price - $this->price) / $this->old_price) * 100);
        }
        return 0;
    }

    /**
     * Check if product has discount
     */
    public function hasDiscount()
    {
        return $this->old_price && $this->old_price > $this->price;
    }
}
