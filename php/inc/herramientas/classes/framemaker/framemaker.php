<?php
## 
## v1.3	Stable ## 09 August 2004
## v1.4	Stable ## 13 August 2004
## FrameMaker
######
## This class sets a frame around the graph screen. 
## You can choose the width from a range. 
## It can make your pictures have a better appeal. 
##
#######
## Author: Huda M Elmatsani
## Email: 	justhuda at netrada.co.id
##
## 08/08/2004
#######
## Copyright (c) 2004 Huda M Elmatsani All rights reserved.
## This program is free for any purpose use.
########
##
## USAGE
## read guide.html
##
## 
## visit http://www.program-ruti.org/framemaker/
## for working sample
##
####


class FrameMaker {

	var $picture			= 	"";
	var $material			= 	"";
	var $img_image			= 	null;
	var $frame_width		=	0;
	var $frame_height		=	0;
	var $frame_shape		= 	""; //oval, rectangle 
	var $frame_marginwidth	=	0;
	var $frame_margincolor	= 	"";
	var $frame_marginliner	= 	0; // in pixel
	var $frame_borderwidth	=	0;
	var $frame_bordercolor	=	"#000000";
	var $frame_bordercolors	=	null;
	var $frame_borderstyle	=	"solid"; 
	var $frame_material		= 	""; /* url path image  */
	var $pic_width			= 	0;
	var	$pic_height			=	0;
	var	$material_height	=	0;
	var $img_material		= 	null;

	function FrameMaker() {
	}

	function set_picture($pic) {

		$this->picture = $pic;

	}
	
	function set_path($path) {

		$this->path = $path;

	}
	
	function set_material($pic) {

		$this->frame_material 		= 	$pic;
		$this->frame_borderstyle 	=	"material";

	}

	function set_size($width,$height) {
 		$this->pic_width 	= 	$width; 
		$this->pic_height 	= 	$height; 
	}

	function set_border($width, $color="#000000", $style="solid" ) {
		
		$this->frame_borderwidth	=	$width;
		$this->frame_bordercolor	=	$color;
		$this->frame_borderstyle	=	$style; // solid, bevel, gradient, raised, sunken

	}

	function set_margin( $width, $color="#FFFFFF", $liner=4, $shape="rectangle" ) {
	
		$this->frame_marginwidth	=	$width;
		$this->frame_margincolor	=	$color;
		$this->frame_marginliner	=	$liner;
		$this->frame_marginshape	=	$shape;

	}


	function show_picture($type="jpg") {
		/* make it not case sensitive*/
		$this->img_type = strtolower($type);


		$picture = $this->prepare_picture();

		/* show the image  */			
		switch($this->img_type){
			case 'jpeg' :
			case 'jpg' 	:
				imagejpeg($picture,$this->path);
				break;
			case 'gif' :
				imagegif($picture,$this->path);
				break;
			case 'png' :
				imagepng($picture,$this->path);
				break;
			case 'wbmp' :
				header("Content-type: image/vnd.wap.wbmp");
				imagewbmp($picture);
				break;
		}

	}

	function prepare_picture() {

		$img_picture		= 	$this->load_picture(); /* must call load_picture() first before create_margin() */

 		$this->pic_width 	= 	imagesx($img_picture); 
		$this->pic_height 	= 	imagesy($img_picture); 

		
		/* put margin */
		if($this->frame_marginwidth) {
			$img_margin 		= $this->create_margin();
	
			$margin_width		= imagesx($img_margin);
			$margin_height		= imagesy($img_margin);
		}
		$img_frame			= $this->create_frame();	

		/* prepare place for putting everything */

		$img_prepare	= imagecreatetruecolor($this->frame_width, $this->frame_height);
		$bg_color 		= imagecolorallocate($img_prepare,255,255,255);
		imagefill($img_prepare,0,0,$bg_color);
 
		imagecopy(  $img_prepare, $img_frame,  
					0, 0, 0, 0, 
					$this->frame_width, 
					$this->frame_height);

		imagecopyresampled(  $img_prepare, $img_picture,  
					$this->frame_marginwidth+$this->frame_borderwidth, 
					$this->frame_marginwidth+$this->frame_borderwidth, 
					0, 0, 
					$this->pic_width, $this->pic_height,
					$this->pic_width, $this->pic_height);

		if($this->frame_marginwidth)
		imagecopy(  $img_prepare, $img_margin,  
					$this->frame_borderwidth, 
					$this->frame_borderwidth, 
					0, 0, 
					$margin_width, 
					$margin_height);


		return $img_prepare;
		imagedestroy( $img_prepare );
	}

	function load_picture() {

		/* pick picture you want to frame  */
		if(file_exists($this->picture)) {

			$extension = $this->get_imagetype($this->picture);

			/* create image source from your image strip stock */
			switch($extension){
				case 'jpeg' :
				case 'jpg' 	:
					$img_picture 	= @imagecreatefromjpeg ($this->picture);
					break;
				case 'gif' :
					$img_picture 	= @imagecreatefromgif ($this->picture);					
					break;
				case 'png' :
					$img_picture 	= @imagecreatefrompng ($this->picture);	
					break;
			}

		} else {
						/* if fail to load image file, create it on the fly */
			$img_picture 	= $this->draw_picture();
		}

		return $img_picture;
		imagedestroy( $img_picture );
	}

	function set_image($image) {
	
		$this->img_image = $image;
	
	}

	function draw_picture() {

		if($this->img_image) {
		
			return $this->img_image;
		
		} else {		
			if(!$this->pic_height)
				$this->set_size(300,200);
	
			$img_picture    = imagecreatetruecolor($this->pic_width, $this->pic_height);
			$bg_color		= imagecolorallocate ($img_picture, 200, 200, 200);
			imagefill ( $img_picture, 0, 0, $bg_color );
		}
		return $img_picture;
		imagedestroy ($img_picture);


	}


	function load_material() {
		/* pick picture you want to frame */
		if(file_exists($this->frame_material)) {

			$extension = $this->get_imagetype($this->frame_material);

			/* create image source from your image strip stock*/
			switch($extension){
				case 'jpeg' :
				case 'jpg' 	:
					$img_material 	= @imagecreatefromjpeg ($this->frame_material);
					break;
				case 'gif' :
					$img_material 	= @imagecreatefromgif ($this->frame_material);					
					break;
				case 'png' :
					$img_material 	= @imagecreatefrompng ($this->frame_material);										break;
			}

		} else {

			$img_material = $this->create_material();
		}
 		return $img_material;
 		imagedestroy( $img_material );

	}

	function create_material() {

		$style 	= $this->frame_borderstyle;
		$color	= $this->frame_bordercolor;
		$width 	= $this->frame_borderwidth;

		return $this->$style($color,$width);


	}


	function prepare_frame() {

 		//if($this->load_material()) {
			$this->img_material			= $this->load_material();
			$this->frame_borderwidth	= imagesx( $this->img_material );
		//}

		$this->frame_width		=	$this->pic_width + 2 * $this->frame_borderwidth + 2 * $this->frame_marginwidth;
		$this->frame_height		=	$this->pic_height + 2 * $this->frame_borderwidth + 2 * $this->frame_marginwidth;

		$img_frame    	= imagecreate ($this->frame_width, $this->frame_height);
	
		return $img_frame;
		imagedestroy( $img_frame );

	}

	function create_frame() {


		$img_frame		= $this->prepare_frame();

		$imslice_top 	= $this->img_material;
		$imslice_left 	= $this->image_Rotate($imslice_top,90,0); 
		$imslice_right 	= $this->image_Rotate($imslice_top,-90,0);
		$imslice_bottom = $this->image_Rotate($imslice_top,180,0);

		/* create bar */
		$imbar_top 		= imagecreatetruecolor( $this->frame_width, $this->frame_borderwidth );
		imagesettile( $imbar_top, $imslice_top );
		imagefilledrectangle ($imbar_top, 0, 0, imagesx($imbar_top), imagesy($imbar_top), IMG_COLOR_TILED);

		$imbar_left 	= imagecreatetruecolor( $this->frame_borderwidth, $this->frame_height );
		imagesettile( $imbar_left, $imslice_left );
		imagefilledrectangle ($imbar_left, 0, 0, imagesx($imbar_left), imagesy($imbar_left), IMG_COLOR_TILED);

		$imbar_right 	= imagecreatetruecolor( $this->frame_borderwidth, $this->frame_height );
		imagesettile( $imbar_right, $imslice_right );
		imagefilledrectangle ($imbar_right, 0, 0, imagesx($imbar_right), imagesy($imbar_right), IMG_COLOR_TILED);

		$imbar_bottom 	= imagecreatetruecolor( $this->frame_width, $this->frame_borderwidth );
		imagesettile( $imbar_bottom, $imslice_bottom );
		imagefilledrectangle ($imbar_bottom, 0, 0, imagesx($imbar_bottom), imagesy($imbar_bottom), IMG_COLOR_TILED);

		imagecopy ( $img_frame, $imbar_top, 	0, 0, 0, 0, imagesx($imbar_top), 	imagesy($imbar_top)); 
		imagecopy ( $img_frame, $imbar_left, 	0, 0, 0, 0, imagesx($imbar_left), 	imagesy($imbar_left)); 
		imagecopy ( $img_frame, $imbar_right, 	$this->frame_width  - $this->frame_borderwidth, 0, 0, 0, imagesx($imbar_right), 	imagesy($imbar_right)); 
		imagecopy ( $img_frame, $imbar_bottom, 	0, $this->frame_height - $this->frame_borderwidth, 0, 0, imagesx($imbar_bottom), imagesy($imbar_bottom)); 

		$im_corner 		= $this->img_material;

		$im 			= $this->image_Rotate($im_corner,90,0);

		$part_height	= imagesy($im_corner);

		$xwhite 	= imagecolorallocate($im_corner, 250, 254, 253); 
		$black 	= imagecolorallocate($im_corner, 0, 0, 0); 

		$points = array(0,0,$part_height,$part_height,0,$part_height,0,0);
		imagefilledpolygon($im_corner, $points, 3, $xwhite);
		imagecolortransparent($im_corner,$xwhite);

		imagecopymerge( $im, $im_corner, 0, 0, 0, 0, $part_height, $part_height, 100 );

		$im_corners[]	= $im;
		$im_corners[]	= $this->image_Rotate($im,90,0);
		$im_corners[]	= $this->image_Rotate($im,-90,0);
		$im_corners[]	= $this->image_Rotate($im,180,0);

		imagecopy ( $img_frame, $im_corners[0], 0, 0, 0, 0, imagesx($im_corners[0]), imagesy($im_corners[0])); 
		imagecopy ( $img_frame, $im_corners[1], 0, $this->frame_height - $this->frame_borderwidth, 0, 0, imagesx($im_corners[1]), imagesy($im_corners[1])); 
		imagecopy ( $img_frame, $im_corners[2], $this->frame_width  - $this->frame_borderwidth, 0, 0, 0, imagesx($im_corners[2]), imagesy($im_corners[2])); 
		imagecopy ( $img_frame, $im_corners[3], $this->frame_width  - $this->frame_borderwidth, $this->frame_height - $this->frame_borderwidth, 0, 0, imagesx($im_corners[3]), imagesy($im_corners[3])); 

		//border colors if difference
		if($this->frame_bordercolors) {
			$points_top = array(0,0,$this->frame_width,0,$this->frame_width-$this->frame_borderwidth,$this->frame_borderwidth,$this->frame_borderwidth,$this->frame_borderwidth);
			$points_left = array(0,0,$this->frame_borderwidth,$this->frame_borderwidth,$this->frame_borderwidth,$this->frame_height-$this->frame_borderwidth,0,$this->frame_height,0,0);
			$points_right = array($this->frame_width,0,$this->frame_width,$this->frame_height,$this->frame_width-$this->frame_borderwidth,$this->frame_height-$this->frame_borderwidth,$this->frame_width-$this->frame_borderwidth,$this->frame_borderwidth,$this->frame_width,0,$this->frame_width);
			$points_bottom = array(0,$this->frame_height,$this->frame_width,$this->frame_height,$this->frame_width-$this->frame_borderwidth,$this->frame_height-$this->frame_borderwidth,$this->frame_borderwidth,$this->frame_height-$this->frame_borderwidth,0,$this->frame_height);
			$color[T] = imagecolorallocate($img_frame, $this->frame_bordercolors[0][R], $this->frame_bordercolors[0][G], $this->frame_bordercolors[0][B]); 
			$color[L] = imagecolorallocate($img_frame, $this->frame_bordercolors[1][R], $this->frame_bordercolors[1][G], $this->frame_bordercolors[1][B]); 
			$color[R] = imagecolorallocate($img_frame, $this->frame_bordercolors[2][R], $this->frame_bordercolors[2][G], $this->frame_bordercolors[2][B]); 
			$color[B] = imagecolorallocate($img_frame, $this->frame_bordercolors[3][R], $this->frame_bordercolors[3][G], $this->frame_bordercolors[3][B]); 
	
			imagefilledpolygon($img_frame, $points_top, 4, $color[T]);
			imagefilledpolygon($img_frame, $points_left, 4, $color[L]);
			imagefilledpolygon($img_frame, $points_right, 4, $color[R]);
			imagefilledpolygon($img_frame, $points_bottom, 4, $color[B]);
		}
		return $img_frame;
		imagedestroy( $img_frame );
	}


	function create_margin() {


		$img_margin = imagecreate(	$this->pic_width + 2 * $this->frame_marginwidth + 1, 
									$this->pic_height + 2 * $this->frame_marginwidth + 1);

		$margin_width	= imagesx($img_margin);
		$margin_height	= imagesy($img_margin);

		$black 	= imagecolorallocate($img_margin, 0, 0, 0);
		$white 	= imagecolorallocate($img_margin, 255, 255, 255);
		$xwhite 	= imagecolorallocate($img_margin, 254, 255, 253);

		$margin_hexcolor	= $this->hex2rgb($this->frame_margincolor);  
		$margin_color		= imagecolorallocate ($img_margin, $margin_hexcolor[R], $margin_hexcolor[G], $margin_hexcolor[B]);

		imagefill($img_margin, 0, 0, $margin_color);

		if($this->frame_marginshape=="rectangle") {

		imagefilledrectangle(	$img_margin, $this->frame_marginwidth, 
								$this->frame_marginwidth, 
								$margin_width  - $this->frame_marginwidth,
								$margin_height - $this->frame_marginwidth, $red);
		} else if ($this->frame_marginshape=="oval") {
			imagefilledellipse($img_margin, $margin_width/2, $margin_height/2, $this->pic_width, $this->pic_height, $xwhite);
		}

		imagecolortransparent($img_margin, $xwhite);

		$grad = $this->arraygradient($this->frame_margincolor, "#000000", $this->frame_marginliner+5);

        $colors = $this->arraycolor($img_margin, $grad);

		for($i=0 ; $i < $this->frame_marginliner; $i++) {

			if($this->frame_marginshape=="rectangle") {
				imagerectangle(	$img_margin, $this->frame_marginwidth+$i, 
								$this->frame_marginwidth+$i, 
								$margin_width - $this->frame_marginwidth-$i,
								$margin_height - $this->frame_marginwidth-$i, $colors[$i]);
			} else if ($this->frame_marginshape=="oval") {
				imageellipse($img_margin, $margin_width/2, $margin_height/2, ($this->pic_width)-$i, ($this->pic_height)-$i, $colors[$i]);
			}
		}

		return $img_margin;
		imagedestroy( $img_margin );
	}

	function get_imagetype($file) {

		$acceptable = array("jpg","jpeg","gif","png");
		/* ask the image type */
		$file_info  = pathinfo($file);
		$extension  = $file_info["extension"];
		
		if(in_array($extension,$acceptable))
			return $extension;
		else
			return null;
	}

	function hex2rgb($color) {

		$color = str_replace('#', '', $color);
		$ret = array(
			'R' => hexdec(substr($color, 0, 2)),
			'G' => hexdec(substr($color, 2, 2)),
			'B' => hexdec(substr($color, 4, 2))
		);
		return $ret;
	}

	function rgb2hex($color) {

		return sprintf('%02X%02X%02X',$color[R],$color[G],$color[B]);
		
	}


    function arraygradient($fadefrom, $fadeto, $steps) { 

		$to = $this->hex2rgb($fadeto); 
		$from = $this->hex2rgb($fadefrom); 

        $red   = ($to[R] - $from[R]) / ($steps-1);
        $green = ($to[G] - $from[G]) / ($steps-1);
        $blue  = ($to[B] - $from[B]) / ($steps-1);

        for($i = 0; $i < $steps; $i++) {
            $newred   = $from[R] + round($i * $red);
            $newgreen = $from[G] + round($i * $green);
            $newblue  = $from[B] + round($i * $blue);
            $return[$i] = array('R'=>$newred, 'G'=>$newgreen, 'B'=>$newblue);
        }

        return $return;
    }

	function arraydarkgradient($color,$n) {
			return $this->arraygradient($color, "#000000", $n);

	}
	function arraylightgradient($color,$n) {
			return $this->arraygradient($color, "#FFFFFF", $n);

	}

	function arrayfullgradient($color,$n) {
			$dark	= $this->arraygradient($color, "#000000", $n);
			$light	= array_reverse($this->arraygradient($color, "#FFFFFF", $n));

			return array_merge($light,$dark);

	}

	function arraytwogradient($color1,$color2,$color3,$n) {

			$grad1	= $this->arraygradient($color2, $color1, round($n/2));
			$grad2	= $this->arraygradient($color3, $color2, round($n/2));

			return array_merge($grad1,$grad2);

	}


	function darkcolor($color,$pct) {
			$color = $this->arraydarkgradient($color,100);
			return $color[$pct];
	}

	function lightcolor($color,$pct) {
			$color = $this->arraylightgradient($color,100);
			return $color[$pct];
	}
	
	function fadecolor($color,$pct) {
			$color = $this->arrayfullgradient($color,100);
			return $color[$pct];
	}

	function shiny($color,$n) {

		$grad = $this->arraytwogradient("#FFFFFF", $color, "#FFFFFF", $n);

		$im = imagecreatetruecolor($n,$n);
		$colors = $this->arraycolor($im, $grad);

		for ($y = 0, $i = 0; $y < $n; $y += 1, $i++){
				imageline($im, 0, $y, $n, $y, $colors[$i]);
		}
		return  $im;
	}

	function bevel($color,$n) {

		$grad = $this->arraytwogradient("#000000", $color, "#000000", $n);

		$im = imagecreatetruecolor($n,$n);
		$colors = $this->arraycolor($im, $grad);

		for ($y = 0, $i = 0; $y < $n; $y += 1, $i++){
				imageline($im, 0, $y, $n, $y, $colors[$i]);
		}
		return  $im;
	}

	function gradient($color,$n) {

		$fade 		= 	$this->rgb2hex($this->fadecolor($color,50));

		$grad = $this->arraygradient($color, $fade, $n);

		$im = imagecreatetruecolor($n,$n);

		$colors = $this->arraycolor($im, $grad);

		for ($y = 0, $i = 0; $y < $n; $y += 1, $i++){
				imageline($im, 0, $y, $n, $y, $colors[$i]);
		}
		return  $im;
	}

	function solid($color,$n) {

		$im = imagecreatetruecolor($n,$n);

		for ($y = 0, $i = 0; $y < $n; $y += 1, $i++){

			$grad_color 	= $this->hex2rgb($color);
			$ink_color		= imagecolorallocate ($im, $grad_color['R'], $grad_color['G'], $grad_color['B']);
			imageline($im, 0, $y, $n, $y, $ink_color);
		}
		return  $im;
	}


	function raised($color,$n) {

		$im = $this->solid($color,$n);
		$this->frame_bordercolors[] = $this->darkcolor($color,30);
		$this->frame_bordercolors[] = $this->darkcolor($color,40);
		$this->frame_bordercolors[] = $this->lightcolor($color,40);
		$this->frame_bordercolors[] = $this->lightcolor($color,30);
		
		return  $im;
	}
	
	function sunken($color,$n) {

		$im = $this->solid($color,$n);
		$this->frame_bordercolors[] = $this->lightcolor($color,40);
		$this->frame_bordercolors[] = $this->lightcolor($color,30);
		$this->frame_bordercolors[] = $this->darkcolor($color,30);
		$this->frame_bordercolors[] = $this->darkcolor($color,40);
		
		return  $im;
	}

	function arraycolor($im, $grad) {

        foreach ($grad as $color) {
            $red   = $color['R'];
            $green = $color['G'];
            $blue  = $color['B'];
            $colors[] = imagecolorallocate($im, $red, $green, $blue);
        }
		return $colors;
	}


function image_Rotate($src_img, $angle) {

   $src_x = imagesx($src_img);
   $src_y = imagesy($src_img);
   if ($angle == 90 || $angle == -910) {
       $dest_x = $src_y;
       $dest_y = $src_x;
   } else {
       $dest_x = $src_x;
       $dest_y = $src_y;
   }

   $rotate=imagecreatetruecolor($dest_x,$dest_y);
   imagealphablending($rotate, false);

   switch ($angle) {
       case 90:
           for ($y = 0; $y < ($src_y); $y++) {
               for ($x = 0; $x < ($src_x); $x++) {
                   $color = imagecolorat($src_img, $x, $y);
                   imagesetpixel($rotate, $dest_x - $y - 1, $x, $color);
               }
           }
           break;
       case -90:
           for ($y = 0; $y < ($src_y); $y++) {
               for ($x = 0; $x < ($src_x); $x++) {
                   $color = imagecolorat($src_img, $x, $y);
                   imagesetpixel($rotate, $y, $dest_y - $x - 1, $color);
               }
           }
           break;
       case 180:
           for ($y = 0; $y < ($src_y); $y++) {
               for ($x = 0; $x < ($src_x); $x++) { 
                   $color = imagecolorat($src_img, $x, $y); 
                   imagesetpixel($rotate, $dest_x - $x - 1, $dest_y - $y - 1, $color);
               }
           }
           break;
       default: $rotate = $src_img;
   };
   return $rotate;
}


}
?>