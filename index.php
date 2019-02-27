<?php
declare(strict_types=1);
namespace chipbug\php_video_reformatter;

echo 'START' . PHP_EOL;

spl_autoload_register(function($class){
    // explode namespace and classname into array
    $class = explode("\\", $class);
    // get last item (ie classname) and convert to lowercase
    $class = strtolower(end($class));
    // include the class
    require_once 'classes/' . $class . '.php';
});

$options = (Options)::getOptions();

if ($options['debug']) {
    (new Debug)->init();
}

(new GetFiles)->init();

echo PHP_EOL . 'FINISHED.';