<?php
namespace chipbug\php_video_reformatter;

class AppInterface
{
    private $request;

    public function init()
    {
        error_log('options init');
        if (isset($_REQUEST)) {
            $this->request = filter_var_array($_REQUEST, FILTER_SANITIZE_STRING);
        }
        switch ($this->request['command']) {
            case 'getOptions':
            $this->getOptions();
            break;
            case 'setOptions':
            $this->setOptions();
            break;
            case 'getVideos':
            $this->getVideos();
            // no break
            case 'processVideos':
            $this->processVideos();
            break;
        }
    }

    public function getOptions()
    {
        \error_log('getting options');
        echo json_encode(Options::getOptions());
    }
    
    public function setOptions()
    {
        // TODO set options
    }
    
    public function getVideos()
    {
        // TODO get video list...
    }

    public function processVideos()
    {
        // TODO process videos...
    }
}
