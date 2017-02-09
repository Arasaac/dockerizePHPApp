<?php
 
 function invert_image($input,$output,$color=false,$type='jpeg')
 {
     if($type == 'jpeg') { $bild = imagecreatefromjpeg($input); }
     else { $bild = imagecreatefrompng($input); }
  
     $x = imagesx($bild);
     $y = imagesy($bild);
  
     for($i=0; $i<$y; $i++)
     {
         for($j=0; $j<$x; $j++)
         {
             $pos = imagecolorat($bild, $j, $i);
             $f = imagecolorsforindex($bild, $pos);
             if($color == true)
             {
				 $col = imagecolorresolve($bild, 255-$f['red'], 255-$f['green'], 255-$f['blue']);
             }else{
                 $gst = $f['red']*0.15 + $f['green']*0.5 + $f['blue']*0.35;
                 $col = imagecolorclosesthwb($bild, 255-$gst, 255-$gst, 255-$gst);
            }
             imagesetpixel($bild, $j, $i, $col);
         }
     }
    if(empty($output)) { header('Content-type: image/'.$type); } else { $output=$output; }
	
    if($type == 'jpeg') { imagejpeg($bild,$output,90); }
    else { imagepng($bild,$output); } 
}

$input = 'prueba4.png';

// for a color negative image, set the optional flag
invert_image($input,'pruebas444.png',true,'png');
 
// for a black and withe negative image use like this
//
// invert_image($input,'');

// if you want to save the output instead of just showing it,
// set the output to the path where you want to save the inverted image
//
// invert_image('path/to/original/image.jpg','path/to/save/inverted-image.jpg');

// if you want to use png you have to set the color flag as
// true or false and define the imagetype in the function call
//
// invert_image('path/to/image.png','',false,'png');
 ?>