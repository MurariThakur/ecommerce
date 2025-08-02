<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_data',
        'mime_type',
        'original_name',
        'order'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the properly formatted image source for display
     */
    public function getImageSrcAttribute()
    {
        // Check if the image_data already contains the data URL prefix
        if (strpos($this->image_data, 'data:') === 0) {
            return $this->image_data;
        }
        
        // If not, construct the proper data URL
        return 'data:' . $this->mime_type . ';base64,' . $this->image_data;
    }

    /**
     * Get clean base64 data without data URL prefix
     */
    public function getCleanBase64Attribute()
    {
        // Remove data URL prefix if it exists
        if (strpos($this->image_data, 'data:') === 0) {
            return preg_replace('/^data:image\/[^;]+;base64,/', '', $this->image_data);
        }
        
        return $this->image_data;
    }
}
