<?php
namespace chipbug\php_video_reformatter;

class GetFiles
{
    private $file_types;
    private $file_location;

    public function init($settings)
    {
        $this->file_types = $settings['file_types'];
        $this->file_location = $settings['file_location_root'];
        $this->get_files();
    }

    private function get_files()
    {
        try {
            foreach (new \DirectoryIterator($this->file_location) as $fileinfo) {
                // skip dot files
                if ($fileinfo->isDot()) {
                    echo 'dot file...' . PHP_EOL;
                    continue;
                }
                // recursion
                if ($fileinfo->isDir()) {
                    echo 'recursing...' . PHP_EOL;
                    //$this->get_files($fileinfo->getPathname());
                }
                $ext = strtolower(pathinfo($fileinfo->getPathname(), PATHINFO_EXTENSION));
                echo $fileinfo->getPathname() . PHP_EOL;
                echo 'PATH: ' . $ext - PHP_EOL;
                // select video containers to process: mkv/mp4/avi/webm
                if (in_array($ext, $this->file_types)) {
                    echo 'processing video...' . PHP_EOL;
                    //process_video($fileinfo);
                    print_r( $fileinfo). PHP_EOL;
                }
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            echo $ex->getFile() . ': line ' . $ex->getLine() . PHP_EOL;
        }
    }
}