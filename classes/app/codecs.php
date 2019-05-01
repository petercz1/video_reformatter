<?php
declare(strict_types=1);
namespace chipbug\php_video_reformatter;

/**
 * get codecs for file using mediainfo
 */
class Codecs
{
    /**
     * takes a file represented by a DirectoryIterator object and gets the codecs
     *
     * @param \DirectoryIterator $fileinfo
     * @return array
     */
    public function getCodecs(\DirectoryIterator $fileinfo): array
    {
        try {
            $codecs = [];
            $filepath = escapeshellarg($fileinfo->getPathname());
            // ok turns out mediainfo XML does NOT report on equivalent codecs, so you don't get
            // 'isom/iso2/avc1/mp41' from which you could search/confirm mp41 (even using the -f switch)
            // hence this is  straight dump of the html report which I then do a stringsearch
            $cmd = 'mediainfo -f --Output=HTML ' . $filepath;
            $textResults = shell_exec($cmd);
            \strpos($textResults, 'mp41')!== false ? $codecs['mp41'] = true: $codecs['mp41'] = false;

            // Now use mediainfo for xml results. Not my choice of datatype but there we are...
            $cmd = 'mediainfo -f --Output=XML ' . $filepath;
            $results = shell_exec($cmd);

            // now load as php simplexml object
            $results = simplexml_load_string($results);
            // convert xml to array
            $results = json_decode(json_encode($results), true);
            // fix the lack of named keys for the three major info areas (General/Video/Audio)
            $tempCodecs = [];
            $this->rename_integer_index_to_key_string($results, $tempCodecs);

            // now extract the remaining data
            $codecs['filepath'] = $fileinfo->getPathname();
            $codecs['basename'] = $fileinfo->getFilename();
            $codecs['videoFormat'] = $tempCodecs['Video']['Format'];
            $codecs['audioFormat'] = $tempCodecs['Audio']['Format'];
            $codecs['process_video'] = true;

            $file_parts= \pathinfo($fileinfo->getPathname());
            $codecs['dirname'] = $file_parts['dirname'];
            $codecs['extension'] = $file_parts['extension'];
            $codecs['filename'] = $file_parts['filename'];

            return $codecs;
            
        } catch (\Throwable $th) {
            error_log($th->getFile() . ': line ' . $th->getLine() . ', ' . $th->getMessage());
        }
    }

    /**
     * rename_integer_index_to_key_string
     * grabs the @attribute value and replaces the integer key with it
     * ie solves this problem:
     * <track type="Video">
     * <track type="General">
     * <track type="Audio">
     * $tempCodecs is passed by value to avoid nested function nightmare hence no return value
     * @param [type] $arr
     * @param array $converted
     * @return void
     */
    private function rename_integer_index_to_key_string($results, array &$tempCodecs)
    {
        if (\is_array($results)) {
            foreach ($results as $key => $value) {
                if (!is_array($results)) {
                    continue;
                }
                if (is_int($key)) {
                    $newkey = $results[$key]['@attributes']['type'];
                    $tempCodecs[$newkey] = $value;
                }
                // recursion
                $this->rename_integer_index_to_key_string($value, $tempCodecs);
            }
        }
    }
}
