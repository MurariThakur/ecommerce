<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'status'];

    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->where('status', true)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value, $status = true)
    {
        return self::updateOrCreate(['key' => $key], ['value' => $value, 'status' => $status]);
    }
}
