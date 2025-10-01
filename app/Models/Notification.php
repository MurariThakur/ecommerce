<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'type',
        'title',
        'message',
        'url',
        'data',
        'icon',
        'color',
        'is_read'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
    ];

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    public static function createNotification($type, $title, $message, $url = null, $data = null, $icon = 'fas fa-info-circle', $color = 'info')
    {
        return self::create([
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'url' => $url,
            'data' => $data,
            'icon' => $icon,
            'color' => $color
        ]);
    }
}
