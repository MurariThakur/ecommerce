<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'mime_type',
        'original_name',
        'order'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the URL for the image
     */
    public function getImageUrlAttribute()
    {
        // Check if it's an external URL
        if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            return $this->image_path;
        }
        return asset('storage/' . $this->image_path);
    }

    /**
     * Get the properly formatted image source for display (for backward compatibility)
     */
    public function getImageSrcAttribute()
    {
        return $this->image_url;
    }

    /**
     * Delete the image file when the model is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($productImage) {
            // Only delete local files, not external URLs
            if (!filter_var($productImage->image_path, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($productImage->image_path)) {
                Storage::disk('public')->delete($productImage->image_path);
            }
        });
    }
}
