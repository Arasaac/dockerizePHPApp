<?

// Thumbnail creation class by Drazen.Dobrovodski (Drazen@6sense.net)
//GNU General Public License (GPL)
//GD extension required

class thumbnailit{

	function ResizeImg($old_name,$new_name,$wanted_size,$report){

	//check the extension and file size
	$img_file=explode(".",$old_name);
	$target_size=filesize($old_name);

	$type=0;
	if (preg_match("/jpeg|jpg/",$img_file[1])){$type=1; $working_name=imagecreatefromjpeg($old_name);}
	if (preg_match("/png/",$img_file[1])){$type=2; $working_name=imagecreatefrompng($old_name);}
	if (preg_match("/gif/",$img_file[1])){$type=3; $working_name=imagecreatefromgif($old_name);}

	if ($type > 0){	//if the image is one of the 3 supported file types

	//check the pixel size of the original image
	$old_x=imageSX($working_name); 
	$old_y=imageSY($working_name);
	
	if ($report == 1 ){
	print "<center><font size=\"Arial,Hevletica\" size=2>Image <b>$old_name</b> is $old_x x $old_y pixels and $target_size bytes in size.<br>";
	}

	//check if the pixel size of the image is larger than the wanted size - i.e. is there a need to resize it or not
	if ($old_x > $wanted_size || $old_y > $wanted_size){
	
	//check if the image is horizonally or vertically oriented (is it wider or higher)
	if ($old_x > $old_y){$higher_value=$old_x;}
	if ($old_y > $old_x){$higher_value=$old_y;}

	//check the factor by which the original is bigger than the wanted size
	$factor= $higher_value / $wanted_size;

	//calculate the new size of the image
	$new_x=round($old_x / $factor);
	$new_y=round($old_y / $factor);

	//create new blank image of the wanted size
	$new_img=ImageCreateTrueColor($new_x,$new_y);
	//copy the original image content into the blank image
	imagecopyresampled($new_img,$working_name,0,0,0,0,$new_x,$new_y,$old_x,$old_y);

		//delete the old image IF the new name is the same as the old name
		if ($new_name == $old_name){unlink($old_name);}
	
		//save the new image under the given name	
		if ($type==1){imagejpeg($new_img,$new_name);}
		if ($type==2){imagepng($new_img,$new_name);}
		if ($type==3){imagegif($new_img,$new_name);}

	//destroy the working (temporary) images
	imagedestroy($working_name);
	imagedestroy($new_img);

	//check the size of the new image
	$new_size=filesize($new_name);

	if ($report == 1 ){
	print "Image <b>$new_name</b> has been resized to $new_x x $new_y pixels and now has $new_size bytes.<hr>";
	}	
	

	}else{ // if no resize needed because the original image is within the size specified

		//create new blank image of the wanted size
		$new_img=ImageCreateTrueColor($old_x,$old_y);
		//copy the original image content into the blank image
		imagecopyresampled($new_img,$working_name,0,0,0,0,$old_x,$old_y,$old_x,$old_y);

	if(!file_exists($new_name)){ // if the file of a given name doesn't exist

		//save the new image under the given name
		if ($type==1){imagejpeg($new_img,$new_name);}
		if ($type==2){imagepng($new_img,$new_name);}
		if ($type==3){copy ($old_name,$new_name);}
	}else{

		if ($report == 1 ){
		print "<center><font size=\"Arial,Hevletica\" size=2>Image <b>$new_name</b> already exists, and was <b>not</b> overwritten.</font><hr>";
		}
	

	}
		if ($report == 1 ){
		print "<center><font size=\"Arial,Hevletica\" size=2>Image <b>$old_name</b> is already within the given $wanted_size pixels.</font><hr>";
		}

	} // end if no resize needed

	}else{ // if not readable 

	print "<center><font size=\"Arial,Hevletica\" size=2>Image format of file <b>$old_name</b> is not supported.<hr>";

	} // end if not readable


	}

}
?>