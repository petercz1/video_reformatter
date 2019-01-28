<?php
namespace chipbug\php_video_reformatter;

require('settings.php');

if ($debug) {
    require('debug.php');
}

function get_files($files)
{
    global $file_types;
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
        if (in_array($ext, $file_types)) {
            //process_video($fileinfo);
        }
    }
}

function process_video($fileinfo)
{
    $codecs = get_codecs($fileinfo);
    print_r($codecs);
    if ($codecs['container']<> 'mp4') {
        echo 'converting for mp4' . PHP_EOL;
        $new_file_name = $fileinfo->getBasename($codecs['container']) . '.mp4';
    }
    if ($codecs['video']<> 'avc') {
        echo 'converting for avc' . PHP_EOL;
    }
    if ($codecs['audio']<> 'aac') {
        echo 'converting for aac' . PHP_EOL;
    }
    //$cmd = "ffmpeg -i $codecs['filename'] $video_setting $audio_setting out.$extension_setting";

    # code...
}

function get_codecs($fileinfo)
{
    $video = escapeshellarg($fileinfo->getPathName());
    //echo $video . PHP_EOL;
    $cmd = 'mediainfo --Output=XML ' . $video;
    $results = shell_exec($cmd);
    $results = simplexml_load_string($results);
    $ns = $results->getNamespaces();
    $results->registerXPathNamespace('ns', $ns['']);
    $audio_codec = $results->xpath("//ns:track[@type='Audio']/ns:Format");
    $video_codec = $results->xpath("//ns:track[@type='Video']/ns:Format");
    $codecs['filename'] = $fileinfo->getFilename();
    $codecs['container'] =  strtolower(pathinfo($fileinfo->getPathname(), PATHINFO_EXTENSION));
    $codecs['video'] =  strtolower($video_codec[0][0]->__toString());
    $codecs['audio'] = strtolower($audio_codec[0][0]->__toString());
    return $codecs;
}

get_files($files);
