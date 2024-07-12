<?php

use Illuminate\Support\Facades\Log;

if (! function_exists('debugLog')) {
    /**
     * Add a new debug log entry
     *
     * @param string $title
     * @param mixed $data
     * @return void
     */
    function debugLog(string $title, mixed $data): void
    {
        Log::debug($title);
        Log::debug(json_encode($data));
    }
}

if (! function_exists('setUIAvatarUrl')) {
    /**
     * Generate the UI Avatar API url
     *
     * @param string $name
     * @param bool $defaultColors
     * @return string
     */
    function setUIAvatarUrl(string $name, bool $defaultColors = false): string
    {
        $uiAvatarUrl = 'https://ui-avatars.com/api/';
        $name = str_replace(' ', '+', $name);

        $url = $uiAvatarUrl . '?name=' . $name;

        if ($defaultColors) {
            $url .= '&background=0096FF&color=fff';
        }

        return $url;
    }
}

if (! function_exists('prependSlash')) {
    /**
     * Remove and prepend slash
     *
     * @param string $path
     * @return string
     */
    function prependSlash(string $path): string
    {
        $path = ltrim($path, '/');

        return '/' . $path;
    }
}

if (! function_exists('appendSlash')) {
    /**
     * Remove and append slash
     *
     * @param string $path
     * @return string
     */
    function appendSlash(string $path): string
    {
        $path = rtrim($path, '/');

        return $path . '/';
    }
}

if (! function_exists('appUrlStorage')) {
    /**
     * Prepare the app url storage with path
     *
     * @param string $path
     * @return string
     */
    function appUrlStorage(string $path): string
    {
        $path = ltrim($path, '/');
        $appUrl = appendSlash(config('app.url'));

        return $appUrl . '/storage/' . $path;
    }
}
