<?php
namespace chipbug\php_video_reformatter;

/**
 * class to retrieve files recusively
 */
class GetFiles
{
    private $file_types;
    private $file_location;

    /**
     * grab settings and pass to get_files()
     * I could have made this a little slicker but ran out of time...
     *
     * @param Array $settings
     * @return void
     */
    public function init(Array $settings)
    {
        $this->file_types = $settings['file_types'];
        $this->file_location = $settings['file_location_root'];
        $this->get_files($settings, $this->file_location);
    }
    
    /**
     * get files recusively, filter for correct file type and hand to processvideo object
     *
     * @param [type] $settings
     * @param String $file_location
     * @return void
     */
    private function get_files($settings, String $file_location)
    {
        try {
            foreach (new \DirectoryIterator($file_location) as $fileinfo) {
                // skip dot files
                if ($fileinfo->isDot()) {
                    continue;
                }
                // skip trash folder if present
                if(strpos($fileinfo->getPath(), '.Trash')){
                    continue;
                }
                // recursion
                if ($fileinfo->isDir()) {
                    $this->get_files($settings, $fileinfo->getPathname());
                }
                // select video containers to process: mkv/mp4/avi/webm
                $ext = strtolower($fileinfo->getExtension());
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
