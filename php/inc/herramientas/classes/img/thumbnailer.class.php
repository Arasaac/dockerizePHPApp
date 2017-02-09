<?php
  
  /**********************************************************************

   Projectname:   Thumbnailer
   Version:       0.1
   Author:        Pascal Rehfeldt <Pascal@Pascal-Rehfeldt.com>
   Last modified: 24 May 2005
   Copyright (C): 2005 Pascal Rehfeldt, all rights reserved

   * GNU General Public License (Version 2, June 1991)
   *
   * This program is free software; you can redistribute
   * it and/or modify it under the terms of the GNU
   * General Public License as published by the Free
   * Software Foundation; either version 2 of the License,
   * or (at your option) any later version.
   *
   * This program is distributed in the hope that it will
   * be useful, but WITHOUT ANY WARRANTY; without even the
   * implied warranty of MERCHANTABILITY or FITNESS FOR A
   * PARTICULAR PURPOSE. See the GNU General Public License
   * for more details.

   Description:
   Creating Thumbnails from different sources.

  **********************************************************************/
  
  class thumbnailer
  {
  	
  	/**
  	 * @access private
  	 * @var string path to the image
  	 */
  	var $imagepath;
  	
  	/**
  	 * @access private
  	 * @var string temporary directory
  	 */
  	var $tempdir;
  	
  	/**
  	 * @access private
  	 * @var string created thumbnail
  	 */
  	var $image;
  	
  	/**
  	 * @access private
  	 * @var string strategie for creating the tumbnail [gd|im|exif]
  	 */
  	var $strategie;
  	
  	/**
  	 * @access private
  	 * @var string ImageMagick convert command
  	 */
  	var $ImageMagickConvert;
  	
  	/**
  	 * @access private
  	 * @var array occured errors
  	 */
  	var $error;
  	
  	/**
  	 * @access private
  	 * @var integer max. x size of the thumbnail
  	 */
  	var $x;
  	
  	/**
  	 * @access private
  	 * @var integer max. y size of the thumbnail
  	 */
  	var $y;
  	
    /**
     *Constructor
     *
     *@access public
     *@param string image Image to create thumbnail from
     *@param string tempdir Temporary directory
     *@param string strategie How to genereate the tumbnail
     *@param integer x X size of the thumbnail
     *@param integer y Y size of the thumbnail
     *@param string ImageMagickConvert Convert command from ImageMagick
     */
  	function thumbnailer ($image, $tempdir, $strategie = 'gd', $x = 100, $y = 100, $ImageMagickConvert = '')
  	{
  	
  	  $this->imagepath          = $image;
  	  $this->strategie          = $strategie;
  	  $this->ImageMagickConvert = $ImageMagickConvert;
  	  $this->tempdir            = $tempdir;
  	  $this->x                  = $x;
  	  $this->y                  = $y;
  	  
  	  if (is_readable($image) == FALSE)
  	    $this->error[] = 'File ' . $image . ' is not readable!';
  	    
  	  if (is_writable($tempdir) == FALSE)
  	    $this->error[] = 'Tempdir is not writable!';
  	    
  	  if ($this->getImageType() == FALSE)
  	    $this->error[] = 'Imageformat is not supportet!';
  	    
  	  if ($this->error == '')
  	    $this->createThumbnail();
  	
  	}
  	
    /**
     *Depending on the strategie, the thumbnail will be created
     *
     *@access private
     */
  	function createThumbnail ()
  	{

  	  switch ($this->strategie)
  	  {
  	  	
  	  	case 'gd':
  	  	  $this->image = $this->getGDThumbnail();
  	  	break;
  	  	
  	  	case 'im':
  	  	  $this->image = $this->getImageMagickThumbnail();
  	  	break;
  	  	
  	  	case 'exif';
  	  	  $this->image = $this->getExifThumbnail();
  	  	break;
  	  	
  	  	default:
  	  	  $this->error[] = 'Unknown strategie!';
  	  	
  	  }

  	}
  	
    /**
     *Strategie gd: creates the thumbnail using the GD-Lib
     *
     *@access private
     *@return string The created thumbnail
     */
  	function getGDThumbnail ()
  	{
  	
  	  $filename = time() . '.png';
  	
      list($width, $height) = getimagesize($this->imagepath);

      if ($width < $height)
      {
       
        $this->x = $this->y * ($width / $height);
        
      }
      else
      {
      	
        $this->y = $this->x / ($width / $height);
        
      }
        
      if ($this->getImageType() == 'JPEG')
      {
      	
        $source = imagecreatefromjpeg($this->imagepath);
        
      }
      else if ($this->getImageType() == 'PNG')
      {
      	
        $source = imagecreatefrompng($this->imagepath);
        
      }

      $image = imagecreate($this->x, $this->y);
     
      
      imagecopyresized($image, $source, 0, 0, 0, 0, $this->x, $this->y, $width, $height); 	  

      imagepng($image, $this->tempdir . $filename);
      
      $handle = fopen($this->tempdir . $filename, 'rb');

      $image = fread($handle, filesize($this->tempdir . $filename));
     
      fclose($handle);
      
      @unlink($this->tempdir . $filename);      

  	  return $image;
  	
  	}
  	
    /**
     *Strategie im: creating the thumbnail using ImageMagick
     *
     *@access private
     *@return string The created thumbnail
     */
  	function getImageMagickThumbnail ()
  	{

  	  $filename = time() . '.png';
  	  
      $command  = $this->ImageMagickConvert . 
                  ' -quality 100 -sample ' . $this->x . 'x' . $this->y . ' ' .
                  $this->imagepath . ' ' . $this->tempdir . $filename;
                  
      system($command);

      $handle = fopen($this->tempdir . $filename, 'rb');

      $image = fread($handle, filesize($this->tempdir . $filename));
     
      fclose($handle);
      
      @unlink($this->tempdir . $filename);
      
      return $image;
  		
  	}
  	
    /**
     *Strategie exif: getting the thumbnail from EXIF-Metadata
     *
     *@access private
     *@return string The created thumbnail
     */
  	function getExifThumbnail ()
  	{
  		
      $image = @exif_thumbnail($this->imagepath);

      if ($image != FALSE)
      {
        return $image;
        
      }
      else
      {
      	
        $this->error[] = 'The image has no EXIF-Thumbnail!';
        
      }
  		
  	}
  	
    /**
     *Returns the mimetype of the image
     * JPEG or PNG
     *
     *@access private
     *@return string Imagetype
     */
  	function getImageType ()
  	{
  	
  	  $type = @getimagesize($this->imagepath);
  	  
  	  if ($type[2] == 2)
  	  {
  	  	
  	    return 'JPEG';
  	    
  	  }
  	  else if ($type[2] == 3)
  	  {
  	  
  	    return 'PNG';
  	  
  	  }
  	  else
  	  {
  	   
  	    return FALSE;
  	    
  	  }
  	
  	}
  	
    /**
     *Returns the thumbnail to the user
     *
     *@access public
     *@return string created thumbnail
     */
  	function getThumbnail ()
  	{
  	
  	  return $this->image;
  	
  	}
  	
    /**
     *Writes the image to the outbuffer (browser)
     *
     *@access public
     */
  	function showThumbnail()
  	{
  	
  	  header('Content-type: image/png');
  	  echo $this->image;  	
  	
  	}
  	
  	/**
     *Saves the created thumbnail on the server
     *
     *@access public
     *@param string filename Name where the file should be stored
     */
    function saveThumbnail ($filename)
  	{
  	
  	  $handle = fopen($filename, 'a');
  	  
  	  fwrite($handle, $this->image);
  	  
  	  fclose($handle);
  	
  	}
  	
    /**
     *Return an array of occured errors
     *
     *@access public
     */
  	function getErrorMsg ()
  	{ 
  	
  	  return $this->error;
  	
  	}
  	
    /**
     *Outputs the occuered errors as an image
     *
     *@access public
     */
  	function getImageError ()
  	{
      
      header('Content-type: image/png');
      
      $imgheight = (is_array($this->error) == TRUE) ? count($this->error) * 15 + 10 : 25;

      $image = imagecreate(600, $imgheight);
      
      $color = imagecolorallocate($image, 255, 0, 0);
      $text  = imagecolorallocate($image, 0, 0, 0);
      
      if (is_array($this->error) == TRUE)
      {
      
        $y = 5;
        $i = 0;
      
        foreach ($this->error as $error)
        {

          imagestring ($image, 5, 5, $y, 'Error[' . $i++ . ']: ' . $error, $text);
        
          $y = $y + 15;

        }
      
      }
      else
      {
      
        imagestring ($image, 5, 5, 5, 'Thumbnail[0]: No error occured.', $text);
        
      }

      imagepng($image);    
    
  	}
  	
  }
  
?>
