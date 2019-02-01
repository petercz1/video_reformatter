<?php
namespace chipbug\php_video_reformatter;

/**
 * Undocumented class
 */
class GetFiles
{
    private $file_types;
    private $file_location;

    public function init(Array $settings)
    {
        $this->file_types = $settings['file_types'];
        $this->file_location = $settings['file_location_root'];
        $this->get_files($settings, $this->file_location);
    }

    private function get_files($settings, String $file_location)
    {
        try {
            foreach (new \DirectoryIterator($file_location) as $fileinfo) {
                // skip dot files
                if ($fileinfo->isDot()) {
                    continue;
                }
                echo 'TRASH:' . $fileinfo->getPath() . PHP_EOL;
                if(strpos($fileinfo->getPath(), '.Trash')){
                    continue;
                }
                // recursion
                if ($fileinfo->isDir()) {
                    $this->get_files($settings, $fileinfo->getPathname());
                }
                $ext = strtolower($fileinfo->getExtension());
                // select video containers to process: mkv/mp4/avi/webm
                if (in_array($ext, $this->file_types)) {
                    echo 'getfiles: processing video for ' . $fileinfo->getFilename() . PHP_EOL;
                    (new ProcessVideo)->init($settings, $fileinfo);
                }
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            echo $ex->getFile() . ': line ' . $ex->getLine() . PHP_EOL;
        }
    }
}
