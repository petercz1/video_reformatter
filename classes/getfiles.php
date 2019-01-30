<?php
namespace chipbug\php_video_reformatter;

class GetFiles
{
    private $file_types;
    private $file_location;
    public function init($settings)
    {
        try {
            echo 'GetFiles->init()' . PHP_EOL;
             $this->file_types = $settings['file_types'];
         $this->file_location = $settings['file_location_root'];
            foreach (new \DirectoryIterator($file_location) as $fileinfo) {
                echo $fileinfo->getFilename();
                // skip dot files
                if ($fileinfo->isDot()) {
                    continue;
                }
                // recursion
                if ($fileinfo->isDir()) {
                    $this->get_files($fileinfo->getPathname());
                }
                $ext = strtolower(pathinfo($fileinfo->getPathname(), PATHINFO_EXTENSION));
                // select video containers to process: mkv/mp4/avi/webm
                if (in_array($ext, $file_types)) {
                    //process_video($fileinfo);
                    echo $fileinfo->getFilename() . PHP_EOL;
                }
            }
        } catch (Exception $ex) {
			echo $ex->getMessage();
			echo $ex->getFile() . ': line ' . $ex->getLine() . PHP_EOL;
        }
    }
}
