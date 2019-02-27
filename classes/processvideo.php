<?php
declare(strict_types=1);
namespace chipbug\php_video_reformatter;

/**
 * processes a video file
 */
class ProcessVideo
{
    private $options;
    private $codecs;

    /**
     * sets up a ProcessVideo object and hands control to process_video()
     *
     * @param \DirectoryIterator $fileinfo
     * @return void
     */
    public function init(\DirectoryIterator $fileinfo):void
    {
        $this->options = Options::getOptions();
        $this->codecs = (new GetCodecs)->init($fileinfo);
        $this->process_video($fileinfo);
    }

    /**
     * processes a video file
     *
     * @param \DirectoryIterator $fileinfo
     * @return void
     */
    private function process_video(\DirectoryIterator $fileinfo):void
    {
        try {
            // if anything is not the same as the 'USB TV standards', process the video
            $same_file = false; // container = mp4
            $same_video = false; // video = AVC ie h.264
            $same_audio = false; // audio = AAC
            $same_mp41 = false; // container brand  = mp41

            $old_file_name = escapeshellarg($fileinfo->getPathname());
            echo PHP_EOL . 'old file: ' . $old_file_name . PHP_EOL;

            // check if container == mp4 and container brand == mp41
            if ($this->codecs['container'] == 'mp4' && $this->codecs['general']<> 'mp41') {
                echo 'container not mp41 ';
                $general_setting = "-brand mp41";
                $new_file_name = escapeshellarg($fileinfo->getPath() . '/'. $fileinfo->getBasename($this->codecs['container']) . 'new.mp4');
            } else {
                echo 'same mp41 ';
                $general_setting = "";
                $same_mp41 = true;
            }
    
            // check if container <> mp4
            if ($this->codecs['container']<> 'mp4') {
                echo 'file not mp4 ';
                $new_file_name = escapeshellarg($fileinfo->getPath() . '/'. $fileinfo->getBasename($this->codecs['container']) . 'mp4');
            } else {
                echo 'same file name ';
                $new_file_name = escapeshellarg($fileinfo->getPath() . '/'. $fileinfo->getBasename($this->codecs['container']) . 'new.mp4');
                $same_file = true;
            }

            // check if video <> AVC
            if ($this->codecs['video']<> 'avc') {
                echo 'video not avc ';
                $video_setting = "-c:v libx264";
            } else {
                echo 'same video ';
                $video_setting = "-c:v copy";
                $same_video = true;
            }

            // check if audio <> AAC
            if ($this->codecs['audio']<> 'aac') {
                echo 'audio not aac ';
                $audio_setting = "-c:a aac";
            } else {
                echo 'same audio ';
                $audio_setting = "-c:a copy";
                $same_audio = true;
            }

            // execute ffmpeg
            if (!($same_video && $same_audio && $same_file && $same_mp41)) {
                echo PHP_EOL . 'new file: ' . $new_file_name . PHP_EOL;
                if(!is_file($new_file_name)){
                    $cmd = \escapeshellcmd("ffmpeg -i $old_file_name $video_setting $audio_setting $general_setting $new_file_name");
                    echo $cmd . PHP_EOL;
                    //$results = shell_exec($cmd);
                }
            }

            // delete file if necessary
            if ((!$same_file || !$same_video || !$same_audio || !$same_mp41) && $this->options['delete_on_conversion']) {
                echo 'deleting: ' . escapeshellarg($fileinfo->getPathname());
                //unlink($fileinfo->getPathname());
            }
        } catch (\Throwable $th) {
            error_log($th->getFile() . ': line ' . $th->getLine() . ', ' . $th->getMessage());
        }
    }
}
