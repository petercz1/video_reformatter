<?php
namespace chipbug\php_video_reformatter;

// SETTINGS
// location of your media
// $files = '/yourmedia/videos';

$files = '/media/pc/Transcend';
//$files = '/media/dellserver/data/videos/series/temp';

// filetypes to scan for
$file_types = ['webm', 'mp4', 'avi', 'mkv'];

// delete original file after conversion - set to 'true'
// WARNING - you are responsible for making sure you have enough space available!
$delete_on_conversion = true;

// use ./debug.log?
$debug = true;