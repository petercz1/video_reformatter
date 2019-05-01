<?php
declare(strict_types=1);
namespace chipbug\php_video_reformatter;

/**
 * simple no-framework skinny router
 */
class Router
{
    // TODO handle 404 and post data
    
    private $uri = [
        '/'=>'gethome',
        '/api/getoptions'=>'getOptions',
        '/api/setoptions'=>'setOptions',
        '/api/getvideofilesinfo'=>'getVideoFilesInfo',
        '/api/processvideofilesinfo'=>'postVideoFiles'
    ];

    /**
     * simple router
     * assumes that the route and class are named the same
     * and that an autoloader is used
     *
     * @return void
     */
    public function init():void
    {
        // split uri from any params - they're in $_GET, $_POST or $_REQUEST
        $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
        $route = $uri_parts[0] ?? '/';
    
        foreach ($this->uri as $routeKey => $routeValue) {
            if (preg_match("#^$routeKey$#", $route)) {
                $class = __NAMESPACE__ . '\\' . $routeValue;
                (new $class)->init();
            }
        }
    }
}