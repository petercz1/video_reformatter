<?php
declare(strict_types=1);
namespace chipbug\php_video_reformatter;

/**
 * get codecs for file using mediainfo
 */
class GetCodecs
{
    /**
     * takes a file represented by a DirectoryIterator object and gets the codecs
     *
     * @param \DirectoryIterator $fileinfo
     * @return array
     */
    public function init(\DirectoryIterator $fileinfo): array
    {
        try {
            echo 'getting codecs';
            $video = escapeshellarg($fileinfo->getPathName());
            // uses mediainfo which can dump results as xml. Not my choice of datatype but there we are...
            $cmd = \escapeshellcmd('mediainfo --Output=XML ' . $video);
            $results = shell_exec($cmd);
            $results = simplexml_load_string($results);
            // get first namespace and register it
            $ns = $results->getNamespaces();
            $results->registerXPathNamespace('ns', $ns['']);
        
            // get codecs
            // CodecID == mp41, mp42 etc
            $general_codec = $results->xpath("//ns:track[@type='General']/ns:CodecID");
            // AAC, mp3 etc
            $audio_codec = $results->xpath("//ns:track[@type='Audio']/ns:Format");
            // h.264 etc
            $video_codec = $results->xpath("//ns:track[@type='Video']/ns:Format");

            // load up the array
            $codecs['filename'] = $fileinfo->getFilename();
            $codecs['container'] =  strtolower(pathinfo($fileinfo->getPathname(), PATHINFO_EXTENSION));
            if (isset($general_codec[0][0])) {
                $codecs['general'] =  strtolower($general_codec[0][0]->__toString());
            }else{
                $codecs['general'] = 'no general codec';
            }
            if (isset($video_codec[0][0])) {
                $codecs['video'] =  strtolower($video_codec[0][0]->__toString());
            }else{
                $codecs['video'] = 'no video codec';
            }
            if (isset($audio_codec[0][0])) {
                $codecs['audio'] = strtolower($audio_codec[0][0]->__toString());
            }else{
                $codecs['audio'] = 'no audio codec';
            }
            return $codecs;
        } catch (\Throwable $th) {
            error_log($th->getFile() . ': line ' . $th->getLine() . ', ' . $th->getMessage());
        }
    }
}
