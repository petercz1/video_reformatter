<?php
namespace chipbug\php_video_reformatter;

/**
 * builds an array of settings to be used in various places
 */
class Settings
{
    public function __construct(){
        \error_log('constructing');
    }
    // location of your media
    //private $file_location_root = '/your/media/videos';
    private $file_location_root = '/home/pc/data/downloads/misc/temp';


    // video filetypes to scan for. Add your own if ffmpeg supports them
    // though to be honest you'd struggle to find a format that isn't supported...
    // https://en.wikipedia.org/wiki/FFmpeg#Supported_codecs_and_formats
    private $file_types = ['webm', 'mp4', 'avi', 'mkv'];

    // to delete original file after conversion set this to 'true'
    // WARNING - if you don't delete then you are responsible for making sure you have enough space available!
    private $delete_on_conversion = true;

    // use ./debug.log?
    private $debug = true;

    /**
     * builds an array of settings
     *
     * @return array
     */
    public function init()
    {
        $settings = array();
        $settings['file_location_root'] = $this->file_location_root;
        $settings['file_types'] = $this->file_types;
        $settings['delete_on_conversion'] = $this->delete_on_conversion;
        $settings['debug'] = $this->debug;
        error_log('built settings array');
        return $settings;
    }

    public function get_settings()
    {
        \error_log('getting settings');
        $settings = \file_get_contents(__DIR__ . '/../data/settings.json');
        return $settings;
    }

    public function set_settings(){
        
    }
}
