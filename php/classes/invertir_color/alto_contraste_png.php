<?php 

        $file = "prueba3.png"; 
        $colorToChange = "FFFFFF"; 
        $newColor = "FFF000"; 
        $threshold = 10; 

        $image = imagecreatefrompng($file); 
        $width = imagesx($image); 
        $height = imagesy($image); 

        $c1 = sscanf($colorToChange,"%2x%2x%2x"); 
        list($h,$s,$v) = rgbtohsv($c1[0],$c1[1],$c1[2]); 
        $hueToReplace = $h; 
        $c2 = sscanf($newColor,"%2x%2x%2x"); 
        list($h,$s,$v) = rgbtohsv($c2[0],$c2[1],$c2[2]); 
        $newHue = $h; 
        $newSat = $s; 

        for ($y=0;$y<$height;$y++) { 
                for ($x=0;$x<$width;$x++) { 
                        $rgb = imagecolorat($image,$x,$y); 
                        $a = ($rgb >> 24) & 0xFF; 
                        $r = ($rgb >> 16) & 0xFF; 
                        $g = ($rgb >> 8) & 0xFF; 
                        $b = $rgb & 0xFF; 
                        list($h,$s,$v) = rgbtohsv($r,$g,$b); 
                        if ($h >= $hueToReplace) { 
                                $angle = 360-($h-$hueToReplace); 
                        } else { 
                                $angle = 360-($hueToReplace-$h); 
                        } 
                        if ($angle > 180) { $angle = 360-$angle; } 
                        if ($angle <= $threshold) { 
                                $h = $newHue+($h-$hueToReplace); 
                                if ($h<0) { $h+=360; } 
                                if ($h>360) { $h-=360; } 
                                list($r,$g,$b) = hsvtorgb($h,$s,$v); 
                                $color = imagecolorallocatealpha($image,$r,$g,$b,$a); 
                                imagesetpixel($image,$x,$y,$color); 
                        } 
                } 
        } 

        header("Content-Type: image/png"); 
        imagepng($image); 

        //These are PEAR functions from Image_color2 tweaked to suit my coding style. 

        function rgbtohsv($r,$g,$b) { 
        
        $r=$r/255; $g=$g/255; $b=$b/255; 

        $min = min($r, $g, $b); 
        $max = max($r, $g, $b); 

        switch ($max) { 
                        case 0: 
                                $h = $s = $v = 0; 
                                break; 
                        case $min: 
                                $h = $s = 0; 
                                $v = $max; 
                                break; 
                        default: 
                                $delta = $max - $min; 

                                if( $r == $max ) { 
                                        $h = 0 + ( $g - $b ) / $delta; 
                                } else if( $g == $max ) { 
                                        $h = 2 + ( $b - $r ) / $delta; 
                                } else { 
                                        $h = 4 + ( $r - $g ) / $delta; 
                                } 
                                $h *= 60; 
                                if($h < 0 ) { 
                                        $h += 360; 
                                } 
                                $s = $delta / $max; 
                                $v = $max; 
        } 
        return array($h, $s, $v); 
        } 

        function hsvtorgb( $h,$s,$v ) { 
        
        if ($s == 0) { 
            $r = $g = $b = $v; 
        } else { 
            $h = $h / 60.0; 
            $s = $s; 
            $v = $v; 

            $hi = floor($h); 
            $f = $h - $hi; 
            $p = ($v * (1.0 - $s)); 
            $q = ($v * (1.0 - ($f * $s))); 
            $t = ($v * (1.0 - ((1.0 - $f) * $s))); 

                        switch( $hi ) { 
                                case 0: $r = $v; $g = $t; $b = $p; break; 
                                case 1: $r = $q; $g = $v; $b = $p; break; 
                                case 2: $r = $p; $g = $v; $b = $t; break; 
                                case 3: $r = $p; $g = $q; $b = $v; break; 
                                case 4: $r = $t; $g = $p; $b = $v; break; 
                                default: $r = $v; $g = $p; $b = $q; break; 
                        } 
        } 
        
        return array( 
            (integer) ($r * 255 + 0.5), 
            (integer) ($g * 255 + 0.5), 
            (integer) ($b * 255 + 0.5) 
        ); 
        
        } 

?>