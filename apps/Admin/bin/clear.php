<?php
/**
 * Application clear script
 *
 * Clear:
 *  apc code cache
 *  apc user cache
 *  smarty compile script
 *  tmp files
 */

// APC Cache
if (function_exists('apc_clear_cache')) {
    if (version_compare(phpversion('apc'), '4.0.0') < 0) {
        apc_clear_cache('user');
    }
    apc_clear_cache();
}

$unlink = function ($path) use (&$unlink) {
    foreach (glob(rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '*') as $file) {
        is_dir($file) ? $unlink($file) : unlink($file);
        @rmdir($file);
    }
};

$unlink(dirname(__DIR__) . '/var/tmp');

unset($unlink);
