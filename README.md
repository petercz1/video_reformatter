# a php video reformatter

I tried to play my usb video files on a TV in a hotel recently and had the usual frustration of finding which ones would play.

I've done a (little) bit of research and the state of my knowledge is as follows:

1) the file name (mkv, mp4 etc) is just a container.

2) the video and audio format inside is also important.

So as I understand it the most widely playable formats for TV usb seem to be as follows:

* container: mp4
* video: h.264/AVC
* audo: AAC

Hence I wrote the following to recursively find all video files on my usb, then check the contents for both video and audio formats, then run ffmpeg to convert where necessary.

## requirements

this is built on a linux box (Ubuntu mate 18.04) with the following installed:

* ffmpeg
* mediainfo
* php 7.x

## installation

* copy the files into  a directory of your choice.
* run with 'php index.php'
* 


