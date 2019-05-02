<?php
declare(strict_types=1);
namespace chipbug\php_video_reformatter;

/**
 * processes a video file
 */
class ProcessOneVideo
{

        /**
     * processes a video file
     *
     * @param \DirectoryIterator $fileinfo
     * @return void
     */
    public function process_video(array $file):void
    {
        try {
            // if anything is not the same as the 'USB TV standards', process the video
            $ideal_format = true; // container = mp4, container brand  = mp41, video = AVC ie h.264, audio = AAC
            $new_file_name = '';

            // check if container == mp4
            if ($file['extension'] == 'mp4') {
                $new_file_name = $file['dirname'] . '/' . $file['filename'] . '.new.mp4';
            } else {
                $new_file_name = $file['dirname'] . '/' . $file['filename'] . '.mp4';
            }

            // check if container brand <> mp41
            if (!$file['mp41']) {
                $general_setting = "-brand mp41";
                $ideal_format = false;
            } else {
                $general_setting = "";
            }

            // check if video <> AVC
            if (isset($file['videoFormat']) &&  $file['videoFormat'] <> 'avc') {
                $video_setting = "-c:v libx264";
                $ideal_format = false;
            } else {
                $video_setting = "-c:v copy";
            }

            // check if audio <> AAC
            if (isset($file['audioFormat']) && $file['audioFormat'] <> 'aac') {
                $audio_setting = "-c:a aac";
                $ideal_format = false;
            } else {
                $audio_setting = "-c:a copy";
            }

            // execute ffmpeg
            if (!$ideal_format && !file_exists($new_file_name)) {
                $old_file_name = \escapeshellarg($file['filepath']);
                $new_file_name = \escapeshellarg($new_file_name);
                $cmd = "ffmpeg -hide_banner -i $old_file_name $video_setting $audio_setting $general_setting $new_file_namet";
                $timer = time();
                $results = shell_exec($cmd);
                // delete file if necessary
                if (!$ideal_format && $file['delete_on_conversion']) {
                    unlink($file['filepath']);
                }
                $file['processed'] = true;
                $file['audioFormat'] = 'AAC';
                $file['videoFormat'] = 'AVC';
                $file['mp41'] = true;
                $file['extension'] = 'mp4';
                $timer = time() - $timer;
                $file['timer'] = gmdate("H:i:s", $timer);
            }
            echo json_encode($file);
        } catch (\Throwable $th) {
            echo json_encode(["error"=> "server error $th->getFile() line $th->getLine() $th->getMessage()"]);
        }
    }
}
