# a php video reformatter

## problem - how to get usb files to work on any TV

I tried to play my usb video files on a TV in a hotel recently and had the usual frustration of finding which files would play. Some would play on the lounge TV, others on the bedroom TV. Some would play video and not sound, others would do the opposite. :tired_face:

Also, I've had it with trying to figure out foreign language remote controls.

Sooooo, to fix this I did the following:

## remote control solution
1. I researched the web for my phone model and '[IR Blaster](https://en.wikipedia.org/wiki/Infrared_blaster)' - mine has it. Whoop!
2. I downloaded a couple of remote control apps (I use [mi](https://play.google.com/store/apps/details?id=com.duokan.phone.remotecontroller) and [sure](https://play.google.com/store/apps/details?id=com.tekoia.sure.activities), they have a near-identical setup and layout) - I found some IR devices can be found in one database but not the other. YMMV. This means I now learn only one remote control, and it's in english.

## file format solution
I then converted all my favorite video watching to the most common TV format using this code.

I've done a (little) bit of research and the state of my knowledge is as follows:

1) the file name (mkv, mp4, webm etc) is just a container.

2) the video and audio format inside the container is the more important bit, and they can be coded to different standards. This is why sometimes the video plays but the audio doesn't etc.

So as I understand it the most widely playable formats for TV usb seem to be as follows:

* container: mp4 (mp41 brand)
* video: h.264/AVC
* audo: AAC

Feel free to criticize/comment on my (lack of) understanding.

Hence I wrote the following to recursively find all video files on my usb, then check the contents for both video and audio formats, then run ffmpeg to convert the codecs/containers where necessary.

## requirements

this is built on a linux box (Ubuntu mate 18.04) with the following installed:

* ffmpeg
    * ffmpeg -i old_file_name -c: $audio_setting $general_setting $new_file_name
* mediainfo
* php 7.x

(I know there are php wrappers for [ffmpeg](https://github.com/PHP-FFMpeg/PHP-FFMpeg) and [mediainfo](https://github.com/mhor/php-mediainfo) but I decided they were [overkill](https://www.youtube.com/watch?v=6XUeB3eO9qU) for what I needed.)

## installation

* copy the files into  a directory of your choice
* adjust settings in classes/settings.php, specifically **the location of your files**

## operation

* run with `php index.php`
* if debug is enabled, watch for problems in debug.log
* if the file container is already mp4 but changes have to be made inside, the new file will be called `yourfile.new.mp4`

## how it works

1. create a settings object
2. create a getfiles object and inject the settings object
3. iterate through the files 
4. create a processvideo object and inject each file along with a settings object
5. create a codecs object for each file to get details of container/video/audio
(codecs object uses `mediainfo`)
6. process each file using `ffmpeg`

## version history

* 2.0.0 refactored into classes
* 1.0.0 proof of concept

## extra tips

* A top tip for getting round the TV foreign language interaction is to turn the set on and **then** plug in the USB. If it's recognized you should get something logical to press on screen.

* I plug my USB into the end of a 0.5m bright blue USB extension cable (approx a buck fifty?) and then plug that into the USB at the back of the box. The cable then dangles down below and in front of the set. This means I'm more likely to remember the USB when speed-packing for the airport and I give the room a final sweep.

* Once you've got your phone set up as a remote, you can control the temperature to your liking for any IR-controlled a/c, such as in a certain brand of well-known coffee shops. The [sure](https://play.google.com/store/apps/details?id=com.tekoia.sure.activities) app even has an a/c scanner if you can't work out the brand of a/c. Just trying to be helpful...

* [youtube-dl](https://rg3.github.io/youtube-dl/) (there's a [gui version](https://mrs0m30n3.github.io/youtube-dl-gui/) available) is the weapon of choice for downloading clips from YouTube, but doesn't guarantee containers will be in mp41 format (as I found out on my last trip. Grrrr....)