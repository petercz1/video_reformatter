<?php
namespace chipbug\php_video_reformatter;

class AppInterface
{
    private $request;

    public function init()
    {
        if (isset($_REQUEST)) {
            $this->request = filter_var_array($_REQUEST, FILTER_SANITIZE_STRING);
        }
        switch ($this->request['command']) {
            case 'get_settings':
            $this->get_settings();
            break;
            case 'set_settings':
            $this->set_settings();
            break;
            case 'get_videos':
            $this->get_videos();
            // no break
            case 'process_videos':
            $this->process_videos();
            break;
        }
    }

    public function get_settings()
    {
        \error_log('getting settings');
        echo (new Settings())->get_settings();
    }
    
    public function set_settings()
    {
        // set settings
    }
    
    public function get_videos()
    {
        # code...
    }

    public function process_videos()
    {
        # code...
    }
}
