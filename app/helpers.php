<?php

if (!function_exists('settings')) {
    function settings($key = null, $default = null)
    {
        if ($key === null) {
            return app(App\Classes\Settings::class);
        }

        return app(App\Classes\Settings::class)->get($key, $default);
    }
}
