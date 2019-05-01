<?php
declare(strict_types=1);
namespace chipbug\php_video_reformatter;

/**
 * class to retrieve mediainfo on all files recusively
 */
class AllFilesInfo
{
	private $codecs;
    private $allFileCodecs = [];
    private $filetypes = ["webm", "mp4", "avi", "mkv"];
    
	 /**
     * get files recusively, filter for correct file type and hand to processvideo object
     *
     * @param String $file_location
     * @return void
     */
    public function getInfo(string $filepath):array
    {
        try {
            foreach (new \DirectoryIterator($filepath) as $fileinfo) {
                // skip trash folder if present
                if (strpos($fileinfo->getPath(), '.Trash')) {
                    continue;
                }
                // skip dot folder if present
                if ($fileinfo->isDot()) {
                    continue;
                }
                // recursion
                if ($fileinfo->isDir()) {
                    $this->getInfo($fileinfo->getPathname());
                }
                // select video containers to process: mkv/mp4/avi/webm
                $ext = strtolower($fileinfo->getExtension());
                if (in_array($ext, $this->filetypes)) {
                    // get codecs for each file
                    $this->codecs = (new Codecs)->getCodecs($fileinfo);
                    // add codecs to array
					$this->allFileCodecs[] = $this->codecs;
                }
            }
            // send array of codecs back to getvideofilesinfo.php
			return $this->allFileCodecs;
        } catch (\Throwable $th) {
            error_log($th->getFile() . ': line ' . $th->getLine() . ', ' . $th->getMessage());
        }
    }
}