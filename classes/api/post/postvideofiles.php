<?php
declare(strict_types=1);
namespace chipbug\php_video_reformatter;

/**
 * get video file list returned by ajax in body
 * clean it, check it's an array and pass it on
 */
class postvideofiles
{
    private $file_location_root;
    private $delete_on_conversion;
    private $files;

    /**
     * initialise options and retrieve all file info
     *
     * @return void
     */
    public function init()
    {
        $content = $this->getContent();
        $processOnevideo = new processOnevideo();       
        $result = $processOnevideo->process_video($content);
    }
    
    /**
     * returns body content as array
     * @return array
     */
    private function getContent()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            //Receive the RAW post data.
            $content = trim(file_get_contents("php://input"));
            $content = json_decode($content, true);
            //If json_decode failed, the JSON is invalid.
            if (! is_array($content)) {
                echo \json_encode(["source" =>"server error", "text" =>"oops - you\'re not sending json?", "class" =>"warning"]);
            }
        }
        return $content;
    }
}