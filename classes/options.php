<?php
declare(strict_types=1);
namespace chipbug\php_video_reformatter;

/**
 * builds an array of options to be used in various places
 */
class Options
{
    private static $options;
    /**
     * builds an array of options
     * singleton so we only access the settings json file once
     *
     * @return array
     */
    public function init()
    {
    }

    public static function getOptions():array
    {
        try {
            if(!isset(self::$options)){
                self::$options = json_decode(\file_get_contents(__DIR__ . '/../data/options.json'), true);
            }
            return self::$options;
        } catch (\Throwable $th) {
            error_log($th->getFile() . ': line ' . $th->getLine() . ', ' . $th->getMessage());
        }
    }

    public function setOptions()
    {
        // TODO set options
    }
}
