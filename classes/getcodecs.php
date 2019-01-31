<?php
namespace chipbug\php_video_reformatter;

class GetCodecs
{
    public function get_codecs(\DirectoryIterator $fileinfo)
    {
        $video = escapeshellarg($fileinfo->getPathName());
        $cmd = 'mediainfo --Output=XML ' . $video;
        $results = shell_exec($cmd);
        $results = simplexml_load_string($results);
        $ns = $results->getNamespaces();
        $results->registerXPathNamespace('ns', $ns['']);
        $audio_codec = $results->xpath("//ns:track[@type='Audio']/ns:Format");
        $video_codec = $results->xpath("//ns:track[@type='Video']/ns:Format");
        $codecs['filename'] = $fileinfo->getFilename();
        $codecs['container'] =  strtolower(pathinfo($fileinfo->getPathname(), PATHINFO_EXTENSION));
        $codecs['video'] =  strtolower($video_codec[0][0]->__toString());
        $codecs['audio'] = strtolower($audio_codec[0][0]->__toString());
        return $codecs;
    }
}
