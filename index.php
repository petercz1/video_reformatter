<?php
declare(strict_types=1);
namespace chipbug\php_video_reformatter;

require_once('classes/autoloader.php');
(new Autoloader)->init();

(new Debug)->init();

(new Router)->init();

// simple debug helper
function notice($txt)
{
    $bt = \debug_backtrace();
    $area = array_shift($bt);

    if (\is_array($txt)) {
        error_log(basename($area['file']) . ': ' . $area['line']);
        error_log(print_r($txt, true));
    } elseif (\is_object($txt)) {
        error_log(basename($area['file']) . ': ' . $area['line']);
        error_log(print_r((array)$txt, true));
    } else {
        error_log(basename($area['file']) . ': ' . $area['line'] . ', ' . $txt);
    }
}