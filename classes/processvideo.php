<?php
namespace chipbug\php_video_reformatter;

class ProcessVideo
{
    private $delete_on_conversion;

    public function init(array $settings, \DirectoryIterator $fileinfo)
    {
        $this->delete_on_conversion = $settings['']
    }

    private function process_video(\DirectoryIterator $fileinfo)
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
        if ((!$same_file || !$same_video || !$same_audio) && $delete_on_conversion) {
            echo 'deleting: ' . escapeshellarg($fileinfo->getPathname());
            unlink($fileinfo->getPathname());
        }
    }
}
