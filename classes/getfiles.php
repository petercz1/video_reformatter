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
        print_r($this->file_types);
        echo $this->file_location . PHP_EOL;
        $this->get_files();
    }

    private function get_files($this->file_location)
    {
        try {
            foreach (new \DirectoryIterator() as $fileinfo) {
                // skip dot files
                if ($fileinfo->isDot()) {
                    echo 'dot file:' . $fileinfo->getPathname() . PHP_EOL;
                    continue;
                }
                // recursion
                if ($fileinfo->isDir()) {
                    echo 'recursing:' . $fileinfo->getPathname() . PHP_EOL;
                    //return $this->get_files($fileinfo->getPathname());
                }
                echo 'PATH: ' . $fileinfo->getFilename() . PHP_EOL;
                $ext = strtolower($fileinfo->getExtension());
                echo 'EXTENSION: ' . $ext . PHP_EOL;
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