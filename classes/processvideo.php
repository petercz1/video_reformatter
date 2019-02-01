<?php
namespace chipbug\php_video_reformatter;

/**
 * processes a video file
 */
class ProcessVideo
{
    private $delete_on_conversion;
    private $codecs;

    /**
     * sets up a ProcessVideo object and hands control to process_video()
     *
     * @param array $settings
     * @param \DirectoryIterator $fileinfo
     * @return void
     */
    public function init(array $settings, \DirectoryIterator $fileinfo)
    {
        $this->delete_on_conversion = $settings['delete_on_conversion'];
        $this->codecs = (new GetCodecs)->init($fileinfo);
        $this->process_video($fileinfo);
    }

    /**
     * processes a video file
     *
     * @param \DirectoryIterator $fileinfo
     * @return void
     */
    private function process_video(\DirectoryIterator $fileinfo)
    {

        // if anything is not the same as the 'standards', process the video
        $same_file = false; // container = mp4
        $same_video = false; // video = AVC ie h.264
        $same_audio = false; // audio = AAC
        $same_mp41 = false; // container brand  = mp41

        $old_file_name = escapeshellarg($fileinfo->getPathname());
        echo PHP_EOL . 'PROCESSING ' . $old_file_name . PHP_EOL;

        // check if container mp4 and brand = mp41
        if ($this->codecs['container'] == 'mp4' && $this->codecs['general']<> 'mp41') {
            echo 'container not mp41' . PHP_EOL;
            $general_setting = "-brand mp41";
            $new_file_name = escapeshellarg($fileinfo->getPath() . '/'. $fileinfo->getBasename($this->codecs['container']) . 'new.mp4');
        } else {
            echo 'same mp41' . PHP_EOL;
            $general_setting = "";
            $same_mp41 = true;
        }
    
        if ($this->codecs['container']<> 'mp4') {
            echo 'file not mp4' . PHP_EOL;
            $new_file_name = escapeshellarg($fileinfo->getPath() . '/'. $fileinfo->getBasename($this->codecs['container']) . 'mp4');
        } else {
            echo 'same file name' . PHP_EOL;
            $new_file_name = escapeshellarg($fileinfo->getPath() . '/'. $fileinfo->getBasename($this->codecs['container']) . 'new.mp4');
            $same_file = true;
        }

        if ($this->codecs['video']<> 'avc') {
            echo 'video not avc' . PHP_EOL;
            $video_setting = "-c:v libx264";
        } else {
            echo 'same video' . PHP_EOL;
            $video_setting = "-c:v copy";
            $same_video = true;
        }

        if ($this->codecs['audio']<> 'aac') {
            echo 'audio not aac' . PHP_EOL;
            $audio_setting = "-c:a aac";
        } else {
            echo 'same audio' . PHP_EOL;
            $audio_setting = "-c:a copy";
            $same_audio = true;
        }
        echo PHP_EOL . 'NEW FILE NAME: ' . $new_file_name . PHP_EOL;
        if (!($same_video && $same_audio && $same_file && $same_mp41)) {
            $cmd = "ffmpeg -i $old_file_name $video_setting $audio_setting $general_setting $new_file_name";
            echo $cmd . PHP_EOL;
            $results = shell_exec($cmd);
        }
        if ((!$same_file || !$same_video || !$same_audio || !$same_mp41) && $this->delete_on_conversion) {
            echo 'deleting: ' . escapeshellarg($fileinfo->getPathname());
            unlink($fileinfo->getPathname());
        }
    }
}