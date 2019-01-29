<?php
namespace chipbug\php_video_reformatter;

class Settings
{
    // SETTINGS
    // location of your media
    // $files = '/yourmedia/videos';

    //$files = '/media/pc/Transcend';
    public $files = '/media/dellserver/data/videos/series/temp';

    // filetypes to scan for
    public $file_types = ['webm', 'mp4', 'avi', 'mkv'];

    // delete original file after conversion - set to 'true'
    // WARNING - you are responsible for making sure you have enough space available!
    public $delete_on_conversion = true;

    // use ./debug.log?
    public $debug = true;
}