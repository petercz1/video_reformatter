<?php
declare(strict_types=1);
namespace chipbug\php_video_reformatter;

/**
 * class to retrieve files recusively
 */
class GetFiles
{
    private $options;

    /**
     * initialize options and start file recursion
     * 
     * @return void
     */
    public function init():void
    {
        $this->options = Options::getOptions();
        $this->getFiles($this->options['file_location_root']);
    }
    
    /**
     * get files recusively, filter for correct file type and hand to processvideo object
     *
     * @param String $file_location
     * @return void
     */
    private function getFiles(string $file_location):void
    {
        try {
            foreach (new \DirectoryIterator($file_location) as $fileinfo) {
                // skip trash folder if present
                if (strpos($fileinfo->getPath(), '.Trash')) {
                    continue;
                }
                // recursion
                if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                    $this->getFiles($fileinfo->getPathname());
                }
                // select video containers to process: mkv/mp4/avi/webm
                $ext = strtolower($fileinfo->getExtension());
                if (in_array($ext, $this->options['file_types'])) {
                    (new ProcessVideo)->init($fileinfo);
                }
            }
        } catch (\Throwable $th) {
            error_log($th->getFile() . ': line ' . $th->getLine() . ', ' . $th->getMessage());
        }
    }
}
