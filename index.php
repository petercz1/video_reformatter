<?php
namespace chipbug\php_video_reformatter;

require ('settings.php');

// uncomment this if you want to see debugging in ./debug.log
require('debug.php');

function get_files($files)
{
    global $filetypes;
    foreach (new \DirectoryIterator($files) as $fileinfo) {
        // skip dot files
        if ($fileinfo->isDot()) {
            continue;
        }
        // recursion
        if ($fileinfo->isDir()) {
            get_files($fileinfo->getPathname());
        }
        $ext = strtolower(pathinfo($fileinfo->getPathname(), PATHINFO_EXTENSION));
        // select video containers to process: mkv/mp4/avi/webm
        switch ($ext) {
            case 'mkv':
            case 'mp4':
            case 'avi':
            case 'webm':
            process_video($fileinfo);
            break;
        }
    }
}

function process_video($fileinfo)
{
    $codecs = get_codecs($fileinfo);
    print_r($codecs);

    # code...
}


function get_codecs($fileinfo)
{
    $video = escapeshellarg($fileinfo->getPathName());
    //echo $video . PHP_EOL;
    $cmd = 'mediainfo --Output=XML ' . $video;
    $results = shell_exec($cmd);
    $results = simplexml_load_string($results);
    $ns = $results->getNamespaces()[0];
    
    $results->registerXPathNamespace('ns', 'https://mediaarea.net/mediainfo');
    $audio_codec = $results->xpath("//ns:track[@type='Audio']/ns:Format");
    $video_codec = $results->xpath("//ns:track[@type='Video']/ns:Format");
    $codecs['filename'] = $fileinfo->getFilename();  
    $codecs['container'] =  strtolower(pathinfo($fileinfo->getPathname(), PATHINFO_EXTENSION));  
    $codecs['video'] =  ($video_codec[0][0]->__toString());
    $codecs['audio'] = ($audio_codec[0][0]->__toString());
    return $codecs;
}

get_files($files);
