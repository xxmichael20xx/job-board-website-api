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
