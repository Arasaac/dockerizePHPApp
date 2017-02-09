<?php
/**
* PHP Flash Slide Show
*
* Create simple flash slideshow from sequences of JPEG images
* Requirement:
* You MUST have PHP with Ming installed as PHP Extension
* see http://ming.sourceforge.net and http://php.net/manual/en/ref.ming.php
* Ask your web server administrator if you don't know how to install it
*
* @author Adi Setiawan <http://ex3me.org> adisetiawan@gmail.com
* @license GNU/GPL
* @version 0.2
*/


class flashSlideShow
{
	//initiate needed variables
	var $movie;
	var $i;
	var $width;
	var $height;
	var $bgred;
	var $bggreen;
	var $bgblue;
	var $interval;
	
	/**
	* Constructor
	*
	* Create new object
	*
	* @access	public
	* @param	integer		$width		movie width in pixel
	* @param	integer		$height		movie height in pixel
	* @param	integer		$interval	interval in second, between each image
	* @param	string		$bgcolor	movie background color in hex
	* @return	void
	*/
	function flashSlideShow($width, $height, $interval = 1, $bgcolor = '#FFFFFF') 
	{
		$this->width = $width;
		$this->height = $height;
		
		$this->movie = new swfMovie();
		$this->movie->setDimension($width, $height);
		$this->movie->setRate(10);
		
		$this->setBgColor($bgcolor);
		$this->setInterval($interval);
	}
	
	/**
	* Set slideshow interval
	*
	* Set slideshow interval between each image. interval in seconds
	*
	* @access	public
	* @param	integer		$interval	interval in seconds
	* @return	void
	*/
	function setInterval($interval) 
	{
		if (is_int($interval) AND $interval >= 1) {
			$this->interval = $interval*10;
		} else {
			$this->interval = 10;
		}
	}
	
	/**
	* Set background color
	*
	* Set background color in hex
	*
	* @access	public
	* @param	string		$bgcolor	movie background color in hex
	* @return	void
	*/
	function setBgColor($bgcolor) 
	{
		$this->bgred   = hexdec(substr($bgcolor,0,2));
		$this->bggreen = hexdec(substr($bgcolor,2,2));
		$this->bgblue  = hexdec(substr($bgcolor,4,2));
	}
	
	/**
	* Set background color in RGB Format
	*
	* Set background color in RGB Format
	*
	* @access	public
	* @param	integer		$red	Red RGB Format Value for background color
	* @param	integer		$green	Green RGB Format Value for background color
	* @param	integer		$blur	Blue RGB Format Value for background color
	* @return	void
	*/
	function setBgColorRGB($red,$green,$blue) 
	{
		$this->bgred   = $red;
		$this->bggreen = $green;
		$this->bgblue  = $blue;
	}
	
	/**
	* Add image to slideshow
	*
	* Add one JPEG file to flash slideshow
	*
	* @access	public
	* @param	string		$filename	JPEG filename
	* @return	void
	*/
	function addImage($filename) 
	{
		//$this->movie->add(new SWFBitmap(fopen($filename, "rb")));
		
		//create image object
		$b = new SWFBitmap(fopen($filename,'rb')); 
 		$s = new SWFShape(); 
 		$s->setRightFill($s->addFill($b)); 
 		$s->drawLine($this->width, 0); 
 		$s->drawLine(0, $this->height); 
 		$s->drawLine(-$this->width, 0); 
		$s->drawLine(0, -$this->height);
		
		//transition white to image
		$this->i = $this->movie->add($s);
		$r = 255;
		for($n=0; $n<=5; ++$n) { 
		   //$i->multColor(1.0-$n/10, 1.0, 1.0); 
		   //$i->addColor(0xff*$n/20, 0, 0); 
		   $this->i->addColor($r-30, $r-30, $r-30); 
		   $this->movie->nextFrame(); 
		   $r = $r - 30;
		}
		
		//static image
		$this->i = $this->movie->add($s);
		$this->addInterval();
		
		//transition image to white
		$r = 0;
		for($n=0; $n<=5; ++$n) 
		{ 
		   //$i->multColor(1.0-$n/10, 1.0, 1.0); 
		   //$i->addColor(0xff*$n/20, 0, 0); 
		   $this->i->addColor($r+30, $r+30, $r+30); 
		   $this->movie->nextFrame(); 
		   $r = $r +30;
		} 
	}
	
	/**
	* Add array of image to slideshow
	*
	* Add array of JPEG files to flash slideshow
	*
	* @access	public
	* @param	array		$filename	array of JPEG files
	* @return	void
	*/
	function addImages($filearray) 
	{
		foreach($filearray as $key => $val) {
			$this->addImage($val);
		}
	}
	
	/**
	* Add interval between each image
	*
	* Add interval between each image
	*
	* @access	private
	* @return	void
	*/
	function addInterval() 
	{
		$i = 1;
		while ($i <= $this->interval) {
			$this->movie->nextFrame();
			$i++;
		}
	}

	/**
	* Save movie
	*
	* Save movie
	*
	* @access	public
	* @param	string		$filename	name of movie file to saved
	* @return	void
	*/
	function save($filename) 
	{
		$this->movie->save($filename);
	}
	
	/**
	* Output movie
	*
	* output movie immediatelly
	*
	* @access	public
	* @return	void
	*/
	function output() 
	{
		header("Content-Type:application/x-shockwave-flash");
		$this->movie->output();
	}
}
?>
