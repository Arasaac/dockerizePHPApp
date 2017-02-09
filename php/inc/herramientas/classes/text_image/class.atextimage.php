<?php
//
// class.atextimage.php
// version 1.1.0, 10 June, 2005
//
// License
//
// PHP class to put text of a True Type font onto a photo image, a graphic
// image or to create a new blank image with just the text.
//
// Copyright (C) 2005 George A. Clarke, webmaster@gaclarke.com, http://gaclarke.com/
//
// This program is free software; you can redistribute it and/or modify it under
// the terms of the GNU General Public License as published by the Free Software
// Foundation; either version 2 of the License, or (at your option) any later
// version.
//
// This program is distributed in the hope that it will be useful, but WITHOUT
// ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
// FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License along with
// this program; if not, write to the Free Software Foundation, Inc., 59 Temple
// Place - Suite 330, Boston, MA 02111-1307, USA.
//
// Description
//
// This class allows for easy insertion of text onto an image. The image
// can be either an existing image file or a newly created blank image.
// If a new blank image is chosen, the class creates it, either the size you
// specify or will size it to exactly fit the text. You can have one line of
// text or multiple lines. Each cluster of lines of text can be positioned
// by top, center, or bottom, and left, center, or right. Each cluster of
// lines of text can be left, center, or right justified. There can also be
// multiple clusters of text on an image. This class uses True Type fonts
// which defaults to Arial.ttf and the size can also be set. The color of
// text can be specified, and the background color can also be specified
// if using a blank image.
// 
// This class would be good for adding comments onto photos in a photo
// gallery or to make dynamic navigation buttons on an html page.

// June,10, 2005: Added function SetOffset($offx,$offy)
//  Gave it the ability to offset from the chosen position up/down,
//  or left/right, by the specified number of pixels. This version is
//  backward compatible to the original one.

class ATextImage
{
  var $text = array();
  var $size;
  var $font;
  var $image;
  var $bgr;
  var $bgb;
  var $bgg;
  var $txtr;
  var $txtb;
  var $txtg;
  var $horz;
  var $vert;
  var $just;
  var $bdr;
  var $bdg;
  var $bdb;
  var $border;

 function ATextImage()
 {
//  Set default values for the class variables
  $this->size=12;             //font size
  $this->font="arial.ttf";    //path to True Type font file (.ttf)
  $this->bgr=255;             //background red color value (decimal 0-255)
  $this->bgb=255;             //background blue color value (decimal 0-255)
  $this->bgg=255;             //background green color value (decimal 0-255)
  $this->txtr=0;              //text red color value (decimal 0-255)
  $this->txtb=0;              //text blue color value (decimal 0-255)
  $this->txtg=0;              //text green color value (decimal 0-255)
  $this->horz="center";       //horiaontal position (left,center,right)
  $this->vert="center";       //vertical position (top,center,bottom)
  $this->just="center";       //text lines justification (left,center,right)
  $this->border=false;        //put border around image (true,false)
 }
//***************** User Functions ***********************
// $font >> Sets the path to the True Type font file.
// $size >> Sets the size of the font.
 function SetFont($font,$size)
 {
  $this->font = $font;      //path to the .ttf font file
  $this->size = $size;      //size of font
 }

// $bgr, $bgg, $bgb >> Sets the background color
// (red, green, blue) (0 - 255 decimal)
 function SetBackground($bgr,$bgg,$bgb)
 {
  $this->bgr=$bgr;          //red background value
  $this->bgb=$bgb;          //blue background value
  $this->bgg=$bgg;          //green background value
 }

// $bgr, $bgg, $bgb >> Sets the text color
// (red, green, blue) (0 - 255 decimal)
 function SetTextColor($txtr,$txtg,$txtb)
 {
  $this->txtr=$txtr;          //red text value
  $this->txtb=$txtb;          //blue text value
  $this->txtg=$txtg;          //green text value
 }

// Enables the border to be put around the image.
// $bgr, $bgg, $bgb >> Sets the border color
// (red, green, blue) (0 - 255 decimal)
 function SetBorder($bdr=0,$bdg=0,$bdb=0)
 {
  $this->border=true;
  $this->bdr=$bdr;          //red border value
  $this->bdb=$bdb;          //blue border value
  $this->bdg=$bdg;          //green border value
 }

// Sets the horizontal, vertical positions and the
//  justification of multiple lines of text.
// $horz >> should be left, center, or right
// $vert >> should be top, center, or bottom
// $just >> should be left, center, or right
 function SetPos($horz,$vert,$just)
 {
  $this->horz=$horz;         //horz=left,center,right
  $this->vert=$vert;         //vert=top,center,bottom
  $this->just=$just;         //just=horizontal justification
                             //     left,center,right
 }

 // Adds an x and y offset to the position settings.
 // x=positive >> offsets to the right
 // y=positive >> offsets down
 function SetOffset($offx,$offy)
 {
  $this->offx=$offx;
  $this->offy=$offy;
 }
 

// Adds one line of text to be inserted onto the image.
// $txt >> one line of text
// $clear >> should be true for the first line of a new group of text lines.
//           otherwise false.
 function AddLine($txt,$clear=FALSE)
 {
  if($clear)unset($this->text);
  $this->text[]=$txt;
  return $this->text;
 }

// Is called to load an existing image
// Can be .jpg, .png, or .gif
// $ipath >> path to image file (eg: c:\path\to\image\file\image.gif)
 function CreateImage($ipath)
 {
  $ext=strtolower(substr(strrchr($ipath, "."), 1));
  if($ext=="jpg")$this->image=imagecreatefromjpeg($ipath);
  if($ext=="png")$this->image=imagecreatefrompng($ipath);
  if($ext=="gif")$this->image=imagecreatefromgif($ipath);
 }

// Makes the new image with the text embedded
// If an existing image was not used, it creates a new blank one to use.
// $iw >> width of a new blank image
// $ih >> height of a new blank image
// If a new blank image is used and $iw and $ih are not specified or are zeros
//  the size of the new image will exactly fit the text.
 function MakeImage($iw=0,$ih=0)
 {
  $n=count($this->text);
  $tex=implode("\n",$this->text);
  $bbox=imagettfbbox ($this->size, 0, $this->font, $tex);
  $tww=$bbox[2]-$bbox[0]+2;
  $thh=$bbox[1]-$bbox[7]+1;
  $th=-$bbox[7]-1;
  $sp=($n>1)?$th+(($thh-($n*$th))/($n)):0;
  if(!$this->image)$this->image=imagecreate(($iw==0)?$tww:$iw,($ih==0)?$thh:$ih);
  $bgnd = imagecolorallocate($this->image,$this->bgr,$this->bgg,$this->bgb);
  $tclr = imagecolorallocate($this->image,$this->txtr,$this->txtg,$this->txtb);
  $bclr = imagecolorallocate($this->image,$this->bdr,$this->bdg,$this->bdb);
  $width=imagesx($this->image);
  $height=imagesy($this->image);
  $ynew=$this->Vert($height,$thh,$th)+($n-1)+$this->offy+1;
  foreach($this->text as $tx)
  {
  $bbox=imagettfbbox ($this->size, 0, $this->font, $tx);
  $tw=$bbox[2]-$bbox[0];
  $xnew=$this->Horiz($width,$tww,$tw)+$this->offx;
  imagettftext($this->image, $this->size, 0, $xnew, $ynew, $tclr, $this->font, $tx);
  $ynew=$ynew+$sp;
  }
 if($this->border)imagerectangle($this->image, 0, 0, $width-1, $height-1, $bclr );
}

// Displays and/or saves the new image with text as a gif image.
// $sim >> path for the saving of the new gif image with text.
// if $sim is not set, it will merely display the gif image with text.
// if $sim is set and $dim is set to 1, the image will be saved and displayed.
 function ShowGif($sim="",$dim="1")
 {
  //output picture
  header("Content-type: image/gif");
 if(!($sim=="")){
  $fh=fopen($sim,'w');
  fclose($fh);
  imagegif($this->image,$sim);
  }else{
  imagegif($this->image);
  }
  if($dim == "1")imagegif($this->image);
   imagedestroy($this->image);
 }

// Displays and/or saves the new image with text as a jpg image.
// $sim >> path for the saving of the new jpg image with text.
// if $sim is not set, it will merely display the jpg image with text.
// if $sim is set and $dim is set to 1, the image will be saved and displayed.
 function ShowJpg($sim="",$dim="1")
 {
  //output picture
  header("Content-type: image/jpeg");
 if(!($sim=="")){
  $fh=fopen($sim,'w');
  fclose($fh);
  imagejpeg($this->image,$sim,85);
  }else{
  imagejpeg($this->image,'',100);
  }
  if($dim == "1")imagejpeg($this->image,'',100);
   imagedestroy($this->image);
 }

// Displays and/or saves the new image with text as a png image.
// $sim >> path for the saving of the new png image with text.
// if $sim is not set, it will merely display the png image with text.
// if $sim is set and $dim is set to 1, the image will be saved and displayed.
  function ShowPng($sim="",$dim="1")
 {
  //output picture
  header("Content-type: image/png");
 if(!($sim=="")){
  $fh=fopen($sim,'w');
  fclose($fh);
  imagepng($this->image,$sim);
  }else{
  imagepng($this->image);
  }
  if($dim == "1")imagepng($this->image);
   imagedestroy($this->image);
 }

//**************** Internal Functions used by MakeImage**************
// Sets the horizontal position of the first character of a line of text.
// $width >> width of the image
// $twidth >> width of the longest line of this group of lines of text
// $lwidth >> width of this line of text.
 function Horiz($width,$twidth,$lwidth)
 {
  if($this->just=="right")$xnew=$twidth-$lwidth-2;
  if($this->just=="center")$xnew=($twidth-$lwidth)/2;
  if($this->just=="left")$xnew=1;
  if($this->horz=="right")$xnew=$xnew+($width-$twidth);
  if($this->horz=="center")$xnew=$xnew+($width-$twidth)/2;
  return $xnew;
 }

// Sets the vertical position of the first character of a line of text.
// $width >> height of the image
// $twidth >> height of this group of lines of text
// $lwidth >> height of one line of text.
  function Vert($height,$theight,$lheight)
 {
  if($this->vert=="center")$ynew=($height/2)-($theight/2)+$lheight;
  if($this->vert=="top")$ynew=$lheight+8;
  if($this->vert=="bottom")$ynew=$height-$theight+$lheight-8;
  return $ynew;
 }
}
?>