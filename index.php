<?php
namespace chipbug\php_video_reformatter;

function autoload_classes($class){
    include 'src/' . $class . '.php';
}
//require('settings.php');

if ($debug) {
    require('debug.php');
}

function get_files($files)
{
    echo 'get_files';
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
    global $delete_on_conversion;
    echo 'process_video';
    $same_file = false;
    $same_video = false;
    $same_audio = false;
    $codecs = get_codecs($fileinfo);
    $old_file_name = escapeshellarg($fileinfo->getPathname());
    echo PHP_EOL . 'PROCESSING ' . $old_file_name . PHP_EOL;
    if ($codecs['container']<> 'mp4') {
        echo 'file not mp4...';
        $new_file_name = escapeshellarg($fileinfo->getPath() . '/'. $fileinfo->getBasename($codecs['container']) . 'mp4');
    } else {
        $new_file_name = escapeshellarg($fileinfo->getPath(). 'new.mp4');
        $same_file = true;
    }
    if ($codecs['video']<> 'avc') {
        echo 'video not avc...';
        $video_setting = "-c:v libx264";
    } else {
        $video_setting = "-c:v copy";
        $same_video = true;
    }
    if ($codecs['audio']<> 'aac') {
        echo 'audio not aac...';
        $audio_setting = "-c:a aac";
    } else {
        $audio_setting = "-c:a copy";
        $same_audio = true;
    }
    echo PHP_EOL . 'NEW FILE NAME: ' . $new_file_name;
    if (!($same_video && $same_audio && $same_file)) {
        $cmd = "ffmpeg -i $old_file_name $video_setting $audio_setting $new_file_name";
        echo $cmd;
        $results = shell_exec($cmd);
        //print_r($results);
    }
    if ( (!$same_file || !$same_video || !$same_audio) && $delete_on_conversion) {
        echo 'deleting: ' . escapeshellarg($fileinfo->getPathname());
        unlink($fileinfo->getPathname());
    }
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