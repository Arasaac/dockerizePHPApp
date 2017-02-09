<?php 
/*

=============================================================================================

Script Name: thumbnail.php

Version: 2.0

Author: Ian Anderson

Date: January 2007

Acknowledge: Teekai - http://www.teekai.info/v8/home.php (see the original script at

http://www.hotscripts.com/Detailed/18727.html on which this script is based).

This script is a self-contained Thumbnail Image Generator that can apply a watermark on the fly.

To modify for your own use, create your own watermark and update the following code throughout

this script: $logoImage = ImageCreateFrompng('logo_1800getryan_thumb.PNG');

It should be called as follows ...

<img src="/path/to/thumbnail.php?gd=N&src=/path/to/image.EXT&maxw=NNN" />

where N = the GD library version (supported values are 1 and 2)

EXT = the file extension of the image file

(supported values are gif (if gd = 2), jpg and png)

NNN = the desired maximum width of the thumbnail

If the actual image is narrower than the desired maximum width then the original image size

is used for the thumbnail copy.

This script checks for the following errors and generates an error JPEG image accordingly ...

GD version selected neither 1 nor 2;

Image create functions not supported;

Image file not found at the selected location;

GD version 2 functions not supported on the running version of PHP.

This script is available for use as freeware subject to the retention of the preceding

information and acknowledgements in any copy or modification that is made to this code.

v2.0 includes the addition of function fastimagecopyresampled

Acknowledge: Tim Eckel - Date: 12/17/04 - Project: FreeRingers.net - Freely distributable.

=============================================================================================

*/

function ErrorImage ($text) {

global $maxw;

$len = strlen ($text);

if ($maxw < 154) $errw = 154;

$errh = 30;

$chrlen = intval (5.9 * $len);

$offset = intval (($errw - $chrlen) / 2);

$im = imagecreate ($errw, $errh); /* Create a blank image */

$bgc = imagecolorallocate ($im, 153, 63, 63);

$tc = imagecolorallocate ($im, 255, 255, 255);

imagefilledrectangle ($im, 0, 0, $errw, $errh, $bgc);

imagestring ($im, 2, $offset, 7, $text, $tc);

header ("Content-type: image/jpeg");

imagejpeg ($im);

imagedestroy ($im);

exit;

}

function fastimagecopyresampled (&$dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h, $quality = 1) {

// Plug-and-Play fastimagecopyresampled function replaces much slower imagecopyresampled.

// Just include this function and change all "imagecopyresampled" references to "fastimagecopyresampled".

// Typically from 30 to 60 times faster when reducing high resolution images down to thumbnail size using the default quality setting.

// Author: Tim Eckel - Date: 12/17/04 - Project: FreeRingers.net - Freely distributable.

//

// Optional "quality" parameter (defaults is 3). Fractional values are allowed, for example 1.5.

// 1 = Up to 600 times faster. Poor results, just uses imagecopyresized but removes black edges.

// 2 = Up to 95 times faster. Images may appear too sharp, some people may prefer it.

// 3 = Up to 60 times faster. Will give high quality smooth results very close to imagecopyresampled.

// 4 = Up to 25 times faster. Almost identical to imagecopyresampled for most images.

// 5 = No speedup. Just uses imagecopyresampled, highest quality but no advantage over imagecopyresampled.

if (empty($src_image) || empty($dst_image)) { return false; }

if ($quality <= 1) {

$temp = imagecreatetruecolor ($dst_w + 1, $dst_h + 1);

imagecopyresized ($temp, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w + 1, $dst_h + 1, $src_w, $src_h);

imagecopyresized ($dst_image, $temp, 0, 0, 0, 0, $dst_w, $dst_h, $dst_w, $dst_h);

imagedestroy ($temp);

} elseif ($quality < 5 && (($dst_w * $quality) < $src_w || ($dst_h * $quality) < $src_h)) {

$tmp_w = $dst_w * $quality;

$tmp_h = $dst_h * $quality;

$temp = imagecreatetruecolor ($tmp_w + 1, $tmp_h + 1);

imagecopyresized ($temp, $src_image, $dst_x * $quality, $dst_y * $quality, $src_x, $src_y, $tmp_w + 1, $tmp_h + 1, $src_w, $src_h);

imagecopyresampled ($dst_image, $temp, 0, 0, 0, 0, $dst_w, $dst_h, $tmp_w, $tmp_h);

imagedestroy ($temp);

} else {

imagecopyresampled ($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

}

return true;

}

function thumbnail ($gdver, $src, $maxw=190) {

 

$gdarr = array (1,2);

for ($i=0; $i<count($gdarr); $i++) {

if ($gdver != $gdarr[$i]) $test.="|";

}

$exp = explode ("|", $test);

if (count ($exp) == 3) {

ErrorImage ("Incorrect GD version!");

}

if (!function_exists ("imagecreate") || !function_exists ("imagecreatetruecolor")) {

ErrorImage ("No image create functions!");

}

$size = @getimagesize ($src);

if (!$size) {

ErrorImage ("Image File Not Found!");

} else {

if ($size[0] > $maxw) {

$newx = intval ($maxw);

$newy = intval ($size[1] * ($maxw / $size[0]));

} else {

$newx = $size[0];

$newy = $size[1];

}

if ($gdver == 1) {

$destimg = imagecreate ($newx, $newy );

} else {

$destimg = @imagecreatetruecolor ($newx, $newy ) or die (ErrorImage ("Cannot use GD2 here!"));

}

 

if ($size[2] == 1) {

if (!function_exists ("imagecreatefromgif")) {

ErrorImage ("Cannot Handle GIF Format!");

} else {

$sourceimg = imagecreatefromgif ($src);

if ($gdver == 1)

imagecopyresized ($destimg, $sourceimg, 0,0,0,0, $newx, $newy, $size[0], $size[1]);

else

@fastimagecopyresampled ($destimg, $sourceimg, 0,0,0,0, $newx, $newy, $size[0], $size[1]) or die (ErrorImage ("Cannot use GD2 here!"));

ImageAlphaBlending($destimg, true);

$logoImage = ImageCreateFrompng('logo_1800getryan_thumb.PNG');

$logoW = ImageSX($logoImage);

$logoH = ImageSY($logoImage);

$white = imageColorAllocate ($logoImage, 255, 255, 255);

imagecolortransparent($logoImage,$white);

ImageCopyMerge($destimg, $logoImage, $newx-$logoW, $newy-$logoH, 0, 0, $logoW, $logoH, 90);

header ("content-type: image/gif");

imagegif ($destimg);

}

}

elseif ($size[2]==2) {

$sourceimg = imagecreatefromjpeg ($src);

if ($gdver == 1)

imagecopyresized ($destimg, $sourceimg, 0,0,0,0, $newx, $newy, $size[0], $size[1]);

else

@fastimagecopyresampled ($destimg, $sourceimg, 0,0,0,0, $newx, $newy, $size[0], $size[1]) or die (ErrorImage ("Cannot use GD2 here!"));

ImageAlphaBlending($destimg, true);

$logoImage = ImageCreateFrompng('logo_1800getryan_thumb.PNG');

$logoW = ImageSX($logoImage);

$logoH = ImageSY($logoImage);

$white = imageColorAllocate ($logoImage, 255, 255, 255);

imagecolortransparent($logoImage,$white);

ImageCopyMerge($destimg, $logoImage, $newx-$logoW, $newy-$logoH, 0, 0, $logoW, $logoH, 90);

header ("content-type: image/jpeg");

imagejpeg ($destimg);

}

elseif ($size[2] == 3) {

$sourceimg = imagecreatefrompng ($src);

if ($gdver == 1)

imagecopyresized ($destimg, $sourceimg, 0,0,0,0, $newx, $newy, $size[0], $size[1]);

else

@fastimagecopyresampled ($destimg, $sourceimg, 0,0,0,0, $newx, $newy, $size[0], $size[1]) or die (ErrorImage ("Cannot use GD2 here!"));

ImageAlphaBlending($destimg, true);

$logoImage = ImageCreateFrompng('logo_1800getryan_thumb.PNG');

$logoW = ImageSX($logoImage);

$logoH = ImageSY($logoImage);

$white = imageColorAllocate ($logoImage, 255, 255, 255);

imagecolortransparent($logoImage,$white);

ImageCopyMerge($destimg, $logoImage, $newx-$logoW, $newy-$logoH, 0, 0, $logoW, $logoH, 90);

header ("content-type: image/jpeg");

imagejpeg ($destimg);

header ("content-type: image/png");

imagepng ($destimg);

}

else {

ErrorImage ("Image Type Not Handled!");

}

}

imagedestroy ($destimg);

imagedestroy ($sourceimg);

imageDestroy ($logoImage);

}

require_once('../rc4crypt/class.rc4crypt.php');
require_once('../../configuration/key.inc');

//$d = rc4crypt::decrypt($private_key, $e);

$ruta='';

if (!isset($_GET['enc']) || $_GET['enc'] <> 0) {

	$path=explode('/',$_GET['ruta']);
	
	switch ($path[0]) {
	
		case md5('../'):
		$ruta='../';
		break;
		
		case md5('../../'):
		$ruta='../../';
		break;
		
		case md5('../../../'):
		$ruta='../../../';
		break;
	}
	
	switch ($path[1]) {
	
		case md5('repositorio/originales/'):
		$ruta.='repositorio/originales/';
		break;
		
		case md5('repositorio/simbolos/'):
		$ruta.='repositorio/simbolos/';
		break;
		
		case md5('temp/'):
		$ruta.='temp/';
		break;
	}
	
	$ruta.=$path[2];

} elseif (isset($_GET['enc']) && $_GET['enc']==0) {

	$ruta=$_GET['ruta'];
} 


thumbnail ($_GET["gd"], $ruta , $_GET["maxw"]);
?>