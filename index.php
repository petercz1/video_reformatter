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
            process_video($fileinfo);
        }
    }
}

function process_video($fileinfo)
{
    $codecs = get_codecs($fileinfo);
    $old_file_name = escapeshellarg($fileinfo->getPathname());
    if ($codecs['container']<> 'mp4') {
        $new_file_name = escapeshellarg($fileinfo->getPath() . '/'. $fileinfo->getBasename($codecs['container']) . '.mp4');
    } else {
        $new_file_name = escapeshellarg($fileinfo->getPathname());
        $same_file = true;
    }
    if ($codecs['video']<> 'avc') {
        $video_setting = "-c:v libx264";
    } else {
        $video_setting = "-c:v copy";
        $same_video = true;
    }
    if ($codecs['audio']<> 'aac') {
        $audio_setting = "-c:a aac";
    } else {
        $audio_setting = "-c:a copy";
        $same_audio = true;
    }
    echo $cmd;
    // if 
    if (!($same_video || $same_audio || $same_file)) {
        $cmd = "ffmpeg -i $old_file_name $video_setting $audio_setting $new_file_name";
        $results = shell_exec($cmd);
    }

    if ((!($same_video || $same_audio || $same_file) && $delete_on_conversion)) {
        unlink(escapeshellarg($fileinfo->getPathname()));
    }
    print_r($results);
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
