<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'blog_category_id',
        'image',
        'short_description',
        'description',
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

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true)->where('isdelete', false);
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('isdelete', false);
    }

    public function toggleStatus()
    {
        $this->status = !$this->status;
        $this->save();
    }

    public function getStatusTextAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function softDelete()
    {
        $this->isdelete = true;
        $this->save();
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('frontend/assets/images/blog/grid/3cols/post-1.jpg');
        }
        
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }
}