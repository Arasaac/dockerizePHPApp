<?php 

        $image = imagecreatefromjpeg("prueba.jpg"); 
        $width = imagesx($image); 
        $height = imagesy($image); 

        $colorToChange = "FFFFFF"; 
        $newColor = "FFF000"; 

        $c1 = sscanf($colorToChange,"%2x%2x%2x"); 
        $c2 = sscanf($newColor,"%2x%2x%2x"); 
        
        $cnew = imagecolorallocate($image,$c2[0],$c2[1],$c2[2]); 

        for ($y=0;$y<$height;$y++) { 
                for ($x=0;$x<$width;$x++) { 
                        $rgb = imagecolorat($image,$x,$y); 
                        $r = ($rgb >> 16) & 0xFF; 
                        $g = ($rgb >> 8) & 0xFF; 
                        $b = $rgb & 0xFF; 
                        if (($r==$c1[0]) && ($g==$c1[1]) && ($b==$c1[2])) { 
                                imagesetpixel($image,$x,$y,$cnew); 
                        } 
                } 
        } 
        
        header("Content-Type: image/png"); 
        imagepng($image); 

?>