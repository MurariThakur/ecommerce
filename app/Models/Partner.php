<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'link',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getLogoUrlAttribute()
    {
        if (filter_var($this->logo, FILTER_VALIDATE_URL)) {
            return $this->logo;
        }
        return asset('storage/' . $this->logo);
    }
}