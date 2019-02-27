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
            echo PHP_EOL . 'NEW FILE' . PHP_EOL;
            print_r($this->codecs);
            // if anything is not the same as the 'USB TV standards', process the video
            $same_file = false; // container = mp4
            $same_video = false; // video = AVC ie h.264
            $same_audio = false; // audio = AAC
            $same_mp41 = false; // container brand  = mp41

            $new_file_name = '';
            $old_file_name = $fileinfo->getPathname();

            // check if container == mp4 
            if ($this->codecs['container'] == 'mp4') {
                $new_file_name = $fileinfo->getPath() . '/' . pathinfo($fileinfo->getPathname(), PATHINFO_FILENAME) . '.new.mp4';
            } else {
                $new_file_name = $fileinfo->getPath() . '/' . pathinfo($fileinfo->getPathname(), PATHINFO_FILENAME) . '.mp4';
            }


            // check if container brand <> mp41
            if ($this->codecs['general']<> 'mp41') {
                $general_setting = "-brand mp41";
            } else {
                $general_setting = "";
                $same_mp41 = true;
            }

            // check if video <> AVC
            if ($this->codecs['video']<> 'avc') {
                $video_setting = "-c:v libx264";
            } else {
                $video_setting = "-c:v copy";
                $same_video = true;
            }

            // check if audio <> AAC
            if ($this->codecs['audio']<> 'aac') {
                $audio_setting = "-c:a aac";
            } else {
                $audio_setting = "-c:a copy";
                $same_audio = true;
            }

            // execute ffmpeg
            if (!($same_video && $same_audio && $same_file && $same_mp41)) {
                echo PHP_EOL . 'new file: ' . $new_file_name . PHP_EOL;
                if (!file_exists($new_file_name)) {
                    $old_file_name = \escapeshellarg($old_file_name);
                    $new_file_name = \escapeshellarg($new_file_name);
                    $cmd = \escapeshellcmd("ffmpeg -hide_banner -loglevel panic -i $old_file_name $video_setting $audio_setting $general_setting $new_file_name");
                    echo $cmd . PHP_EOL;
                    //$results = shell_exec($cmd);
                }
            }

            // delete file if necessary
            if ((!$same_file || !$same_video || !$same_audio || !$same_mp41) && $this->options['delete_on_conversion']) {
                //unlink($fileinfo->getPathname());
            }
        } catch (\Throwable $th) {
            error_log($th->getFile() . ': line ' . $th->getLine() . ', ' . $th->getMessage());
        }
    }
}