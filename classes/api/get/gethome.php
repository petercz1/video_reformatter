<?php
declare(strict_types=1);
namespace chipbug\php_video_reformatter;

/**
 * returns home page
 */
class getHome
{
	/**
	 * returns homepage
	 *
	 * @return void
	 */
    public function init():void
    {
        include($_SERVER['DOCUMENT_ROOT']."/public/index.html");
    }
}
