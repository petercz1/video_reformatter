<?php
namespace chipbug\php_video_reformatter;

/**
 * get codecs for file using mediainfo
 */
class GetCodecs
{
    /**
     * takes a file represented by a 
     *
     * @param \DirectoryIterator $fileinfo
     * @return void
     */
    public function init(\DirectoryIterator $fileinfo)
    {
        echo 'getting codecs';
        $video = escapeshellarg($fileinfo->getPathName());
        $cmd = 'mediainfo --Output=XML ' . $video;
        $results = shell_exec($cmd);
        $results = simplexml_load_string($results);
        $ns = $results->getNamespaces();
        $results->registerXPathNamespace('ns', $ns['']);
        $general_codec = $results->xpath("//ns:track[@type='General']/ns:CodecID");
        $audio_codec = $results->xpath("//ns:track[@type='Audio']/ns:Format");
        $video_codec = $results->xpath("//ns:track[@type='Video']/ns:Format");
        $codecs['filename'] = $fileinfo->getFilename();
        $codecs['container'] =  strtolower(pathinfo($fileinfo->getPathname(), PATHINFO_EXTENSION));
        if (isset($general_codec[0][0])) {
            $codecs['general'] =  strtolower($general_codec[0][0]->__toString());
        }
        if (isset($video_codec[0][0])) {
            $codecs['video'] =  strtolower($video_codec[0][0]->__toString());
        }
        if (isset($audio_codec[0][0])) {
            $codecs['audio'] = strtolower($audio_codec[0][0]->__toString());
        }
        return $codecs;
    }
}