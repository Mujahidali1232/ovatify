<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group_name', 'label', 'help_text', 'sort_order'];

    protected static function booted(): void
    {
        static::saved(fn () => static::flush());
        static::deleted(fn () => static::flush());
    }

    /**
     * Read a setting value (cached forever, busted on save).
     */
    public static function get(string $key, $default = null)
    {
        $map = static::allMap();
        return $map[$key] ?? $default;
    }

    /**
     * Convenience for image-type settings — returns the public URL
     * (or the $default if empty).
     */
    public static function image(string $key, ?string $default = null): ?string
    {
        $val = static::get($key);
        if (empty($val)) {
            return $default;
        }
        if (str_starts_with($val, 'http://') || str_starts_with($val, 'https://')) {
            return $val;
        }
        // Allow referencing public assets directly (e.g. "theme/images/slide01.jpg").
        if (str_starts_with($val, 'theme/') || str_starts_with($val, 'images/')) {
            return url('/'.$val);
        }
        // Anything we stored via the admin uploader lives under storage/app/public
        return url(\Illuminate\Support\Facades\Storage::url($val));
    }

    /**
     * Set one key. Bypasses fillable so we can write the raw value.
     */
    public static function set(string $key, $value): void
    {
        $row = static::firstOrNew(['key' => $key]);
        $row->value = $value;
        $row->save(); // triggers cache flush
    }

    public static function allMap(): array
    {
        return Cache::rememberForever('site_settings_map', function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    public static function flush(): void
    {
        Cache::forget('site_settings_map');
    }
}
