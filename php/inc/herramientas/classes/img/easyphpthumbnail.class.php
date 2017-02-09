<?php 

/**

EasyPhpThumbnail class version 1.0.1 - PHP5
Thumbnail class based on the EasyPhpAlbum gallery script
On-the-fly thumbnail creation and image manipulation

Copyright (c) 2008 JF Nutbroek <jfnutbroek@gmail.com>

Permission to use, copy, modify, and/or distribute this software for any
purpose without fee is hereby granted, provided that the above
copyright notice and this permission notice appear in all copies.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.

*/

class easyphpthumbnail {
	
	/**
	 * The size of the thumbnail in px
	 * Autoscale landscape or portrait
	 *
	 * @var int
	 */	
	public $Thumbsize;	
	/**
	 * The height of the thumbnail in px
	 * Forces all thumbnails to the same height
	 *
	 * @var int
	 */	
	public $Thumbheight;		
	/**
	 * The width of the thumbnail in px
	 * Forces all thumbnails to the same width
	 *
	 * @var int
	 */	
	public $Thumbwidth;
	/**
	 * Set dimensions to percentage
	 * 
	 * @var boolean
	 */		
	public $Percentage;	
	/**
	 * Allow image enlargement
	 *
	 * @var boolean
	 */		
	public $Inflate;
	/**
	 * Quality of JPEG images
	 *
	 * @var int
	 */		
	public $Quality;	
	/**
	 * The frame width in px around the image
	 *
	 * @var int
	 */	
	public $Framewidth;
	/**
	 * Frame color in web format: '#00FF00'
	 *
	 * @var string
	 */		
	public $Framecolor;	
	/**
	 * Background color in web format: '#00FF00'
	 *
	 * @var string
	 */		
	public $Backgroundcolor;	
	/**
	 * Add shadow
	 * 
	 * @var boolean
	 */		
	public $Shadow;
	/**
	 * Show binder
	 *
	 * @var boolean
	 */		
	public $Binder;
	/**
	 * Binder spacing in px
	 *
	 * @var int
	 */			
	public $Binderspacing;	
	/**
	 * Path to PNG watermark image
	 *
	 * @var string
	 */		
	public $Watermarkpng;
	/**
	 * Position of watermark image, bottom right corner: '100% 100%'
	 *
	 * @var string
	 */		
	public $Watermarkposition;
	/**
	 * Transparency level of watermark image
	 *
	 * @var int
	 */		
	public $Watermarktransparency;
	/**
	 * CHMOD level of saved thumbnails: '0755'
	 *
	 * @var string
	 */		
	public $Chmodlevel;
	/**
	 * Path to location for thumbnails
	 *
	 * @var string
	 */		
	public $Thumblocation;
	/**
	 * Filetype conversion for saving thumbnail
	 *
	 * @var string
	 */		
	public $Thumbsaveas;	
	/**
	 * Prefix for saving thumbnails
	 *
	 * @var string
	 */		
	public $Thumbprefix;
	/**
	 * Clip corners; array with 7 values
	 * [0]: 0=disable 1=straight 2=rounded
	 * [1]: Percenatge of clipping
	 * [2]: Clip randomly Boolean 0=disable 1=enable
	 * [3]: Clip top left Boolean 0=disable 1=enable
	 * [4]: Clip bottom left Boolean 0=disable 1=enable
	 * [5]: Clip top right Boolean 0=disable 1=enable
	 * [6]: Clip bottom right Boolean 0=disable 1=enable
	 *
	 * @var array
	 */		
	public $Clipcorner;
	/**
	 * Age image; array with 3 values
	 * [0]: Boolean 0=disable 1=enable
	 * [1]: Add noise 0-100, 0=disable
	 * [2]: Sephia depth 0-100, 0=disable (greyscale)
	 *
	 * @var array
	 */		
	public $Ageimage;
	/**
	 * Crop image; array with 6 values
	 * [0]: 0=disable 1=enable free crop 2=enable center crop
	 * [1]: 0=percentage 1=pixels
	 * [2]: Crop left
	 * [3]: Crop right
	 * [4]: Crop top
	 * [5]: Crop bottom
	 *
	 * @var array
	 */		
	public $Cropimage;	
	/**
	 * Path to PNG border image
	 *
	 * @var string
	 */			
	public $Borderpng;
	/**
	 * Copyright text
	 *
	 * @var string
	 */		
	public $Copyrighttext;
	/**
	 * Position for Copyrighttext text, bottom right corner: '100% 100%'
	 *
	 * @var string
	 */			
	public $Copyrightposition;
	/**
	 * Path to TTF Fonttype
	 * If no TTF font is specified, system font will be used
	 *
	 * @var string
	 */			
	public $Copyrightfonttype;		
	/**
	 * Fontsize for Copyrighttext text
	 *
	 * @var string
	 */			
	public $Copyrightfontsize;	
	/**
	 * Copyrighttext text color in web format: '#000000'
	 * No color specified will auto-determine black or white
	 *
	 * @var string
	 */			
	public $Copyrighttextcolor;
	/**
	 * Rotate image in degrees
	 *
	 * @var int
	 */				
	public $Rotate;	
	/**
	 * Flip the image horizontally
	 *
	 * @var boolean
	 */				
	public $Fliphorizontal;		
	/**
	 * Flip the image vertically
	 *
	 * @var boolean
	 */				
	public $Flipvertical;	
	/**
	 * Create square thumbs
	 *
	 * @var boolean
	 */			
	public $Square;
	/**
	 * The image filename or array with filenames
	 *
	 * @var string / array
	 */
	private $image;	
	/**
	 * Original image
	 *
	 * @var image	 
	 */			
	private $im;
	/**
	 * Thumbnail image
	 *
	 * @var image	 
	 */			
	private $thumb;
	/**
	 * Temporary image
	 *
	 * @var image	 
	 */			
	private $newimage;	
	/**
	 * Dimensions of original image; array with 3 values
	 * [0]: Width
	 * [1]: Height
	 * [2]: Filetype
	 *
	 * @var array	 
	 */			
	private $size;
	/**
	 * Offset in px for binder
	 *
	 * @var int	 
	 */			
	private $bind_offset;
	/**
	 * Offset in px for shadow
	 *
	 * @var int	 
	 */			
	private $shadow_offset;
	/**
	 * Offset in px for frame
	 *
	 * @var int 
	 */			
	private $frame_offset;
	/**
	 * Thumb width in px
	 *
	 * @var int	 
	 */				
	private $thumbx;
	/**
	 * Thumb height in px
	 *
	 * @var int	 
	 */				
	private $thumby;

	/**
	 * Class constructor
	 *
	 */	
	public function __construct() {
	
		$this->Thumbsize								= 160;
		$this->Thumbheight							= 0;
		$this->Thumbwidth								= 0;
		$this->Percentage								= false;		
		$this->Framewidth								= 0;
		$this->Inflate									= false;
		$this->Shadow										= false;
		$this->Binder										= false;
		$this->Binderspacing						= 8;		
		$this->Backgroundcolor					= '#FFFFFF';
		$this->Framecolor								= '#FFFFFF';
		$this->Watermarkpng							= '';
		$this->Watermarkposition				= '100% 100%';
		$this->Watermarktransparency		= '70';	
		$this->Quality									= '90';
		$this->Chmodlevel								= '';
		$this->Thumblocation						= '';
		$this->Thumbsaveas							= '';
		$this->Thumbprefix							= 'thumbnail_';
		$this->Clipcorner								= array(0,15,0,1,1,1,0);
		$this->Ageimage									= array(0,10,80);
		$this->Cropimage								= array(0,0,20,20,20,20);		
		$this->Borderpng								= '';
		$this->Copyrighttext						= '';
		$this->Copyrightposition				= '0% 95%';
		$this->Copyrightfonttype				= '';
		$this->Copyrightfontsize				= 2;
		$this->Copyrighttextcolor				= '';
		$this->Rotate										= 0;
		$this->Fliphorizontal						= false;
		$this->Flipvertical							= false;
		$this->Square										= false;
		
	}

	/**
	 * Class destructor
	 *
	 */	
	public function __destruct() {
		if(is_resource($this->im)) imagedestroy($this->im);
		if(is_resource($this->thumb)) imagedestroy($this->thumb);
		if(is_resource($this->newimage)) imagedestroy($this->newimage);
	}

	/**
	 * Creates and outputs thumbnail
	 *
	 * @param string/array $filename
	 * @param string $output
	 */	
	public function Createthumb($filename="unknown",$output="screen") {

		if (is_array($filename) && $output=="file") {
			foreach ($filename as $name) {
				$this->image=$name;
        $this->thumbmaker();
				$this->savethumb();
			}
		} else {
			$this->image=$filename;
			$this->thumbmaker();
			if ($output=="file") {$this->savethumb();} else {$this->displaythumb();}
		}
		
	}

	/**
	 * Apply all modifications to image
	 *
	 */	
	private function thumbmaker() {

		if($this->loadimage()) {
			// Modifications to the original image
			if ($this->Cropimage[0]>0) {$this->cropimage();}
			if ($this->Clipcorner[0]==1) {$this->clipcornersstraight();}
			if ($this->Clipcorner[0]==2) {$this->clipcornersround();}
			if ($this->Ageimage[0]==1) {$this->ageimage();}
			if ($this->Fliphorizontal) {$this->rotateorflip(0,1);}
			if ($this->Flipvertical) {$this->rotateorflip(0,-1);}
			if ($this->Watermarkpng!='') {$this->addpngwatermark();}			
			if (intval($this->Rotate)<>0) {
				switch(intval($this->Rotate)) {
					case -90:
					case 270:
						$this->rotateorflip(1,0);
						break;
					case -270:
					case 90:
						$this->rotateorflip(1,0);
						break;
					case -180:
					case 180:
						$this->rotateorflip(1,0);
						$this->rotateorflip(1,0);
						break;
					default:
						$this->freerotate();
				}
			}
			// Modifications to the resized image
			$this->createemptythumbnail();
			if ($this->Binder) {$this->addbinder();}
			if ($this->Shadow) {$this->addshadow();}
			imagecopyresampled($this->thumb,$this->im,$this->Framewidth*($this->frame_offset-1),$this->Framewidth,0,0,$this->thumbx-($this->frame_offset*$this->Framewidth)-$this->shadow_offset,$this->thumby-2*$this->Framewidth-$this->shadow_offset,imagesx($this->im),imagesy($this->im));
			if ($this->Borderpng!='') {$this->addpngborder();}
			if ($this->Copyrighttext!='') {$this->addcopyright();}		
			if ($this->Square) {$this->square();}
		}
	}

	/**
	 * Load image in memory
	 *
	 */	
	private function loadimage() {

		if (file_exists($this->image)) {
			$this->size=GetImageSize($this->image);
			switch($this->size[2]) {
				case 1:
					if (imagetypes() & IMG_GIF) {$this->im=imagecreatefromgif($this->image);return true;} else {$this->invalidimage('No GIF support');return false;}
					break;
				case 2:
					if (imagetypes() & IMG_JPG) {$this->im=imagecreatefromjpeg($this->image);return true;} else {$this->invalidimage('No JPG support');return false;}
					break;
				case 3:
					if (imagetypes() & IMG_PNG) {$this->im=imagecreatefrompng($this->image);return true;} else {$this->invalidimage('No PNG support');return false;}
					break;
				default:
					$this->invalidimage('Filetype ?????');
					return false;
			}
		} else {
			$this->invalidimage('File not found');
			return false;
		}
				
	}

	/**
	 * Creates error image
	 *
	 * @param string $message
	 */	
	private function invalidimage($message) {
	
		$this->thumb=imagecreate(80,75);
		$black=imagecolorallocate($this->thumb,0,0,0);$yellow=imagecolorallocate($this->thumb,255,255,0);
		imagefilledrectangle($this->thumb,0,0,80,75,imagecolorallocate($this->thumb,255,0,0));
		imagerectangle($this->thumb,0,0,79,74,$black);imageline($this->thumb,0,20,80,20,$black);
		imagefilledrectangle($this->thumb,1,1,78,19,$yellow);imagefilledrectangle($this->thumb,27,35,52,60,$yellow);
		imagerectangle($this->thumb,26,34,53,61,$black);
		imageline($this->thumb,27,35,52,60,$black);imageline($this->thumb,52,35,27,60,$black);
		imagestring($this->thumb,1,5,5,$message,$black);
		
	}		

	/**
	 * Add watermark to image
	 *
	 */	
	private function addpngwatermark() {
	
		if (file_exists($this->Watermarkpng)) {
			$this->newimage=imagecreatefrompng($this->Watermarkpng);
			$wpos=explode(' ',str_replace('%','',$this->Watermarkposition));
			imagecopymerge($this->im,$this->newimage,min(max(imagesx($this->im)*($wpos[0]/100)-0.5*imagesx($this->newimage),0),imagesx($this->im)-imagesx($this->newimage)),min(max(imagesy($this->im)*($wpos[1]/100)-0.5*imagesy($this->newimage),0),imagesy($this->im)-imagesy($this->newimage)),0,0,imagesx($this->newimage),imagesy($this->newimage),intval($this->Watermarktransparency));
			imagedestroy($this->newimage);
		}
		
	}

	/**
	 * Create empty thumbnail
	 *
	 */	
	private function createemptythumbnail() {
	
		$thumbsize=$this->Thumbsize;$thumbwidth=$this->Thumbwidth;$thumbheight=$this->Thumbheight;
		if ($thumbsize==0) {$thumbsize=9999;$thumbwidth=0;$thumbheight=0;}
		if ($this->Percentage) {
			if ($thumbwidth>0) {$thumbwidth=floor($thumbwidth*($this->Percentage/100)*$this->size[0]);}
			if ($thumbheight>0) {$thumbheight=floor($thumbheight*($this->Percentage/100)*$this->size[0]);}
			if ($this->size[0]>$this->size[1])
				$thumbsize=floor($thumbsize*($this->Percentage/100)*$this->size[0]);
			else
				$thumbsize=floor($thumbsize*($this->Percentage/100)*$this->size[1]);
		}
		if (!$this->Inflate) {
			if ($thumbsize>$this->size[0] && $thumbsize>$this->size[1]) {$thumbsize=max($this->size[0],$this->size[1]);}
		}
		if ($this->Binder) {$this->frame_offset=3;$this->bind_offset=4;} else {$this->frame_offset=2;$this->bind_offset=0;}
		if ($this->Shadow) {$this->shadow_offset=3;} else {$this->shadow_offset=0;}
		if ($thumbheight>0) {
			$this->thumb=imagecreatetruecolor($this->Framewidth*$this->frame_offset+ceil($this->size[0]/($this->size[1]/$thumbheight))+$this->shadow_offset,$this->Framewidth*2+$thumbheight+$this->shadow_offset);
		} else if ($thumbwidth>0) {
			$this->thumb=imagecreatetruecolor($this->Framewidth*$this->frame_offset+$thumbwidth+$this->shadow_offset,$this->Framewidth*2+ceil($this->size[1]/($this->size[0]/$thumbwidth))+$this->shadow_offset);
		} else {
			$x1=$this->Framewidth*$this->frame_offset+$thumbsize+$this->shadow_offset;
			$x2=$this->Framewidth*$this->frame_offset+ceil($this->size[0]/($this->size[1]/$thumbsize))+$this->shadow_offset;
			$y1=$this->Framewidth*2+ceil($this->size[1]/($this->size[0]/$thumbsize))+$this->shadow_offset;
			$y2=$this->Framewidth*2+$thumbsize+$this->shadow_offset;
			if ($this->size[0]>$this->size[1]) {$this->thumb=imagecreatetruecolor($x1,$y1);} else {$this->thumb=imagecreatetruecolor($x2,$y2);}
		}
		$this->thumbx=imagesx($this->thumb);$this->thumby=imagesy($this->thumb);
		imagefill($this->thumb,0,0,imagecolorallocate($this->thumb,hexdec(substr($this->Backgroundcolor,1,2)),hexdec(substr($this->Backgroundcolor,3,2)),hexdec(substr($this->Backgroundcolor,5,2))));			
		imagefilledrectangle($this->thumb,$this->bind_offset,0,$this->thumbx-$this->shadow_offset,$this->thumby-$this->shadow_offset,imagecolorallocate($this->thumb,hexdec(substr($this->Framecolor,1,2)),hexdec(substr($this->Framecolor,3,2)),hexdec(substr($this->Framecolor,5,2))));
		
	}

	/**
	 * Drop shadow on thumbnail
	 *
	 */	
	private function addshadow() {
	
		$gray=imagecolorallocate($this->thumb,192,192,192);
		$middlegray=imagecolorallocate($this->thumb,158,158,158);
		$darkgray=imagecolorallocate($this->thumb,128,128,128);
		imagerectangle($this->thumb,$this->bind_offset,0,$this->thumbx-4,$this->thumby-4,$gray);
		imageline($this->thumb,$this->bind_offset,$this->thumby-3,$this->thumbx,$this->thumby-3,$darkgray);
		imageline($this->thumb,$this->thumbx-3,0,$this->thumbx-3,$this->thumby,$darkgray);
		imageline($this->thumb,$this->bind_offset+2,$this->thumby-2,$this->thumbx,$this->thumby-2,$middlegray);
		imageline($this->thumb,$this->thumbx-2,2,$this->thumbx-2,$this->thumby,$middlegray);
		imageline($this->thumb,$this->bind_offset+2,$this->thumby-1,$this->thumbx,$this->thumby-1,$gray);
		imageline($this->thumb,$this->thumbx-1,2,$this->thumbx-1,$this->thumby,$gray);
		
	}

	/**
	 * Clip corners original image
	 *
	 */	
	private function clipcornersstraight() {
	
		$clipsize=$this->Clipcorner[1];
		if ($this->size[0]>$this->size[1])
			$clipsize=floor($this->size[0]*(intval($clipsize)/100));
		else
			$clipsize=floor($this->size[1]*(intval($clipsize)/100));
		if (intval($clipsize)>0) {
			$bgcolor=imagecolorallocate($this->im,hexdec(substr($this->Backgroundcolor,1,2)),hexdec(substr($this->Backgroundcolor,3,2)),hexdec(substr($this->Backgroundcolor,5,2)));
			if ($this->Clipcorner[2]) {$random1=rand(0,1);$random2=rand(0,1);$random3=rand(0,1);$random4=rand(0,1);} else {$random1=1;$random2=1;$random3=1;$random4=1;}
			for ($i=0;$i<$clipsize;$i++) {			
				if ($this->Clipcorner[3] && $random1) {imageline($this->im,0,$i,$clipsize-$i,$i,$bgcolor);}
				if ($this->Clipcorner[4] && $random2) {imageline($this->im,0,$this->size[1]-$i-1,$clipsize-$i,$this->size[1]-$i-1,$bgcolor);}				
				if ($this->Clipcorner[5] && $random3) {imageline($this->im,$this->size[0]-$clipsize+$i,$i,$this->size[0]+$clipsize-$i,$i,$bgcolor);}				
				if ($this->Clipcorner[6] && $random4) {imageline($this->im,$this->size[0]-$clipsize+$i,$this->size[1]-$i-1,$this->size[0]+$clipsize-$i,$this->size[1]-$i-1,$bgcolor);}
			}
		}
		
	}

	/**
	 * Clip round corners original image
	 *
	 */	
	private function clipcornersround() {
	
		$clipsize=$this->Clipcorner[1];
		$clipsize=floor($this->size[0]*(intval($clipsize)/100));
		$clip_degrees=90/intval($clipsize);
		$points_tl=array(0,0);
		$points_br=array($this->size[0],$this->size[1]);
		$points_tr=array($this->size[0],0);
		$points_bl=array(0,$this->size[1]);
		$bgcolor=imagecolorallocate($this->im,hexdec(substr($this->Backgroundcolor,1,2)),hexdec(substr($this->Backgroundcolor,3,2)),hexdec(substr($this->Backgroundcolor,5,2)));
		for ($i=0;$i<$clipsize;$i++) {
			$x=$clipsize*cos(deg2rad($i*$clip_degrees));
			$y=$clipsize*sin(deg2rad($i*$clip_degrees));
			array_push($points_tl,$clipsize-$x);
			array_push($points_tl,$clipsize-$y);
			array_push($points_tr,$this->size[0]-$clipsize+$x);
			array_push($points_tr,$clipsize-$y);
			array_push($points_br,$this->size[0]-$clipsize+$x);
			array_push($points_br,$this->size[1]-$clipsize+$y);
			array_push($points_bl,$clipsize-$x);
			array_push($points_bl,$this->size[1]-$clipsize+$y);
		}
		array_push($points_tl,$clipsize,0);
		array_push($points_br,$this->size[0]-$clipsize,$this->size[1]);
		array_push($points_tr,$this->size[0]-$clipsize,0);
		array_push($points_bl,$clipsize,$this->size[1]);
		if ($this->Clipcorner[2]) {$random1=rand(0,1);$random2=rand(0,1);$random3=rand(0,1);$random4=rand(0,1);} else {$random1=1;$random2=1;$random3=1;$random4=1;}
		if ($this->Clipcorner[3] && $random1) {imagefilledpolygon($this->im,$points_tl,count($points_tl)/2,$bgcolor);}
		if ($this->Clipcorner[4] && $random2) {imagefilledpolygon($this->im,$points_bl,count($points_bl)/2,$bgcolor);}		
		if ($this->Clipcorner[5] && $random3) {imagefilledpolygon($this->im,$points_tr,count($points_tr)/2,$bgcolor);}		
		if ($this->Clipcorner[6] && $random4) {imagefilledpolygon($this->im,$points_br,count($points_br)/2,$bgcolor);}
		imagerectangle($this->im,0,0,$this->size[0]-1,$this->size[1]-1,$bgcolor);

	}

	/**
	 * Convert original image to greyscale and/or apply noise and sephia effect
	 *
	 */	
	private function ageimage() {
	
		imagetruecolortopalette($this->im,1,256);
		for ($c=0;$c<256;$c++) {    
			$col=imagecolorsforindex($this->im,$c);
			$new_col=floor($col['red']*0.2125+$col['green']*0.7154+$col['blue']*0.0721);
			$noise=rand(-$this->Ageimage[1],$this->Ageimage[1]);
			if ($this->Ageimage[2]>0) {
				$r=$new_col+$this->Ageimage[2]+$noise;
				$g=floor($new_col+$this->Ageimage[2]/1.86+$noise);
				$b=floor($new_col+$this->Ageimage[2]/-3.48+$noise);
			} else {
				$r=$new_col+$noise;
				$g=$new_col+$noise;
				$b=$new_col+$noise;
			}
			imagecolorset($this->im,$c,max(0,min(255,$r)),max(0,min(255,$g)),max(0,min(255,$b)));
		}
		
	}

	/**
	 * Add border to thumbnail
	 *
	 */	
	private function addpngborder() {
	
		if (file_exists($this->Borderpng)) {
			$borderim=imagecreatefrompng($this->Borderpng);
			imagecopyresampled($this->thumb,$borderim,$this->bind_offset,0,0,0,$this->thumbx-$this->shadow_offset-$this->bind_offset,$this->thumby-$this->shadow_offset,imagesx($borderim),imagesy($borderim));
			imagedestroy($borderim);
		}
		
	}

	/**
	 * Add binder effect to thumbnail
	 *
	 */	
	private function addbinder() {
	
		if (intval($this->Binderspacing)<4) {$this->Binderspacing=4;}
		$spacing=floor($this->thumby/$this->Binderspacing)-2;
		$offset=floor(($this->thumby-($spacing*$this->Binderspacing))/2);
		$gray=imagecolorallocate($this->thumb,192,192,192);
		$middlegray=imagecolorallocate($this->thumb,158,158,158);
		$darkgray=imagecolorallocate($this->thumb,128,128,128);		
		$black=imagecolorallocate($this->thumb,0,0,0);	
		$white=imagecolorallocate($this->thumb,255,255,255);		
		for ($i=$offset;$i<=$offset+$spacing*$this->Binderspacing;$i+=$this->Binderspacing) {
			imagefilledrectangle($this->thumb,8,$i-2,10,$i+2,$black);
			imageline($this->thumb,11,$i-1,11,$i+1,$darkgray);
			imageline($this->thumb,8,$i-2,10,$i-2,$darkgray);
			imageline($this->thumb,8,$i+2,10,$i+2,$darkgray);
			imagefilledrectangle($this->thumb,0,$i-1,8,$i+1,$gray);
			imageline($this->thumb,0,$i,8,$i,$white);
			imageline($this->thumb,0,$i-1,0,$i+1,$gray);
			imagesetpixel($this->thumb,0,$i,$darkgray);
		}
		
	}

	/**
	 * Add Copyright text to thumbnail
	 *
	 */	
	private function addcopyright() {

		if ($this->Copyrightfonttype=='') {
			$widthx=imagefontwidth($this->Copyrightfontsize)*strlen($this->Copyrighttext);
			$heighty=imagefontheight($this->Copyrightfontsize);
			$fontwidth=imagefontwidth($this->Copyrightfontsize);
		} else {		
			$dimensions=imagettfbbox($this->Copyrightfontsize,0,$this->Copyrightfonttype,$this->Copyrighttext);
			$widthx=$dimensions[2];$heighty=$dimensions[5];
			$dimensions=imagettfbbox($this->Copyrightfontsize,0,$this->Copyrightfonttype,'W');
			$fontwidth=$dimensions[2];
		}
		$cpos=explode(' ',str_replace('%','',$this->Copyrightposition));
		if (count($cpos)>1) {
			$cposx=floor(min(max($this->thumbx*($cpos[0]/100)-0.5*$widthx,$fontwidth),$this->thumbx-$widthx-0.5*$fontwidth));
			$cposy=floor(min(max($this->thumby*($cpos[1]/100)-0.5*$heighty,$heighty),$this->thumby-$heighty*1.5));
		} else {
			$cposx=$fontwidth;
			$cposy=$this->thumby-10;
		}			
		if ($this->Copyrighttextcolor=='') {
			$colors=array();
			for ($i=$cposx;$i<($cposx+$widthx);$i++) {
				$indexis=ImageColorAt($this->thumb,$i,$cposy+0.5*$heighty);
				$rgbarray=ImageColorsForIndex($this->thumb,$indexis);
				array_push($colors,$rgbarray['red'],$rgbarray['green'],$rgbarray['blue']);
			}
			if (array_sum($colors)/count($colors)>180) {
				if ($this->Copyrightfonttype=='')
					imagestring($this->thumb,$this->Copyrightfontsize,$cposx,$cposy,$this->Copyrighttext,imagecolorallocate($this->thumb,0,0,0));
				else
					imagettftext($this->thumb,$this->Copyrightfontsize,0,$cposx,$cposy,imagecolorallocate($this->thumb,0,0,0),$this->Copyrightfonttype,$this->Copyrighttext);
			} else {
				if ($this->Copyrightfonttype=='')
					imagestring($this->thumb,$this->Copyrightfontsize,$cposx,$cposy,$this->Copyrighttext,imagecolorallocate($this->thumb,255,255,255));
				else
					imagettftext($this->thumb,$this->Copyrightfontsize,0,$cposx,$cposy,imagecolorallocate($this->thumb,255,255,255),$this->Copyrightfonttype,$this->Copyrighttext);				
			}
		} else {
			if ($this->Copyrightfonttype=='')
				imagestring($this->thumb,$this->Copyrightfontsize,$cposx,$cposy,$this->Copyrighttext,imagecolorallocate($this->thumb,hexdec(substr($this->Copyrighttextcolor,1,2)),hexdec(substr($this->Copyrighttextcolor,3,2)),hexdec(substr($this->Copyrighttextcolor,5,2))));
			else
				imagettftext($this->thumb,$this->Copyrightfontsize,0,$cposx,$cposy,imagecolorallocate($this->thumb,hexdec(substr($this->Copyrighttextcolor,1,2)),hexdec(substr($this->Copyrighttextcolor,3,2)),hexdec(substr($this->Copyrighttextcolor,5,2))),$this->Copyrightfonttype,$this->Copyrighttext);				
		}
		
	}

	/**
	 * Rotate the image at any angle
	 * Image is not scaled down
	 *
	 */	
	private function freerotate() {
	
		$angle=$this->Rotate;
		if ($angle<>0) {
			$centerx=floor($this->size[0]/2);
			$centery=floor($this->size[1]/2);
			$maxsizex=ceil(abs(cos(deg2rad($angle))*$this->size[0])+abs(sin(deg2rad($angle))*$this->size[1]));
			$maxsizey=ceil(abs(sin(deg2rad($angle))*$this->size[0])+abs(cos(deg2rad($angle))*$this->size[1]));
			if ($maxsizex & 1) {$maxsizex+=3;} else	{$maxsizex+=2;}
			if ($maxsizey & 1) {$maxsizey+=3;} else {$maxsizey+=2;}
			$this->newimage=imagecreatetruecolor($maxsizex,$maxsizey);
			imagefill($this->newimage,0,0,imagecolorallocate($this->newimage,hexdec(substr($this->Backgroundcolor,1,2)),hexdec(substr($this->Backgroundcolor,3,2)),hexdec(substr($this->Backgroundcolor,5,2))));			
			$newcenterx=imagesx($this->newimage)/2;
			$newcentery=imagesy($this->newimage)/2;
			$angle+=180;
			for ($px=0;$px<imagesx($this->newimage);$px++) {
				for ($py=0;$py<imagesy($this->newimage);$py++) {
					$vectorx=floor(($newcenterx-$px)*cos(deg2rad($angle))+($newcentery-$py)*sin(deg2rad($angle)));
					$vectory=floor(($newcentery-$py)*cos(deg2rad($angle))-($newcenterx-$px)*sin(deg2rad($angle)));
					if (($centerx+$vectorx)>-1 && ($centerx+$vectorx)<($centerx*2) && ($centery+$vectory)>-1 && ($centery+$vectory)<($centery*2))
						imagecopy($this->newimage,$this->im,$px,$py,$centerx+$vectorx,$centery+$vectory,1,1);
				}
			}
			imagedestroy($this->im);
			$this->im=imagecreatetruecolor(imagesx($this->newimage),imagesy($this->newimage));
			imagecopy($this->im,$this->newimage,0,0,0,0,imagesx($this->newimage),imagesy($this->newimage));
			imagedestroy($this->newimage);
			$this->size[0]=imagesx($this->im);
			$this->size[1]=imagesy($this->im);
		}
		
	}	
	
	/**
	 * Rotate the image +90, -90 or 180 degrees
	 * Flip the image over horizontal or vertical axis
	 *
	 * @param $rotate
	 * @param $flip
	 */		
	private function rotateorflip($rotate,$flip) {

		if ($rotate) {
			$this->newimage=imagecreatetruecolor($this->size[1],$this->size[0]);
		} else {
			$this->newimage=imagecreatetruecolor($this->size[0],$this->size[1]);
		}
		if (intval($this->Rotate)>0 || $flip>0) {
			for ($px=0;$px<$this->size[0];$px++) {
				if ($rotate) {
					for ($py=0;$py<$this->size[1];$py++) {imagecopy($this->newimage,$this->im,$this->size[1]-$py-1,$px,$px,$py,1,1);}
				} else {
					for ($py=0;$py<$this->size[1];$py++) {imagecopy($this->newimage,$this->im,$this->size[0]-$px-1,$py,$px,$py,1,1);}
				}
			}
		} else {
			for ($px=0;$px<$this->size[0];$px++) {
				if ($rotate) {				
					for ($py=0;$py<$this->size[1];$py++) {imagecopy($this->newimage,$this->im,$py,$this->size[0]-$px-1,$px,$py,1,1);}
				} else {
					for ($py=0;$py<$this->size[1];$py++) {imagecopy($this->newimage,$this->im,$px,$this->size[1]-$py-1,$px,$py,1,1);}
				}					
			}
		}
		imagedestroy($this->im);
		$this->im=imagecreatetruecolor(imagesx($this->newimage),imagesy($this->newimage));
		imagecopy($this->im,$this->newimage,0,0,0,0,imagesx($this->newimage),imagesy($this->newimage));			
		imagedestroy($this->newimage);
		$this->size[0]=imagesx($this->im);
		$this->size[1]=imagesy($this->im);

	}
	
	/**
	 * Crop image in percentage or pixels
	 * Crop from sides or from center
	 * Negative value for bottom crop will enlarge the canvas
	 *
	 */		
	private function cropimage() {	
		
		if ($this->Cropimage[1]==0) {
			$this->Cropimage[2]=intval($this->size[0]*($this->Cropimage[2]/100));
			$this->Cropimage[3]=intval($this->size[0]*($this->Cropimage[3]/100));
			$this->Cropimage[4]=intval($this->size[1]*($this->Cropimage[4]/100));
			$this->Cropimage[5]=intval($this->size[1]*($this->Cropimage[5]/100));
		}
		if ($this->Cropimage[0]==2) {
			$this->Cropimage[2]=intval($this->size[0]/2)-$this->Cropimage[2];
			$this->Cropimage[3]=intval($this->size[0]/2)-$this->Cropimage[3];
			$this->Cropimage[4]=intval($this->size[1]/2)-$this->Cropimage[4];
			$this->Cropimage[5]=intval($this->size[1]/2)-$this->Cropimage[5];
		}
		$this->newimage=imagecreatetruecolor($this->size[0]-$this->Cropimage[2]-$this->Cropimage[3],$this->size[1]-$this->Cropimage[4]-$this->Cropimage[5]);
		imagecopy($this->newimage,$this->im,0,0,$this->Cropimage[2],$this->Cropimage[4],$this->size[0]-$this->Cropimage[2]-$this->Cropimage[3],$this->size[1]-$this->Cropimage[4]-$this->Cropimage[5]);
		imagedestroy($this->im);
		$this->im=imagecreatetruecolor(imagesx($this->newimage),imagesy($this->newimage));
		imagecopy($this->im,$this->newimage,0,0,0,0,imagesx($this->newimage),imagesy($this->newimage));
		imagedestroy($this->newimage);
		$this->size[0]=imagesx($this->im);
		$this->size[1]=imagesy($this->im);
	
	}

	/**
	 * Enlarge the canvas to be same width and height
	 *
	 */	
	private function square() {
	
		$squaresize=max($this->thumbx,$this->thumby);
		$this->newimage=imagecreatetruecolor($squaresize,$squaresize);
		imagefill($this->newimage,0,0,imagecolorallocate($this->newimage,hexdec(substr($this->Backgroundcolor,1,2)),hexdec(substr($this->Backgroundcolor,3,2)),hexdec(substr($this->Backgroundcolor,5,2))));
		$centerx=floor(($squaresize-$this->thumbx)/2);
		$centery=floor(($squaresize-$this->thumby)/2);
		imagecopy($this->newimage,$this->thumb,$centerx,$centery,0,0,$this->thumbx,$this->thumby);
		imagedestroy($this->thumb);
		$this->thumb=imagecreatetruecolor($squaresize,$squaresize);
		imagecopy($this->thumb,$this->newimage,0,0,0,0,$squaresize,$squaresize);
		imagedestroy($this->newimage);
		
	}

	/**
	 * Save thumbnail to file
	 *
	 */	
	private function savethumb() {
	
		if ($this->Thumbsaveas!='') {
			switch (strtolower($this->Thumbsaveas)) {
				case "gif":
					$this->image=substr($this->image,0,strrpos($this->image,'.')).".gif";
					$this->size[2]=1;
					break;
				case "jpg":
					$this->image=substr($this->image,0,strrpos($this->image,'.')).".jpg";
					$this->size[2]=2;
					break;
				case "jpeg":
					$this->image=substr($this->image,0,strrpos($this->image,'.')).".jpeg";
					$this->size[2]=2;
					break;			
				case "png":
					$this->image=substr($this->image,0,strrpos($this->image,'.')).".png";
					$this->size[2]=3;
					break;
			}
		}
		switch($this->size[2]) {
			case 1:
				imagegif($this->thumb,$this->Thumblocation.$this->Thumbprefix.$this->image);
				break;
			case 2:
				imagejpeg($this->thumb,$this->Thumblocation.$this->Thumbprefix.$this->image,$this->Quality);
				break;
			case 3:
				imagepng($this->thumb,$this->Thumblocation.$this->Thumbprefix.$this->image);
				break;
		}		
		if ($this->Chmodlevel!='') {chmod($this->Thumblocation.$this->Thumbprefix.$this->image,octdec($this->Chmodlevel));}
		imagedestroy($this->im);
		imagedestroy($this->thumb);
		
	}

	/**
	 * Display thumbnail on screen
	 *
	 */	
	private function displaythumb() {
		
		switch($this->size[2]) {
			case 1:
				header("Content-type: image/gif");imagegif($this->thumb);
				break;
			case 2:
				header("Content-type: image/jpeg");imagejpeg($this->thumb,'',$this->Quality);
				break;
			case 3:
				header("Content-type: image/png");imagepng($this->thumb);
				break;
		}
		imagedestroy($this->im);
		imagedestroy($this->thumb);
		exit;
		
	}

}

?>
