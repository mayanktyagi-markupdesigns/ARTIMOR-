<?php

use App\Models\Setting;
use App\Models\Banner;

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        $setting = Setting::where('key', $key)->first();

        return $setting?->value ?? $default;
    }
}

if (!function_exists('get_banners')) {
    function get_banners()
    {
        return Banner::where('status', 1)->get();  // active banners
    }
}