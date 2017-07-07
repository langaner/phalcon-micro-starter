<?php

use Phalcon\Debug\Dump;

if (!function_exists('dd')) {
    /**
     * Dump implementation
     *
     * @return mixed
     */
    function dd()
    {
        array_map(function ($x) {
            $string = (new Dump(null, true))->variable($x);
            echo (PHP_SAPI == 'cli' ? strip_tags($string) . PHP_EOL : $string);
        }, func_get_args());

        die;
    }
}

if (!function_exists('base_path')) {
    /**
     * Base path
     *
     * @param string $path
     * @return mixed
     */
    function base_path($path = null)
    {
        return BASE . '/' . $path;
    }
}

if (!function_exists('app_path')) {
    /**
     * Base app path
     *
     * @param string $path
     * @return mixed
     */
    function app_path($path = null)
    {
        return BASE_APP . '/' . $path;
    }
}

if (!function_exists('config_path')) {
    /**
     * Base config path
     *
     * @param string $path
     * @return mixed
     */
    function config_path($path = null)
    {
        return base_path('config/' . $path);
    }
}

if (!function_exists('storage_path')) {
    /**
     * Base cache path
     *
     * @param string $path
     * @return mixed
     */
    function storage_path($path = null)
    {
        return base_path('storage/' . $path);
    }
}

if (!function_exists('cache_path')) {
    /**
     * Base cache path
     *
     * @param string $path
     * @return mixed
     */
    function cache_path($path = null)
    {
        return storage_path('cache/' . $path);
    }
}

if (!function_exists('log_path')) {
    /**
     * Base cache path
     *
     * @param string $path
     * @return mixed
     */
    function log_path($path = null)
    {
        return storage_path('logs/' . $path);
    }
}

if (!function_exists('public_path')) {
    /**
     * Base cache path
     *
     * @param string $path
     * @return mixed
     */
    function public_path($path = null)
    {
        return base_path('public/' . $path);
    }
}