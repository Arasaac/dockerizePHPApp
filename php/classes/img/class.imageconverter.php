<?php
class ImageConverter {

	var $imtype;
	var $im;
	var $imname;
	var $imconvertedtype;
	var $output;

	function imageConverter() {

		/* parse arguments */
		$numargs 		= func_num_args();
		$imagefile  	= func_get_arg(0);
		$convertedtype 	= func_get_arg(1);
		$ruta= func_get_arg(2);
		$this->output 	= 0;

		/* ask the type of original file */
		$fileinfo  		= pathinfo($imagefile);
		$imtype 		= $fileinfo["extension"];
		$this->imname 	= basename($fileinfo["basename"],".".$imtype);
		$this->imtype	= $imtype;
		$this->ruta     = $ruta;

		/* create the image variable of original file */
		switch ($imtype) {
		case "gif":
			$this->im 	=  imageCreateFromGIF($imagefile);
			break;
		case "jpg":
			$this->im 	=  imageCreateFromJPEG($imagefile);
			break;
		case "png":
			$this->im 	=  imageCreateFromPNG($imagefile);
			break;
		case "wbmp":
			$this->im 	=  imageCreateFromWBMP($imagefile);
			break;
		/*
		mail me if you have/find this functionality bellow  */
		/*
		case "swf":
			$this->im 	= $this->imageCreateFromSWF($imagefile);
			break;
		*/
		}

		/* convert to intended type */
		$this->convertImage($convertedtype);
	}

	function convertImage($type) {

		/* check the converted image type availability,
		   if it is not available, it will be casted to jpeg :) */
		$validtype = $this->validateType($type);


		if($this->output) {

			/* show the image  */
			switch($validtype){
				case 'jpeg' :
				case 'jpg' 	:
					header("Content-type: image/jpeg");
					if($this->imtype == 'gif' or $this->imtype == 'png') {
						$image = $this->replaceTransparentWhite($this->im);
						imageJPEG($image);
					} else
					imageJPEG($this->im);
					break;
				case 'gif' :
					header("Content-type: image/gif");
					imageGIF($this->im);
					break;
				case 'png' :
					header("Content-type: image/png");
					imagePNG($this->im);
					break;
				case 'wbmp' :
					header("Content-type: image/vnd.wap.wbmp");
					imageWBMP($this->im);
					break;
				case 'swf' :
					header("Content-type: application/x-shockwave-flash");
					$this->imageSWF($this->im);
					break;
			}

		} else {
			/* save the image  */
			switch($validtype){
				case 'jpeg' :
				case 'jpg' 	:
					if($this->imtype == 'gif' or $this->imtype == 'png') {
						/* replace transparent with white */
						$image = $this->replaceTransparentWhite($this->im);
						imageJPEG($image,$this->ruta.$this->imname.".jpg");
					} else
					imageJPEG($this->im,$this->ruta.$this->imname.".jpg");
					break;
				case 'gif' :
					imageGIF($this->im,$this->ruta.$this->imname.".gif");
					break;
				case 'png' :
					imagePNG($this->im,$this->ruta.$this->imname.".png");
					break;
				case 'wbmp' :
					imageWBMP($this->im,$this->ruta.$this->imname.".wbmp");
					break;
				case 'swf' :
					$this->imageSWF($this->im,$this->ruta.$this->imname.".swf");
					break;

			}

		}
	}

	/* convert image to SWF  */
	function imageSWF() {

		/* parse arguments */
		$numargs = func_num_args();
		$image   = func_get_arg(0);
		$swfname = "";
		if($numargs > 1) $swfname = func_get_arg(1);

		/* image must be in jpeg and
		   convert jpeg to SWFBitmap
		   can be done by buffering it */
		ob_start();
		imagejpeg($image);
		$buffimg = ob_get_contents();
		ob_end_clean();

		$img 	= new SWFBitmap($buffimg);

		$w = $img->getWidth();
		$h = $img->getHeight();

		$movie = new SWFMovie();
		$movie->setDimension($w, $h);
		$movie->add($img);

		if($swfname)
			$movie->save($swfname);
		else
			$movie->output;

	}


	/* convert SWF to image  */
	function imageCreateFromSWF($swffile) {

		die("No SWF converter in this library");

	}

	function validateType($type) {
		/* check image type availability*/
		$is_available = FALSE;

		switch($type){
			case 'jpeg' :
			case 'jpg' 	:
				if(function_exists("imagejpeg"))
				$is_available = TRUE;
				break;
			case 'gif' :
				if(function_exists("imagegif"))
				$is_available = TRUE;
				break;
			case 'png' :
				if(function_exists("imagepng"))
				$is_available = TRUE;
				break;
			case 'wbmp' :
				if(function_exists("imagewbmp"))
				$is_available = TRUE;
				break;
			case 'swf' :
				if(class_exists("swfmovie"))
				$is_available = TRUE;
				break;
		}
		if(!$is_available && function_exists("imagejpeg")){
			/* if not available, cast image type to jpeg*/
			return "jpeg";
		}
		else if(!$is_available && !function_exists("imagejpeg")){
		   die("No image support in this PHP server");
		}
		else
			return $type;
	}

	function replaceTransparentWhite($im){
		$src_w = ImageSX($im);
		$src_h = ImageSY($im);
		$backgroundimage = imagecreatetruecolor($src_w, $src_h);
		$white =  ImageColorAllocate ($backgroundimage, 255, 255, 255);
		ImageFill($backgroundimage,0,0,$white);
		ImageAlphaBlending($backgroundimage, TRUE);
		imagecopy($backgroundimage, $im, 0,0,0,0, $src_w, $src_h);
		return $backgroundimage;
	}
}
?>