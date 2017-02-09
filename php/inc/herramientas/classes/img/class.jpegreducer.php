<?php
/**
 * JPEGReducer class version 1
 * 25 November 2004
 * reduce size of jpeg file on the fly
 * Author: huda m elmatsani
 * Email : justhuda ## netscape ## net
 *
 * Description:
 * Usually we reduce the size of jpeg file by changing the quality factor,
 * as provided by imagejpeg() function, but with this method we can not
 * produce the image with expected file size easyly.
 * JPEGReducer class can help us to reduce image size with easy
 * by setting file size as variable.
 *
 * sintax:
 * $im = new JPEGReducer(jpeg_file_path, expected_size);
 *
 * example
 * $im = new JPEGReducer("jakarta.jpg",15000);
 * $im->OutputImage();
 *
 */

Class JPEGReducer {

    var $imgname;
    var $imgsize;
    var $orgsize;

    function JPEGReducer($imgname,$imgsize) {
        $this->imgname = $imgname;
        $this->imgsize = $imgsize;
        $this->orgsize = filesize($imgname);
    }

    function AcceptedSize() {
        if($this->imgsize < $this->orgsize) return 1;
        else return 0;
    }
    //courtesy vic at zymsys dot com
    function LoadJpeg () {
        $imgname = $this->imgname;

        $im = @imagecreatefromjpeg ($imgname); /* Attempt to open */
        if (!$im) { /* See if it failed */
    	   $im  = imagecreate (150, 30); /* Create a blank image */
    	   $bgc = imagecolorallocate ($im, 255, 255, 255);
    	   $tc  = imagecolorallocate ($im, 0, 0, 0);
    	   imagefilledrectangle ($im, 0, 0, 150, 30, $bgc);
    	   /* Output an errmsg */
    	   imagestring ($im, 1, 5, 5, "Error loading $imgname", $tc);
        }
        return $im;
    }

    function CalculateQFactor()  {

        $im   = $this->LoadJpeg();
        $size = $this->imgsize;

        //create sample data of 75%, 50%, and 25% quality
        ob_start();
        imagejpeg($im,'',75);
        $buff75 = ob_get_contents();
        ob_end_clean();

        ob_start();
        imagejpeg($im,'',50);
        $buff50 = ob_get_contents();
        ob_end_clean();

        ob_start();
        imagejpeg($im,'',25);
        $buff25 = ob_get_contents();
        ob_end_clean();

        //calculate size of each image
        $size75 = strlen($buff75);
        $size50 = strlen($buff50);
        $size25 = strlen($buff25);

        //calculate gradient of size reduction by quality
        $mgrad1 = 25/($size50-$size25);
        $mgrad2 = 25/($size75-$size50);
        $mgrad3 = 50/($size75-$size25);
        $mgrad  = ($mgrad1+$mgrad2+$mgrad3)/3;

        //result of approx. quality factor for expected size
        return round($mgrad*($size-$size50)+50);
    }


    function OutputImage() {

        $im         = $this->LoadJpeg();
        header("Content-type: image/jpeg");
        if($this->AcceptedSize()){
            $Qfactor    = $this->CalculateQFactor();
            imagejpeg($im,'',$Qfactor);
        }
        else imagejpeg($im);
        imagedestroy($im);

    }

    function SaveImage($imgname) {

        $im         = $this->LoadJpeg();
        if($this->AcceptedSize()){
            $Qfactor    = $this->CalculateQFactor();
            imagejpeg($im,$imgname,$Qfactor);
        }
        else imagejpeg($im,$imgname);
        imagedestroy($im);
    }
}
?>