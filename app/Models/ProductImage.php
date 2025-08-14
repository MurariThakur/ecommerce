<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     * Full URL to the stored image
     */
    public function getImageSrcAttribute()
    {
        return asset('storage/product_images/' . $this->image_path);
    }
}
