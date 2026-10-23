<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'label_ar',
        'group',
    ];

    public static function get(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, $value, ?string $labelAr = null, string $group = 'general')
    {
        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'label_ar' => $labelAr,
                'group' => $group,
            ]
        );
    }

    public static function mediaUrl(string $key, ?string $defaultPath = null): string
    {
        $val = self::get($key);
        if (empty($val)) {
            return $defaultPath ? asset($defaultPath) : '';
        }
        if (str_starts_with($val, 'http://') || str_starts_with($val, 'https://')) {
            return $val;
        }
        if (str_starts_with($val, 'storage/') || str_starts_with($val, 'images/') || str_starts_with($val, 'videos/') || str_starts_with($val, 'home/')) {
            return asset($val);
        }
        if (file_exists(public_path('storage/' . $val))) {
            return asset('storage/' . $val);
        }
        return asset($val);
    }
}
