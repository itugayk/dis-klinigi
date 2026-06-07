<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    public const CACHE_KEY = 'settings.all';

    /** Tüm ayarları [key => value] olarak (cache'li) getir. */
    public static function all($columns = ['*']): \Illuminate\Support\Collection
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return static::query()->get()->mapWithKeys(function (Setting $s) {
                return [$s->key => json_decode($s->value ?? 'null', true)];
            });
        });
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return self::all()->get($key, $default) ?? $default;
    }

    public static function put(string $key, mixed $value): void
    {
        static::query()->updateOrCreate(
            ['key' => $key],
            ['value' => json_encode($value)],
        );
        Cache::forget(self::CACHE_KEY);
    }

    public static function putMany(array $pairs): void
    {
        foreach ($pairs as $key => $value) {
            static::query()->updateOrCreate(['key' => $key], ['value' => json_encode($value)]);
        }
        Cache::forget(self::CACHE_KEY);
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget(self::CACHE_KEY));
        static::deleted(fn () => Cache::forget(self::CACHE_KEY));
    }
}
