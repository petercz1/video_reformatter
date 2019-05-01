<?php
declare(strict_types=1);
namespace chipbug\php_video_reformatter;

/**
 * returns options as json to browser
 */
class GetVideoFilesInfo
{
    private $file_location_root;
    /**
     * initialise options and retrieve all file info
     *
     * @return void
     */
    public function init()
    {
        // get the params
        $this->file_location_root = $_GET['file_location_root'];
        // simple bit of cleaning - don't rely on this if you want to host this somewhere...
        $invalid_characters = array("$", "%", "#", "<", ">", "|", "(", ")", "{", "}");
        $this->file_location_root = str_replace($invalid_characters, "", $this->file_location_root);

        // check if file location exists and is writable
        if (!file_exists($this->file_location_root)) {
            echo '{"source": "server error", "text": "invalid folder - try another location?", "class":"warning"}';
        } elseif (!\is_writeable($this->file_location_root)) {
            echo '{"source": "server error", "text": "folder isn\'t writable - try another location?", "class":"warning"}';
        } else {
            $allfilesinfo = new AllFilesInfo();
            // get codecs for all files at this location
            $data = $allfilesinfo->getInfo($this->file_location_root);
            // ... and send it back
            echo json_encode($data);
        }
    }
}