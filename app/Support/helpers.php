<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    /**
     * Ayar değeri oku. Tablo henüz yoksa (örn. migrate öncesi) default döner.
     */
    function setting(string $key, mixed $default = null): mixed
    {
        try {
            return Setting::get($key, $default);
        } catch (\Throwable $e) {
            return $default;
        }
    }
}

if (! function_exists('site')) {
    /**
     * Klinik bilgisi: önce settings tablosu, yoksa config/clinic.php varsayılanı.
     */
    function site(string $key, mixed $default = null): mixed
    {
        $configDefault = config("clinic.$key", $default);
        $value = setting($key, $configDefault);

        return $value === null ? $configDefault : $value;
    }
}
