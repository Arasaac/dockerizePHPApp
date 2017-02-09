<?php 

        $image = imagecreatefrompng("prueba4.png"); 
		//$image = imagecreatefromgif("prueba4.gif");

        $colorToChange = "FFFFFF"; 
        $newColor = "FF0000"; 

        $c1 = sscanf($colorToChange,"%2x%2x%2x"); 
        $c2 = sscanf($newColor ,"%2x%2x%2x"); 

        $cIndex = imagecolorexact($image,$c1[0],$c1[1],$c1[2]); 
        imagecolorset($image,$cIndex,$c2[0],$c2[1],$c2[2]); 

        header("Content-Type: image/png"); 
        imagepng($image); 

?> 
