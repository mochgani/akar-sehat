<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'locale', 'value'];

    /**
     * Get a setting value. Falls back to 'id' locale if not found in requested locale.
     */
    public static function get(string $key, mixed $default = null, string $locale = null): mixed
    {
        $locale = $locale ?? app()->getLocale() ?? 'id';

        $setting = static::where('key', $key)->where('locale', $locale)->first();

        // Fallback to default locale 'id' if requested locale not found
        if (!$setting && $locale !== 'id') {
            $setting = static::where('key', $key)->where('locale', 'id')->first();
        }

        if (!$setting) return $default;

        $decoded = json_decode($setting->value, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : $setting->value;
    }

    /**
     * Save a setting value.
     */
    public static function set(string $key, mixed $value, string $locale = 'id'): void
    {
        $encoded = is_array($value) || is_object($value)
            ? json_encode($value, JSON_UNESCAPED_UNICODE)
            : $value;

        static::updateOrCreate(
            ['key' => $key, 'locale' => $locale],
            ['value' => $encoded]
        );
    }

    /**
     * Get all settings for a group/prefix.
     * Returns locale-specific values, falling back to 'id' for missing keys.
     */
    public static function getGroup(string $prefix, string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale() ?? 'id';

        // Get base 'id' locale settings
        $base = static::where('key', 'like', $prefix . '.%')
            ->where('locale', 'id')
            ->pluck('value', 'key');

        // Override with requested locale settings if different from 'id'
        if ($locale !== 'id') {
            $localeRows = static::where('key', 'like', $prefix . '.%')
                ->where('locale', $locale)
                ->pluck('value', 'key');
            $base = $base->merge($localeRows);
        }

        return $base->mapWithKeys(function ($val, $key) use ($prefix) {
            $shortKey = substr($key, strlen($prefix) + 1);
            $decoded  = json_decode($val, true);
            return [$shortKey => json_last_error() === JSON_ERROR_NONE ? $decoded : $val];
        })->toArray();
    }

    /**
     * Get all settings for a group in all active locales. Used by admin edit pages.
     * Returns ['id' => [...], 'en' => [...], 'ar' => [...]]
     */
    public static function getGroupAllLocales(string $prefix): array
    {
        $rows = static::where('key', 'like', $prefix . '.%')->get();

        $result = [];
        foreach ($rows as $row) {
            $shortKey = substr($row->key, strlen($prefix) + 1);
            $decoded  = json_decode($row->value, true);
            $result[$row->locale][$shortKey] = json_last_error() === JSON_ERROR_NONE ? $decoded : $row->value;
        }
        return $result;
    }
}
