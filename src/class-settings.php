<?php
namespace chipbug\php_video_reformatter;

class Settings
{
    // SETTINGS
    // location of your media
    // $files = '/yourmedia/videos';

    //$files = '/media/pc/Transcend';
    private $files = '/media/dellserver/data/videos/series/temp';

    // video filetypes to scan for. Add your own if ffmpeg supports them
    // though to be honest you'd struggle to find a format that isn't supported...
    // https://en.wikipedia.org/wiki/FFmpeg#Supported_codecs_and_formats
    private $file_types = ['webm', 'mp4', 'avi', 'mkv'];

    // delete original file after conversion - set to 'true'
    // WARNING - you are responsible for making sure you have enough space available!
    private $delete_on_conversion = true;

    // use ./debug.log?
    private $debug = true;

    public function init(){

    }
}