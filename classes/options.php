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
     * returns an array of options with $key == name of option, array of values
     *
     * @return array
     */
    public static function getOptions():array
    {
        try {
            if(!isset(self::$options)){
                self::$options = json_decode(\file_get_contents(__DIR__ . '/../data/options.json'), true);
                self::$options = 
            }
            print_r(self::$options);
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
