<?php
declare(strict_types=1);
namespace chipbug\php_video_reformatter;

/**
 * processes a video file
 */
class ProcessVideos // implements \SplSubject
{
    // private $options;
    // private $observers = [];
    // private $data;

    // /**
    //  * sets up a ProcessVideo object and hands control to process_video()
    //  *
    //  * @param \DirectoryIterator $fileinfo
    //  * @return void
    //  */
    // public function init(array $content):void
    // {
    //     notice($content);
    //     $processonevideo = new ProcessOneVideo;
    //     $this->options = $content['options'];
    //     foreach ($content['files'] as $file) {
    //         $this->data = $processonevideo->process_video($file, $this->options['delete_on_conversion']);
    //         //$this->notify();
    //     }
    // }

    // public function init(array $content):void
    // {
    //     notice($content);
    //     $processonevideo = new ProcessOneVideo;
    //     $this->options = $content['options'];
    //     foreach ($content['files'] as $file) {
    //         $this->data = $processonevideo->process_video($file, $this->options['delete_on_conversion']);
    //         //$this->notify();
    //     }
    // }
    
    // /**
    //  * processes a video file
    //  *
    //  * @param \DirectoryIterator $fileinfo
    //  * @return void
    //  */
    // private function process_video(array $file, bool $delete):void
    // {
    //     try {
    //         // if anything is not the same as the 'USB TV standards', process the video
    //         $ideal_format = true; // container = mp4, container brand  = mp41, video = AVC ie h.264, audio = AAC

    //         $new_file_name = '';
    //         $old_file_name = $file['basename'];

    //         // check if container == mp4
    //         if ($file['extension'] == 'mp4') {
    //             $new_file_name = $file['dirname'] . '/' . $file['filename'] . '.new.mp4';
    //         } else {
    //             $new_file_name = $file['dirname'] . '/' . $file['filename'] . '.mp4';
    //         }


    //         // check if container brand <> mp41
    //         if (!$file['mp41']) {
    //             $general_setting = "-brand mp41";
    //             $ideal_format = false;
    //         } else {
    //             $general_setting = "";
    //         }

    //         // check if video <> AVC
    //         if (isset($file['videoCodec']) &&  $file['videoCodec'] <> 'avc') {
    //             $video_setting = "-c:v libx264";
    //             $ideal_format = false;
    //         } else {
    //             $video_setting = "-c:v copy";
    //         }

    //         // check if audio <> AAC
    //         if (isset($file['audioCodec']) && $file['audioCodec'] <> 'aac') {
    //             $audio_setting = "-c:a aac";
    //             $ideal_format = false;
    //         } else {
    //             $audio_setting = "-c:a copy";
    //         }

    //         // execute ffmpeg
    //         if (!($ideal_format || file_exists($new_file_name))) {
    //             $old_file_name = \escapeshellarg($old_file_name);
    //             $new_file_name = \escapeshellarg($new_file_name);
    //             $cmd = \escapeshellcmd("ffmpeg -hide_banner -loglevel panic -i ${file['filepath']} $video_setting $audio_setting $general_setting $new_file_name");
    //             $results = shell_exec($cmd);
    //         }

    //         // delete file if necessary
    //         if (!$ideal_format && $delete) {
    //             unlink($file['filepath']);
    //         }

    //         // pubsub
    //         $this->notify();

    //     } catch (\Throwable $th) {
    //         error_log($th->getFile() . ': line ' . $th->getLine() . ', ' . $th->getMessage());
    //     }
    // }

    // public function attach(\SplObserver $observer)
    // {
    //     $observerKey = spl_object_hash($observer);
    //     $this->observers[$observerKey] = $observer;
    // }

    // public function detach(\SplObserver $observer)
    // {
    //     # code...
    // }

    // public function getData()
    // {
    //    return $this->data;
    // }

    // public function notify()
    // {
    //     foreach ($this->observers as $key => $value) {
    //         $this->observers[$key]->update($this);
    //     }
    // }
}
