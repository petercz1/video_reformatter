<?php
namespace chipbug\php_video_reformatter;

spl_autoload_register(function($class){
    // explode namespace and classname into array
    $class = explode("\\", $class);
    // get last item (ie classname) and convert to lowercase
    $class = strtolower(end($class));
    // include the class
    require_once __DIR__ . '/../../classes/' . $class . '.php';
});

(new AppInterface())->init();
